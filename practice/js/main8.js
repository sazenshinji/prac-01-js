console.log("*** ８．文字列 「文字列へのアクセス」 ***");
const str = "プログラミング";
// 配列と同じようにインデックスでアクセスできる
console.log(str[0]);
console.log(str[1]);
console.log(str[2]);

console.log("*** ８．文字列 「分解」 ***");
const strings = "HTML・CSS・JavaScript";
const strings1 = "HTML・CSS・JavaScript".split("・");
const strings2 = "・・".split("・");
console.log(strings);
console.log(strings1);
console.log(strings2);

console.log("*** ８．文字列 「結合」 ***");
const strings3 = "HTML・CSS・JavaScript".split("・").join("、");
console.log(strings3);

console.log("*** ８．文字列 「文字列の長さ」 ***");
const strings4 = "プログラミング";
console.log(strings4);
console.log(strings4.length);

console.log("*** ８．文字列 「文字列の比較」 ***");
console.log("プログラミング" === "プログラミング");
console.log("PHP" === "Ruby");

console.log("*** ８．文字列 「文字列の一部を取得」 ***");
const url = "https://example.com?param=1";
const indexOfQuery = url.indexOf("?");
const queryString = url.slice(indexOfQuery);
console.log(queryString);

console.log("*** ８．文字列 「文字列の検索(インデックスを取得)」 ***");
const strings5 = "HTMLとCSSとJavaScriptとPHP";
const indexOfJS = strings5.indexOf("JavaScript");
console.log(indexOfJS);

console.log("*** ８．文字列 「文字列の検索(含まれているか)」 ***");
const strings6 = "HTMLとCSSとJavaScriptとPHP";
console.log(strings6.includes("PHP"));
console.log(strings6.includes("Ruby"));

console.log("*** ８．文字列 「問題)」 ***");
const eventDate = function (inputStr) {
    year = inputStr.slice(0, 4);
    if (inputStr[4] == 0) {
        month = inputStr[5];
    } else {
        month = inputStr.slice(4, 6);
    }
    if (inputStr[6] == 0) {
        date = inputStr[7];
    } else {
        date= inputStr.slice(6, 8);
    }
    Event = inputStr.slice(8);
    return (year+ "年"+ month+ "月"+ date+ "日に"+ Event+ "が開催されました。");
}
console.log(eventDate("20210723東京オリンピック"));

