console.log("*** ７．繰り返し 「for文」 ***");
const lists = ["太郎", "次郎", "三郎", "四郎", "五郎"];
for (let i = 0; i < lists.length; i++) {
  console.log(lists[i]);
}

console.log("*** ７．繰り返し 「while文」 ***");
let c = 0;
while (c < 10) {
  c = c + 1;
  console.log(c);
}

console.log("*** ７．繰り返し 「do...while文」 ***");
let i = 0;
do {
  console.log(i);
  i++;
} while (i < 6);

console.log("*** ７．繰り返し 「問1」 ***");
let test = ["国語", "数学", "英語"];
test.push("理科");
test.push("社会");
console.log(test);

console.log("*** ７．繰り返し 「問2」 ***");
for (let i = 1; i <= 50; i++){
  if (i % 15 === 0) {
    console.log(i + "FizzBuzz");
  } else if (i % 3 === 0) {
    console.log(i + "Fizz");
  } else if (i % 5 === 0) {
    console.log(i + "Buzz");
  } else {
    console.log(i);
  }
}

console.log("*** ７．繰り返し 「問3」 ***");
let water = 1000;
while (water >= 0) {
  console.log("水の残量は " + water);
  water = water - 180;
}
console.log("水を飲み干した water = " + water);