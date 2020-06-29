//Masquage du champ 7 du formulaire si le chariot n'a pas une portée variable
function porteeVariable()
{
    if ($('#portee').is(':checked'))
    {
        $('#champ7').show();
    }
    else
    {
        $('#champ7').hide();
    }
}

//Masquage des champs 3 et 6 si l'appareil n'est pas un chariot élévateur
function chariotElevateur()
{
    if ($('#elevateur').is(':checked'))
    {
        $('#champ3').show();
        $('#champ6').show();
    }
    else
    {
        $('#champ3').hide();
        $('#champ6').hide();
    }
}

// Remplissage automatique des champs "Charge" après indication du 1er par l'utilisateur
function autoCompletionCharge()
{
    let listIdCharge = ['#charge3', '#charge4', '#charge5', '#charge6'];

    for (let elt of listIdCharge) {
        $(elt).val($('#puissance').val());
    }

    $('#charge7').val(parseInt($('#puissance').val()*0.1) + parseInt($('#puissance').val()));
}

//Masquage des lignes du champ 6 en fonction du type de chariot
function typeChariot()
{
    if ($('#portee').is(':checked'))
    {
        $('#essaiMaintien1').hide();
        $('#essaiMaintien2').hide();
        $('#essaiMaintien3').show();
    }
    else if ($('#type1').is(':checked'))
    {
        $('#essaiMaintien1').show();
        $('#essaiMaintien2').hide();
        $('#essaiMaintien3').hide();
    }
    else if ($('#type2').is(':checked'))
    {
        $('#essaiMaintien1').hide();
        $('#essaiMaintien2').show();
        $('#essaiMaintien3').hide();
    }
}