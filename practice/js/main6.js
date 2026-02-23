console.log("*** ６．関数 ***");

function vegetable(name, price, func) {
  const pit = func(price); //  priceIncludingTax(price)の実行
  console.log(name + 'の税込価格は' + pit + 'です');
}

// 関数式
const priceIncludingTax = function (price) { // 税込み価格の計算
  const tax = 1.1;
  return Math.floor(price * tax);//Math.floor小数点を切り捨てて整数にする
}
const priceIncludingTaxfood = function (price) {
  // 税込み価格の計算
  const tax = 1.08;
  return Math.floor(price * tax); //Math.floor小数点を切り捨てて整数にする
};

vegetable('店内食 バーガー', 200, priceIncludingTax); // priceIncludingTaxがコールバック関数
vegetable('TO バーガー', 200, priceIncludingTaxfood); // priceIncludingTaxfoodがコールバック関数