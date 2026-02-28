console.log("*** １２．日付と時刻 「Dateオブジェクト インスタンス生成」 ***");
const dt1 = new Date();
console.log(dt1);
const dt2 = new Date("2020/12/01 12:34:56");
console.log(dt2);
const dt3 = new Date(2020, 0, 15, 22, 30, 30);
console.log(dt3);

console.log("*** １２．日付と時刻 「インスタンスから各種値の取得」 ***");
const dt = new Date();
const year = dt.getFullYear(); // 年
console.log(year);
const month = dt.getMonth() + 1; // 月
console.log(month);
const date = dt.getDate(); // 日
console.log(date);
//日曜が0、土曜日が6なので配列を使い曜日に変換する。
const dateT = ["日", "月", "火", "水", "木", "金", "土"];
const day = dateT[dt.getDay()]; // 曜日  注意：「getDate()」でなない。
console.log(day);
const hours = dt.getHours(); // 時
console.log(hours);
const minutes = dt.getMinutes(); // 分
console.log(minutes);
const seconds = dt.getSeconds(); // 秒
console.log(seconds);

console.log("*** １２．日付と時刻 「日付の計算」 ***");
const dt4 = new Date();
dt4.setYear(dt4.getFullYear() + 1); // 1年後
console.log(dt4);
dt4.setYear(dt4.getFullYear() - 1); // 1年前
console.log(dt4);
dt4.setMonth(dt4.getMonth() + 1); // 1ヶ月後
console.log(dt4);
dt4.setMonth(dt4.getMonth() - 1); // 1ヶ月前
console.log(dt4);
dt4.setDate(dt4.getDate() + 1); // 1日後
console.log(dt4);
dt4.setDate(dt4.getDate() - 1); // 1日前
console.log(dt4);
dt4.setHours(dt4.getHours() + 1); // 1時間後
console.log(dt4);
dt4.setHours(dt4.getHours() - 1); // 1時間前
console.log(dt4);
dt4.setMinutes(dt4.getMinutes() + 1); // 1分後
console.log(dt4);
dt4.setMinutes(dt4.getMinutes() - 1); // 1分前
console.log(dt4);
dt4.setSeconds(dt4.getSeconds() + 1);   // 1秒後
console.log(dt4);
dt4.setSeconds(dt4.getSeconds() - 1);   // 1秒前
console.log(dt4);
