function setCookie(sName, sValue, tempsReste) {
        if (typeof tempsReste === "undefined")
            var tempsReste = 365*24*60*60*1000;
        else
        {
            tempsReste = ""+tempsReste;
            if (tempsReste.indexOf("s") == 0)
                tempsReste = parseInt(tempsReste.substr(1)) * 1000;
            else if (tempsReste.indexOf("m") == 0)
                tempsReste = parseInt(tempsReste.substr(1)) * 60 * 1000;
            else if (tempsReste.indexOf("h") == 0)
                tempsReste = parseInt(tempsReste.substr(1)) * 60 * 60 * 1000;
            else if (tempsReste.indexOf("j") == 0)
                tempsReste = parseInt(tempsReste.substr(1)) * 24 * 60 * 60 * 1000;
            else if (tempsReste.indexOf("a") == 0)
                tempsReste = parseInt(tempsReste.substr(1)) * 365 * 24 * 60 * 60 * 1000 + 6 * 60 * 60 * 1000;
            else
                tempsReste = parseInt(tempsReste);
        }
        var today = new Date(), expires = new Date();
        expires.setTime(today.getTime() + (tempsReste));
        document.cookie = sName + "=" + encodeURIComponent(sValue) + ";expires=" + expires.toGMTString();
}

function getCookie(sName) {
        var cookContent = document.cookie, cookEnd, i, j;
        var sName = sName + "=";
 
        for (i=0, c=cookContent.length; i<c; i++) {
                j = i + sName.length;
                if (cookContent.substring(i, j) == sName) {
                        cookEnd = cookContent.indexOf(";", j);
                        if (cookEnd == -1) {
                                cookEnd = cookContent.length;
                        }
                        return decodeURIComponent(cookContent.substring(j, cookEnd));
                }
        }       
        return null;
}
