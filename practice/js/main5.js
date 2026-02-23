console.log("*** ５．配列  問１ ***");
const numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
const result = numbers.map(function (item) {
  if (item % 2 === 0) {
    newItem = item * 2;
  } else {
    newItem = item;
  }
  return newItem;
});
console.log(result);
// 三項演算子
const result2 = numbers.map(function (item) {
  item % 2 === 0 ? (newItem = item * 2) : (newItem = item);
  return newItem;
});
console.log(result2);


console.log("*** ５．配列  問２ ***");
let jpname = ["佐藤", "田中", "鈴木"];
let customer = [];
jpname.map(function (item) {
  customer.push(item + "様");
  return;
});
console.log(jpname);
console.log(customer);


console.log("*** ５．配列  問３ ***");
let food = ["魚", "肉", "肉", "魚"];
const food2 = food.filter(function (item, index) {
  return  food.indexOf(item) == index;
});
console.log(food2);
