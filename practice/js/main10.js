console.log("*** １０．スケジューリング 「setTimeout」 ***");
function say(phrase, who) {
  alert(phrase + ", " + who);
}
const timerId = setTimeout(say, 1000, "Hello", "COACHTECH");
                                                    // say関数を1秒後に引数"Hello", "COACHTECH"で呼ぶ
clearTimeout(timerId);       // setTimeoutを即座にキャンセル

console.log("*** １０．スケジューリング 「setInterval」 ***");
function say2() {
  alert("Hello");
}
const timerId2 = setInterval(say2, 1000);  // 1秒間隔でsay2関数を呼ぶ

function stop() {
  clearInterval(timerId2);
}
setTimeout(stop, 5000);
                          // 5秒後にstop関数を呼んでsay2呼び出しをやめる

                          
console.log("*** １０．スケジューリング 「問題」 ***");
let dispTime = 0;
//--- 方法1 ---
function disp() {
  console.log("カウント値＝" + dispTime);
  dispTime++;
}
setInterval(disp, 1000);

//--- 方法2 ---
//setInterval(function () {
//  console.log("カウント値＝" + dispTime);
//  dispTime++;
//}, 1000);
