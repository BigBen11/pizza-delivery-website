var warenkorb = document.getElementById('warenkorb');
console.log('Leerer Warenkorb');
console.log(warenkorb);

function addPizza(pizza) {
    "use strict";

  // Mein HTML Element, welches ich übergeben habe
  console.log('Übergebenes Element');
  console.log(pizza);
  
  // Die Data Attribute
  console.log('Data Attribute');
  console.log('Name: '+pizza.dataset.name, 'Preis: '+ pizza.dataset.price);
  
  var opt = document.createElement('option');
  opt.value = pizza.dataset.name;
  opt.text = pizza.dataset.name;
  
  // Erstellte Option
  console.log('Erstellte Option');
  console.log(opt);
  
  var warenkorb = document.getElementById('warenkorb');
  warenkorb.appendChild(opt);
  
  // Warenkorb mit Option
  console.log('Warenkorb mit Option');
  console.log(warenkorb);
  
  var priceTag = document.getElementById('preisAusgabe');
  var price = parseFloat(priceTag.textContent) + parseFloat(pizza.dataset.price);

  console.log('Price nicht gerundet');
  console.log(price);

  var rounded_price = price.toFixed(2);

  console.log('Price gerundet');
  console.log(rounded_price);

  priceTag.innerText = rounded_price + '€';
  
}