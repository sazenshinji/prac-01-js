console.log("*** １４．デバッグ方法 「問題」 ***");

document.getElementById("section-2").style.color = "red";

var baseElement = document.getElementById("section-2");
var section2node2 = baseElement.childNodes[5];
section2node2.innerHTML = "子2は変更されました";