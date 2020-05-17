function deleteAlertes()
{
    $(".alerteColor").remove();
}

function newAlert(message, color, supr)
{
    if (supr)
        deleteAlertes();
    return $('<div class="'+color+'Alert alerteColor"></div>').html(message);
}
