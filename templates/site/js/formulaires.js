function valideForm(form, validations, messages)
{
    function testerValiditee(valeur, valide)
    {
        if (typeof valide == "function")
            return valide(""+valeur);
        else
        {
            var regEmail = new RegExp('^[0-9a-z._-]+@{1}[0-9a-z.-]{2,}[.]{1}[a-z]{2,5}$','i');
            switch (valide) {
                case "email":
                    return regEmail.test(valeur);
                default:
                    return true;
            }
        }
    }
    $(form).find("input[type=submit]").each(function(){
        $(this).click(function(){
            var formValide = true;
            var errors = Array();
            for (var name in validations) {
                var elem = $(form).find("*[name="+name+"]");
                if (!testerValiditee(elem.val(), validations[name]))
                {
                    formValide = false;
                    if (typeof messages[name] != "undefined")
                        errors.push(messages[name]);
                }
            }
            if (!formValide)
            {
                var msg = newAlert("<strong>Plusieurs erreurs ont etee detectee dans le fomulaire</strong>", "red", true);
                for (i in errors) {
                    msg.html(msg.html()+"<br />");
                    $("<span></span>").text(errors[i]).appendTo(msg);
                }
                msg.prependTo($(form));
                $('html, body').animate({scrollTop:0}, 'slow');
                return false;
            }
        });
    });
}
