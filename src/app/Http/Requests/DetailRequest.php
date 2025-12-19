<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class DetailRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'clock_in'  => 'required',
            'clock_out' => 'required|after_or_equal:clock_in',
            'reason'    => 'required',

            // 配列として送られる休憩も一応 required にしておく（任意）
            'breaks.*.start' => 'nullable',
            'breaks.*.end'   => 'nullable',

            'extra_break.start' => 'nullable',
            'extra_break.end'   => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'clock_in.required'  => '出勤時間を入力してください',
            'clock_out.required' => '退勤時間を入力してください',
            'clock_out.after_or_equal' => '出勤時間もしくは退勤時間が不適切な値です',
            'reason.required'    => '備考を記入してください',
        ];
    }

    /**
     * 休憩時間の相関バリデーション
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $clockIn  = $this->input('clock_in');
            $clockOut = $this->input('clock_out');

            if (!$clockIn || !$clockOut) {
                return;
            }

            $clockIn  = \Carbon\Carbon::createFromFormat('H:i', $clockIn);
            $clockOut = \Carbon\Carbon::createFromFormat('H:i', $clockOut);

            foreach ($this->input('breaks', []) as $index => $break) {

                $start = $break['start'] ?? null;
                $end   = $break['end']   ?? null;

                // 入りだけある → 戻り必須
                if ($start && !$end) {
                    $validator->errors()->add(
                        "breaks.$index.end",
                        '休憩戻り時刻を入力してください'
                    );
                    continue;
                }

                // 戻りだけある → 入り必須
                if (!$start && $end) {
                    $validator->errors()->add(
                        "breaks.$index.start",
                        '休憩入り時刻を入力してください'
                    );
                    continue;
                }

                // 両方空 → スキップ
                if (!$start && !$end) {
                    continue;
                }

                $startTime = \Carbon\Carbon::createFromFormat('H:i', $start);
                $endTime   = \Carbon\Carbon::createFromFormat('H:i', $end);

                // 【入り】が 出勤より前
                if ($startTime->lt($clockIn)) {
                    $validator->errors()->add(
                        "breaks.$index.start",
                        '休憩時間が不適切な値です'
                    );
                }

                // 【入り】が 退勤より後
                if ($startTime->gt($clockOut)) {
                    $validator->errors()->add(
                        "breaks.$index.start",
                        '休憩時間が不適切な値です'
                    );
                }

                // 【戻り】が 入りより前
                if ($endTime->lt($startTime)) {
                    $validator->errors()->add(
                        "breaks.$index.end",
                        '休憩戻り時刻は休憩入り時刻以降にしてください'
                    );
                }

                // 【戻り】が 退勤より後
                if ($endTime->gt($clockOut)) {
                    $validator->errors()->add(
                        "breaks.$index.end",
                        '休憩時間もしくは退勤時間が不適切な値です'
                    );
                }
            }

            /**
             * 休憩２（extra_break）を完全分離
             */
            $extra = $this->input('extra_break', []);

            if (!empty($extra['start']) || !empty($extra['end'])) {

                if (empty($extra['start'])) {
                    $validator->errors()->add(
                        "extra_break.start",
                        '休憩入り時刻を入力してください'
                    );
                }

                if (empty($extra['end'])) {
                    $validator->errors()->add(
                        "extra_break.end",
                        '休憩戻り時刻を入力してください'
                    );
                }

                if (!empty($extra['start']) && !empty($extra['end'])) {

                    $startTime = \Carbon\Carbon::createFromFormat('H:i', $extra['start']);
                    $endTime   = \Carbon\Carbon::createFromFormat('H:i', $extra['end']);

                    if ($startTime->lt($clockIn)) {
                        $validator->errors()->add(
                            "extra_break.start",
                            '休憩時間が不適切な値です'
                        );
                    }

                    if ($startTime->gt($clockOut)) {
                        $validator->errors()->add(
                            "extra_break.start",
                            '休憩時間が不適切な値です'
                        );
                    }

                    if ($endTime->lt($startTime)) {
                        $validator->errors()->add(
                            "extra_break.end",
                            '休憩戻りは休憩入り時刻以降にしてください'
                        );
                    }

                    if ($endTime->gt($clockOut)) {
                        $validator->errors()->add(
                            "extra_break.end",
                            '休憩時間もしくは退勤時間が不適切な値です'
                        );
                    }
                }
            }

            /**
             * 休憩の重なりチェック（breaks + extra_break 対応・1メッセージ化）
             */
            $breaks = [];

            // 通常休憩を「元の index 付き」で保存
            foreach ($this->input('breaks', []) as $i => $row) {
                if (!empty($row['start']) && !empty($row['end'])) {
                    $breaks[] = [
                        'key'   => "breaks.$i.end", // ← エラー表示先
                        'start' => Carbon::createFromFormat('H:i', $row['start']),
                        'end'   => Carbon::createFromFormat('H:i', $row['end']),
                    ];
                }
            }

            // 追加休憩（休憩2）
            $extra = $this->input('extra_break', []);
            if (!empty($extra['start']) && !empty($extra['end'])) {
                $breaks[] = [
                    'key'   => "extra_break.end", // ← エラー表示先
                    'start' => Carbon::createFromFormat('H:i', $extra['start']),
                    'end'   => Carbon::createFromFormat('H:i', $extra['end']),
                ];
            }

            // 1件以下なら重なり判定不要
            if (count($breaks) < 2) {
                return;
            }

            // 開始時刻でソート
            $parsed = collect($breaks)->sortBy('start')->values();

            // 重なりチェック本体
            for ($i = 1; $i < $parsed->count(); $i++) {
                $prev = $parsed[$i - 1];
                $current = $parsed[$i];

                if ($current['start']->lt($prev['end'])) {
                    // エラーは「end 側」に1回だけ
                    $validator->errors()->add(
                        $current['key'],
                        '休憩時間が重なっています'
                    );
                }
            }
        });
    }
}
