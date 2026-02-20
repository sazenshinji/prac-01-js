console.log("***２．変数と型*** ");

message = "Hello world";
console.log(message);

message = "Good night world";
console.log(message);

const str1 = "Hello";
let str2 = "Good night";
const str3 = `${str1} world-2`;
var str4 = `${str2} world-3`;
console.log(str3);
console.log(str4);

console.log(typeof 20);
console.log(typeof "str");
console.log(typeof true);
console.log(typeof undefined);

const bool = true;
console.log(typeof bool);
const str = String(bool); //String()で値を文字列に変換することができる
console.log(typeof str);
console.log(str);

const str5 = "123";
console.log(typeof str5);
const num = Number(str5); //Number()で値を数値に変換することができる
console.log(typeof num);

console.log(Boolean(1)); //Boolean()で値をBoolean型に変換することができる
console.log(Boolean(0));
console.log(Boolean("hello"));
console.log(Boolean(""));

console.log("***２．変数と型-問１*** ");
let say = "Hello";
console.log(say);
say = "Goodbye";
console.log(say);
