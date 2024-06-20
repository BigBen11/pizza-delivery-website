/*global
    addPizza, appendChild, createElement, getAttribute, getElementById,
    querySelector, setAttribute, textContent, toFixed, value, window, document, Array, parseFloat
*/

const warenkorb = document.getElementById("warenkorb");
const addressInput = document.querySelector("input[name='Adresse']");
const orderButton = document.getElementById("submit");
const priceOutput = document.getElementById("preisAusgabe");
const resetAllButton = document.querySelector("input[name='Alle_löschen']");
const resetSelectedButton = document.querySelector("input[name='Auswahl_löschen']");

// Add pizza to cart
window.addPizza = function(pizza) {
    "use strict";
    var name = pizza.getAttribute("data-name");
    var price = parseFloat(pizza.getAttribute("data-price"));
    var id = parseFloat(pizza.getAttribute("data-id"));
    var option = document.createElement("option");

    option.value = id;
    option.textContent = name + " - " + price.toFixed(2) + "€";
    option.setAttribute("data-price", price);
    warenkorb.appendChild(option);
    updateTotalPrice();
    validateOrderButton();
};

// Update total price
function updateTotalPrice() {
    "use strict";
    var total = 0;
    var i;
    var option;
    for (i = 0; i < warenkorb.options.length; i += 1) {
        option = warenkorb.options[i];
        total += parseFloat(option.getAttribute("data-price"));
    }
    priceOutput.textContent = total.toFixed(2) + "€";
}

// Validate order button
function validateOrderButton() {
    "use strict";
    var isAddressFilled = addressInput.value.trim() !== "";
    var isCartNotEmpty = warenkorb.options.length > 0;
    orderButton.disabled = !(isAddressFilled && isCartNotEmpty);
}

// Event listeners for input fields
addressInput.addEventListener("input", validateOrderButton);
warenkorb.addEventListener("change", validateOrderButton);

// Delete all items from the cart
resetAllButton.addEventListener("click", function() {
    "use strict";
    while (warenkorb.options.length > 0) {
        warenkorb.remove(0);
    }
    updateTotalPrice();
    validateOrderButton();
});

// Delete selected items from the cart
resetSelectedButton.addEventListener("click", function() {
    "use strict";
    var selectedOptions = Array.from(warenkorb.selectedOptions);
    selectedOptions.forEach(function(option) {
        option.remove();
    });
    updateTotalPrice();
    validateOrderButton();
});

// Automatically select all pizzas before submitting
document.getElementById("myForm").addEventListener("submit", function() {
    "use strict";
    var i;
    for (i = 0; i < warenkorb.options.length; i += 1) {
        warenkorb.options[i].selected = true;
    }
});

// Initialize button state
validateOrderButton();
