let urlParams = getParameters();

if(urlParams.length != 0) {
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
        }
    }
}

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