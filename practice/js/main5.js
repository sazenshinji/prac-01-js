console.log("***５．配列***");

const array = [8, 10, 5, 3, 2];

const result = array.filter(function (item) {
  return item % 2 === 1;
});

console.log(result);