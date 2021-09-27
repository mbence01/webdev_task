// Route: /address

let urlParams = getParameters();

if(urlParams.length != 0) {
    if(urlParams[0][0] == "success" && urlParams[0][1] == 0 && urlParams[1][0] == "err") {
        switch(urlParams[1][1]) {
            case "fd": {
                window.alert("Nem töltöttél ki minden mezőt!\nA *-al jelölt mezők kitöltése kötelező!");
                break;
            }

            case "te": {
                window.alert("Az adószám mező kitöltése kötelező céges cím esetén!");
                break;
            }

            case "cb": {
                window.alert("A rögzítéshez el kell fogadnod az általános szerződési feltételeket!");
                break;
            }

            case "pc": {
                window.alert("Az irányítószámban nem szerepelhetnek betűk!");
                break;
            }

            case "ph": {
                window.alert("A telefonszám formátuma nem megfelelő!\nFormátum: +36XXXXXXXXX (csak számok)");
                break;
            }

            case "tx": {
                window.alert("Az adószám formátuma nem megfelelő!\nFormátum: XXXXXXXX-X-XX");
                break;
            }
        }
    }

    if(urlParams[0][0] == "success" && urlParams[0][1] == 1) {
        switch(urlParams[1][1]) { // honnan lett átirányítva
            case "deladdr": {
                window.alert("Sikeresen törölted a számlázási címedet!");
                break;
            }

            case "addaddr": {
                window.alert("Sikeresen hozzáadtad a számlázási címet!");
                break;
            }

            case "editaddr": {
                window.alert("Sikeresen módosítottad a számlázási címedet!");
                break;
            }

            case "neworder": {
                window.alert("Sikeresen megrendelted a kiválasztott terméket!");
                break;
            }
        }
    }
}



// Route: /placeorder

window.addEventListener("load", function() {
    if(document.getElementById("form_addrselect").getAttribute("count") == "1") {
        document.getElementById("form_container").style.display = "block";
    }
});

function selectChanged() {
    let e = document.getElementById("form_addrselect");

    if(e.options[e.selectedIndex].value == 0) {
        document.getElementById("form_container").style.display = "block";
    } else {
        document.getElementById("form_container").style.display = "none";
    }
}



// Function for address

function getParameters() {
    let arr = [];
    let url = window.location.href;

    url = url.substr(url.indexOf("?") + 1); // elvágjuk az urlt az első ? mentén

    if(window.location.href.indexOf(url) == 0) { // ha nincs kérdőjel, akkor a levágott str == url => return null array
        return [];
    }

    let c = 0;

    url.split("&").forEach(val => { // egyesével felszeleteljük a stringeket = mentén és beletöltjük a tömbbe
        let temp = val.split("=");

        arr[c++] = temp;
    });

    return arr;
}