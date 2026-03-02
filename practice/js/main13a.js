console.log("*** １３．DOM操作 「問題」 ***");

const button = document.querySelector("button");
button.addEventListener("click", function () {
  const resultP = prompt("クラス名を入力してくださ。");

  document.getElementsByClassName(resultP)[0].style.color = "red";
  // または、以下でも良い。
  // document.querySelector("."+resultP).style.color = "red";
});
