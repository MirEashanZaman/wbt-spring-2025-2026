var UNIT_PRICE = 400;

var quantityInput = document.getElementById('quantity');
var totalPriceInput = document.getElementById('totalPrice');
var errorMsg = document.getElementById('errorMsg');

var couponAlertShown = false;

quantityInput.addEventListener('input', function () {
  var qty = parseInt(quantityInput.value);

  if (isNaN(qty) || qty < 0) {
    quantityInput.value = 0;
    qty = 0;
    errorMsg.style.display = 'block';
  } else {
    errorMsg.style.display = 'none';
  }

  var total = UNIT_PRICE * qty;
  totalPriceInput.value = total;

  if (total > 1000) {
    if (!couponAlertShown) {
      couponAlertShown = true;
      alert('Congratulations! You are now eligible for Gift Coupon!!');
    }
  } else {
    couponAlertShown = false;
  }
});