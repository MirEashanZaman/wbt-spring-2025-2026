const TAX_RATE = 0.05;

const originalPriceInput = document.getElementById("originalPrice");
const discountPercentInput = document.getElementById("discountPercent");
const finalPriceInput = document.getElementById("finalPrice");
const errorMsg = document.getElementById("errorMsg");

function calculate() {

    const priceValue = originalPriceInput.value;
    const discountValue = discountPercentInput.value;

    errorMsg.style.display = "none";
    errorMsg.textContent = "";

    if (priceValue === "" || discountValue === "") {
        errorMsg.textContent = "Please enter both price and discount.";
        errorMsg.style.display = "block";
        return;
    }

    let price = parseFloat(priceValue);
    let discount = parseFloat(discountValue);

    if (price < 0) {
        price = 0;
        originalPriceInput.value = 0;
        errorMsg.textContent = "Price cannot be below 0.";
        errorMsg.style.display = "block";
        return;
    }

    if (discount < 0) {
        discount = 0;
        discountPercentInput.value = 0;
        errorMsg.textContent = "Discount cannot be below 0";
        errorMsg.style.display = "block";
        return;
    }

    if (discount > 100) {
        discount = 100;
        discountPercentInput.value = 100;
        errorMsg.textContent = "Discount cannot exceed 100%";
        errorMsg.style.display = "block";
        return;
    }

    const discountAmount = price * (discount / 100);
    const discountedPrice = price - discountAmount;
    const tax = discountedPrice * TAX_RATE;
    const finalPrice = discountedPrice + tax;

    finalPriceInput.value = finalPrice.toFixed(2);

    if (price > 0 && finalPrice < 500) {
        alert("You unlocked a Budget Deal!");
    }
}

document.getElementById("calcBtn").addEventListener("click", calculate);