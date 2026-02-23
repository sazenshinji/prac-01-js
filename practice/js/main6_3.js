console.log("*** ６．関数 「問題」 ***");

function advice(name, test) {
  if (test >= 70 && test <= 100) {
    return `${name}君良くできました`;
  } else if (test >= 30 && test < 70) {
    return `${name}君普通です`;
  } else if (test >= 0 && test < 30) {
    return `${name}君もう少し頑張りましょう`;
  } else {
    return `正しい数字を入力してください`;
  }
}

console.log(advice("A", 80));
console.log(advice("B", 15));
console.log(advice("C", 50));