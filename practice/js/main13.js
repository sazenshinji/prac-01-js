console.log("*** １３．DOM操作 「イベント」 ***");
document.addEventListener("DOMContentLoaded", function () {
  alert("ページが読み込まれました");
});

console.log("*** １３．DOM操作 「イベント- ボタンをクリック」 ***");
const button = document.querySelector("button");
button.addEventListener("click", function () {
  alert("クリックされました");
});
