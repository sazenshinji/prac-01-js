console.log("*** １２．日付と時刻 「Dateオブジェクト インスタンス生成」 ***");
const dt1 = new Date();
console.log(dt1);
const dt2 = new Date("2020/12/01 12:34:56");
console.log(dt2);
const dt3 = new Date(2020, 0, 15, 22, 30, 30);
console.log(dt3);

console.log("*** １２．日付と時刻 「インスタンスから各種値の取得」 ***");
const dt = new Date();
const year = dt.getFullYear();      // 年
console.log(year);

const month = dt.getMonth() + 1;    // 月
console.log(month);

const date = dt.getDate();          // 日
console.log(date);

//日曜が0、土曜日が6なので配列を使い曜日に変換する。
const dateT = ["日","月","火","水","木","金","土"]
const day = dateT[dt.getDay()];      // 曜日  注意：「getDate()」でなない。 
console.log(day);

const hours = dt.getHours();        // 時
console.log(hours);

const minutes = dt.getMinutes();    // 分
console.log(minutes);

const seconds = dt.getSeconds();    // 秒
console.log(seconds);

