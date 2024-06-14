document.addEventListener('DOMContentLoaded', function() {
  const warenkorb = document.getElementById('warenkorb');
  const addressInput = document.querySelector('input[name="Adresse"]');
  const orderButton = document.getElementById('B1');
  const priceOutput = document.getElementById('preisAusgabe');
  const resetAllButton = document.querySelector('input[name="Alle_löschen"]');
  const resetSelectedButton = document.querySelector('input[name="Auswahl_löschen"]');

  // Add pizza to cart
  window.addPizza = function(pizza) {
      const name = pizza.getAttribute('data-name');
      const price = parseFloat(pizza.getAttribute('data-price'));
      const option = document.createElement('option');
      option.value = name;
      option.textContent = `${name} - ${price.toFixed(2)}€`;
      option.setAttribute('data-price', price);
      warenkorb.appendChild(option);
      updateTotalPrice();
      validateOrderButton();
  };

  // Update total price
  function updateTotalPrice() {
      let total = 0;
      for (let option of warenkorb.options) {
          total += parseFloat(option.getAttribute('data-price'));
      }
      priceOutput.textContent = total.toFixed(2) + '€';
  }

  // Validate order button
  function validateOrderButton() {
      const isAddressFilled = addressInput.value.trim() !== '';
      const isCartNotEmpty = warenkorb.options.length > 0;
      orderButton.disabled = !(isAddressFilled && isCartNotEmpty);
  }

  // Event listeners for input fields
  addressInput.addEventListener('input', validateOrderButton);
  warenkorb.addEventListener('change', validateOrderButton);

  // Delete all items from the cart
  resetAllButton.addEventListener('click', function() {
      while (warenkorb.options.length > 0) {
          warenkorb.remove(0);
      }
      updateTotalPrice();
      validateOrderButton();
  });

  // Delete selected items from the cart
  resetSelectedButton.addEventListener('click', function() {
      const selectedOptions = Array.from(warenkorb.selectedOptions);
      selectedOptions.forEach(option => option.remove());
      updateTotalPrice();
      validateOrderButton();
  });

  // Automatically select all pizzas before submitting
  document.getElementById('myForm').addEventListener('submit', function() {
      for (let option of warenkorb.options) {
          option.selected = true;
      }
  });

  // Initialize button state
  validateOrderButton();
});
