console.log("*** ９．ダイアログ 「alert」 ***");
alert("メッセージ");

console.log("*** ９．ダイアログ 「confirm」 ***");
const result = confirm("メッセージ");
console.log(result);

console.log("*** ９．ダイアログ 「prompt」 ***");
const resultP = prompt("名前を入力してくださ。");
console.log(resultP);


console.log("*** ９．ダイアログ 「問題」 ***");
const result2 = prompt("数字を入力してくださ");
const num = Number(result2);                            // 文字列→数字変換
const result3 = confirm("入力値は" + result2 + "です。");
if (result3 == false) {
  alert("リロードしてやり直してください");              // 確認で[キャンセル]が押された
}
else if (Number.isFinite(num)) {                    // 数字判定
  if (num % 2 === 0) {
    alert("入力値は偶数です。");
  } else {
    alert("入力値は奇数です。");
  }
} else {
  alert("入力された値が不正です");
}
