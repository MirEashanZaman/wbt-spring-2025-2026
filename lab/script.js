/*Swap two variables a and b without using a third variable.*/
let a = 5;
let b = 8;

console.log("a =", a);
console.log("b =", b);

a = a + b;
b = a - b;
a = a - b;

console.log("a =", a);
console.log("b =", b);


/*Write square(n) and call it for numbers 1 to 10.*/
function square(n) {
    return n * n;
}

for (let i = 1; i <= 10; i++) {
    console.log(`square(${i}) = ${square(i)}`);
}


/*Find the largest number in an array using a loop.*/
const numbers = [75, 90, 589, 111, 682, 912, 5];

let largest = numbers[0];

for (const num of numbers) {
    if (num > largest) {
        largest = num;
    }
}

console.log(`Largest number= ${largest}`);