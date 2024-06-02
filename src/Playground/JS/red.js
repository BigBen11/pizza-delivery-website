isPageRed = false;

function makeRed() {
    "use strict";

    isPageRed = true;

    document.body.style.background = 'red';

    const p = document.createElement('p');
    p.innerText = "Der Hintergrund ist jetzt rot!";
    p.id = "red-text";
    p.className = "paragraph-css-class";

    const body = document.body;

    body.appendChild(p);
}

function makeWhite(){
    "use strict";

    isPageRed = false;

    document.body.style.background = 'white';

    const redText = document.getElementById("red-text");

    redText.remove();

}

function toggleColor(){
    "use strict";

    if(isPageRed){
        makeWhite();
    }
    else{
        makeRed();
    }
}