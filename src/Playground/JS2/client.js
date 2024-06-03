let request = new XMLHttpRequest();
request.open("GET", "server.php"); // definiert URL für Datenabfrage
request.onreadystatechange = processData; // Callback-Handler zuordnen
request.send();


function processData() {
    if(request.readyState === 4) { // Uebertragung = DONE
        if (request.status === 200) { // HTTP-Status = OK
            if(request.responseText != null)
                process(request.responseText);// Daten verarbeiten
            else console.error ("Dokument ist leer");
        } 
        else console.error ("Uebertragung fehlgeschlagen");
    } 
    else ; // Uebertragung laeuft noch
}

function process (intext) { // Text ins DOM einfuegen
    let myText = document.getElementById("111");

    console.log(intext);

    //data = intext[0];

    myText.innerText = intext[0];
    //document.getElementById("111").value="Fertig!";
}

//window.setInterval (processData, 1000);