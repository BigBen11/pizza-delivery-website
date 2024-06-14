

  const warenkorb = document.getElementById('warenkorb');
  const addressInput = document.querySelector('input[name="Adresse"]');
  const orderButton = document.getElementById('submit');
  const priceOutput = document.getElementById('preisAusgabe');
  const resetAllButton = document.querySelector('input[name="Alle_löschen"]');
  const resetSelectedButton = document.querySelector('input[name="Auswahl_löschen"]');

  // Add pizza to cart
  window.addPizza = function(pizza) {
    "use strict";
      const name = pizza.getAttribute('data-name');
      const price = parseFloat(pizza.getAttribute('data-price'));
      const id = parseFloat(pizza.getAttribute('data-id'));

      const option = document.createElement('option');
      option.value = id;
      option.textContent = `${name} - ${price.toFixed(2)}€`;
      option.setAttribute('data-price', price);
      warenkorb.appendChild(option);
      updateTotalPrice();
      validateOrderButton();
  };

  // Update total price
  function updateTotalPrice() {
    "use strict";
      let total = 0;
      for (let option of warenkorb.options) {
          total += parseFloat(option.getAttribute('data-price'));
      }
      priceOutput.textContent = total.toFixed(2) + '€';
  }

  // Validate order button
  function validateOrderButton() {
    "use strict";
      const isAddressFilled = addressInput.value.trim() !== '';
      const isCartNotEmpty = warenkorb.options.length > 0;
      orderButton.disabled = !(isAddressFilled && isCartNotEmpty);
  }

  // Event listeners for input fields
  addressInput.addEventListener('input', validateOrderButton);
  warenkorb.addEventListener('change', validateOrderButton);

  // Delete all items from the cart
  resetAllButton.addEventListener('click', function() {
    "use strict";
      while (warenkorb.options.length > 0) {
          warenkorb.remove(0);
      }
      updateTotalPrice();
      validateOrderButton();
  });

  // Delete selected items from the cart
  resetSelectedButton.addEventListener('click', function() {
    "use strict";
      const selectedOptions = Array.from(warenkorb.selectedOptions);
      selectedOptions.forEach(option => option.remove());
      updateTotalPrice();
      validateOrderButton();
  });

  // Automatically select all pizzas before submitting
  document.getElementById('myForm').addEventListener('submit', function() {
    "use strict";
      for (let option of warenkorb.options) {
          option.selected = true;
      }
  });

  // Initialize button state
  validateOrderButton();

