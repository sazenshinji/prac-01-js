console.log("*** ６．関数 「コールバック関数」 ***");

// vegetable()関数の定義。
function vegetable(name, price, func) {
  const pit = func(price); //  priceIncludingTax(price)の実行
  console.log(name + 'の税込価格は' + pit + 'です');
}

// priceIncludingTax()を関数式で定義
const priceIncludingTax = function (price) { // 税込み価格の計算
  const tax = 1.1;
  return Math.floor(price * tax);//Math.floor小数点を切り捨てて整数にする
}
// priceIncludingTaxfood()を関数式で定義
const priceIncludingTaxfood = function (price) {
  // 税込み価格の計算
  const tax = 1.08;
  return Math.floor(price * tax); //Math.floor小数点を切り捨てて整数にする
};

// vegetable()関数の実行。
vegetable('店内食 バーガー', 200, priceIncludingTax); // priceIncludingTaxがコールバック関数
vegetable('TO バーガー', 200, priceIncludingTaxfood); // priceIncludingTaxfoodがコールバック関数

console.log("*** ６．関数 「スコープ 戻り値を使う」 ***");

const globalConst = "globalConst";
let globalLet = "globalLet";

function dummyFunc() {
  const localConst = "localConst";
  let localLet = "localLet";
  return { localConst, localLet };
}

// 分割代入という記法を使用しています。オブジェクトの章で解説します。
const { localConst, localLet } = dummyFunc();

console.log(globalConst);
console.log(globalLet);

// 値の更新
globalLet = "updateGlobalLet";
console.log(globalLet);

console.log(localConst);
console.log(localLet);
