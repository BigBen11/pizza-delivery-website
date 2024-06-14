document.addEventListener('DOMContentLoaded', () => {
    const jsonData = `[
    {
        "ordering_id": 80,
        "name": "Salami",
        "status": 5,
        "address": "dddd"
    },
    {
        "ordering_id": 80,
        "name": "Vegetaria",
        "status": 5,
        "address": "dddd"
    },
    {
        "ordering_id": 80,
        "name": "Spinat-Hühnchen",
        "status": 5,
        "address": "dddd"
    }
]`;

    process(jsonData);
});

function process(data) {
    let orders;
    
    try {
        orders = typeof data === 'string' ? JSON.parse(data) : data;
    } catch (e) {
        console.error("Fehler beim Parsen der JSON-Daten:", e);
        return;
    }

    const container = document.getElementById('order-status');
    container.innerHTML = '';

    if (!orders.length) {
        container.innerHTML = '<p>Du hast derzeit keine Bestellungen, mache jetzt eine! 😊</p>';
        return;
    }

    const ul = document.createElement('ul');
    orders.forEach(order => {
        const li = document.createElement('li');
        const statusText = getStatusText(order.status);
        li.textContent = `${order.name}: ${statusText}`;
        ul.appendChild(li);
    });

    container.appendChild(ul);
}

function getStatusText(status) {
    switch (status) {
        case 1: return 'Bestellt';
        case 2: return 'Im Ofen';
        case 3: return 'Fertig';
        case 4: return 'Unterwegs';
        case 5: return 'Geliefert';
        default: return 'Unbekannt';
    }
}
