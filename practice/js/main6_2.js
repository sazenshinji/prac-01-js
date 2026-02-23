console.log("*** ６．関数 「関数実行例」 ***");

const items = [
  {
    name: "水",
    price: 100,
  },
  {
    name: "リンゴジュース",
    price: 130,
  },
  {
    name: "コーヒー",
    price: 150,
  },
  {
    name: "モンスター",
    price: 200,
  },
  {
    name: "レッドブル(大)",
    price: 250,
  },
];

const buy = function (pay, itemName) {
  const findItem = items.find((i) => i.name == itemName);
  if (!findItem) return console.log("その商品は存在しません。");
  if (pay < findItem.price) return console.log("お金が足りません。");
  const change = pay - findItem.price;
  console.log(findItem.name + "をお買い上げありがとうございます。");
  if (change <= 0) {
    return console.log("お釣りはありません。");
  }
  console.log("お釣りは" + change + "円になります。");
};
