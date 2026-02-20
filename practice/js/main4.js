console.log("***４．条件分岐***");

const price = 1800;

if (price < 1000) {
  console.log("安い");
} else if (price > 2000) {
  console.log("高い");
} else {
  console.log("丁度良い");
}

const quantity = 400;
const banana = quantity <= 300 ? 1 : 2;
console.log(banana);

const person = 3;

switch (person) {
  case 1:
    console.log("太郎さん");
    break;
  case 2:
    console.log("次郎さん");
    break;
  case 3:
    console.log("三郎さん");
    break;
  case 4:
    console.log("四郎さん");
    break;
  case 5:
    console.log("五郎さん");
    break;
}

console.log("***４．条件分岐-問１***");
const price2 = 1000;
const tax = 0.1;
console.log(price2 * tax);

console.log("***４．条件分岐-問２*** ");
const scoreA = 80 + 90 + 60 + 85 + 100;
const scoreB = 40 + 30 + 50 + 25 + 60;
console.log(scoreA);
console.log(scoreB);
if(scoreA >= 300 && scoreB >= 300) {
  console.log('素晴らしい');
} else if (scoreA >= 300 || scoreB >= 300) {
  console.log('普通');
} else {
  console.log('頑張ろう');
}

console.log("***４．条件分岐-問３*** ");
const fortune = '末吉';
switch (fortune) {
  case "大吉":
    console.log("大吉です！");
    break;
  case "中吉":
    console.log("中吉です！");
    break;
  case "小吉":
    console.log("小吉です！");
    break;
  case "吉":
    console.log("吉です！");
    break;
  case "末吉":
    console.log("末吉です！");
    break;
  case "凶":
    console.log("凶です！");
    break;
  case "大凶":
    console.log("大凶です！");
    break;
}

console.log("***４．条件分岐-問４*** ");
const price3 = 1800;
const rating = (price3 < 1000) ? '安い' : (price3 > 2000) ? '高い' : '丁度良い';
console.log(rating);