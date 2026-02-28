console.log("*** １２．日付と時刻 「day.js 値の取得」 ***");
const year = dayjs().year(); // 年の取得
console.log(year);
const month = dayjs().month() + 1; // 月の取得
console.log(month);
const date = dayjs().date(); // 日の取得
console.log(date);
const day = dayjs().day(); // 曜日の取得
const dayT = ["日", "月", "火", "水", "木", "金", "土"];
console.log(dayT[day]);
const hours = dayjs().hour(); // 時の取得
console.log(hours);
const minutes = dayjs().minute(); // 分の取得
console.log(minutes);
const seconds = dayjs().second(); // 秒の取得
console.log(seconds);

console.log("*** １２．日付と時刻 「day.js－formatメソッド」 ***");
const year2 = dayjs().format("YYYY年"); // 年の取得
console.log(year2);
const month2 = dayjs().format("MM月"); // 月の取得
console.log(month2);
const month3 = dayjs().format("M月"); // 月の取得
console.log(month3);
const date2 = dayjs().format("DD日"); // 日の取得
console.log(date2);
const day2 = dayjs().format("dddd"); // 曜日の取得
console.log(day2);
const hours2 = dayjs().format("HH時"); // 時の取得
console.log(hours2);
const minutes2 = dayjs().format("mm分"); // 分の取得
console.log(minutes2);
const seconds2 = dayjs().format("ss秒"); // 秒の取得
console.log(seconds2);
// まとめて記述。formatメソッド内は自由に文字列を入れることができる。
const today = dayjs().format("YYYY年MM月DD日 dddd HH:mm:ss");
console.log(today);

console.log("*** １２．日付と時刻 「day.js－日付の加算・減算」 ***");
console.log(dayjs().format("YYYY年"));                  //年の加減算
const addYear = dayjs().add(1, "year").format("YYYY年");
console.log(addYear);
const addSubtract = dayjs().subtract(1, "year").format("YYYY年");
console.log(addSubtract);

console.log(dayjs().format("MM月"));                    //月の加減算
const addMonth = dayjs().add(1, "month").format("MM月");
console.log(addMonth);
const addSubtractMonth = dayjs().subtract(1, "month").format("MM月");
console.log(addSubtractMonth);

console.log(dayjs().format("DD日"));                    //日の加減算
const addDay = dayjs().add(1, "day").format("DD日");
console.log(addDay);
const addSubtractDay = dayjs().subtract(1, "day").format("DD日");
console.log(addSubtractDay);

console.log(dayjs().format("HH時"));                    //時の加減算
const addHour = dayjs().add(1, "hour").format("HH時");
console.log(addHour);
const addSubtractHour = dayjs().subtract(1, "hour").format("HH時");
console.log(addSubtractHour);

console.log(dayjs().format("mm分"));                    //分の加減算
const addMinute = dayjs().add(1, "minute").format("mm分");
console.log(addMinute);
const addSubtractMinute = dayjs().subtract(1, "minute").format("mm分");
console.log(addSubtractMinute);

console.log(dayjs().format("ss秒"));                    //秒の加減算
const addSecond = dayjs().add(1, "second").format("ss秒");
console.log(addSecond);
const addSubtractSecond = dayjs().subtract(1, "second").format("ss秒");
console.log(addSubtractSecond);

console.log("*** １２．日付と時刻 「問題」 ***");
function dispTime() {
    const now = dayjs().format("HH:mm:ss");
    console.log(now); 
}
const timerId = setInterval(dispTime, 1000);
