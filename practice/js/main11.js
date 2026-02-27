console.log("*** １１．オブジェクト 「記法、メソッドの呼び出し」 ***");
const user = {
  name: "太郎",
  age: 20,
  say1: function () {
    console.log(this.name); //thisはuserを指します
  },
  say2() {
    // メソッド定義はこちらでもOK
    console.log(this.name);
  },
};
user.say1();
user.say2();

console.log("*** １１．オブジェクト 「分割代入」 ***");
const o = { p: 42, q: true };
const { p: a, q: b } = o;
console.log(a); // 42
console.log(b); // true

console.log("*** １１．オブジェクト 「Mathオブジェクト」 ***");
console.log(Math.random()); //0~1.0未満の乱数がランダムで表示
console.log(Math.ceil(5.4)); //6
console.log(Math.floor(5.4)); //5
console.log(Math.round(5.4)); //5
console.log(Math.floor(Math.random() * 20)); //0~19のうちの整数の乱数を生成

console.log("*** １１．オブジェクト 「JSON」 ***");
const student = {
  name: "太郎",
  age: 20,
  gender: "男性",
  skills: ["html", "css", "js"],
  wife: null,
};
const json = JSON.stringify(student);
console.log(student);
console.log(json);

console.log("*** １１．オブジェクト 「問題」 ***");
const school = {
  name: "COACHTECH",
  month: 2,
  skills: ["html", "css", "js", "Vue.js", "php", "Laravel"],
  createSentense() {
    return (
      this.name + "は" +
      this.month + "ヶ月で" +
      this.skills[0] + "と" +
      this.skills[1] + "と" +
      this.skills[2] + "と" +
      this.skills[3] + "と" +
      this.skills[4] + "と" +
      this.skills[5] + "を" +
      "学ぶことができます"
    );
  },
};
console.log(school.createSentense());
