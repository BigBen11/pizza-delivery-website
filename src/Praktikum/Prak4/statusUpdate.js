/* global console, XMLHttpRequest, document, window */

const request = new XMLHttpRequest(); 

function getStatusText(status) {
    "use strict";
    switch (status) {
        case 1: return "Bestellt";
        case 2: return "Im Ofen";
        case 3: return "Fertig";
        case 4: return "Unterwegs";
        case 5: return "Geliefert";
        default: return "Unbekannt";
    }
}

function process(data) {
    "use strict";
    let orders;
    const container = document.getElementById("order-status");

    try {
        orders = (typeof data === "string") ? JSON.parse(data) : data;
    } catch (e) {
        console.error("Fehler beim Parsen der JSON-Daten:", e);
        return;
    }

    // Clear previous orders
    while (container.firstChild) {
        container.removeChild(container.firstChild);
    }

    if (!orders.length) {
        const p = document.createElement("p");
        p.textContent = "Du hast derzeit keine Bestellungen, mache jetzt eine! 😊";
        container.appendChild(p);
        return;
    }

    const ul = document.createElement("ul");
    orders.forEach(function(order) {
        const li = document.createElement("li");
        const statusText = getStatusText(order.status);
        li.textContent = order.name + ": " + statusText;
        li.classList.add("kunde-pizza-item");
        ul.appendChild(li);
    });

    container.appendChild(ul);
}

function processData() {
    "use strict";
    if (request.readyState === 4) { // Übertragung = DONE
        if (request.status === 200) { // HTTP-Status = OK
            if (request.responseText !== null) {
                process(request.responseText); // Daten verarbeiten
            } else {
                console.error("Dokument ist leer");
            }
        } else {
            console.error("Übertragung fehlgeschlagen");
        }
    }
}

function requestData() {
    "use strict";
    request.open("GET", "KundenStatus.php"); // URL für HTTP-GET
    request.onreadystatechange = processData; // Callback-Handler zuordnen
    request.send(null); // Request abschicken
}

document.addEventListener("DOMContentLoaded", function() {
    "use strict";
    requestData();
    window.setInterval(requestData, 2000);
});
