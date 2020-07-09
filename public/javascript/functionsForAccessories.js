// Countdown pour les accessoires 4 paramètres
function countdownAccessories(time,idDiv,idBtn,idCkb)
{
    $(idBtn).html('Réinitialiser');
    $(idBtn).attr('onclick','resetAccessories("'+time+'","'+idDiv+'","'+idBtn+'","'+idCkb+'")');
    let i =0;

    //Désactive les autres boutons minuteur
    for(i=0; i<indiceAccess+1; i++)
    {
        let btn = (i===0?'#btn':'#btn_'+i);

        if(btn!= idBtn)
        {
            $(btn).attr('disabled', true);
        }
        else{
            //Décoche la checkbox
            $(idCkb).prop('checked', false);
        }
    }

    let timer2 = time;

    interval = setInterval(function()
    {
        //timer will be [minute, second]
        let timer = timer2.split(':');
        let minutes = parseInt(timer[0], 10);
        let seconds = parseInt(timer[1], 10);
        //reduce second by one
        --seconds;
        //calculate new minute
        minutes = (seconds < 0) ? --minutes : minutes;
        if(minutes<0) clear(interval);
        seconds = (seconds < 0) ? 59 : seconds;
        seconds = (seconds < 10) ? '0' + seconds : seconds;

        timer2 = minutes + ':' + seconds;
        $(idDiv).html(timer2);
        if(timer2 === "0:00")
        {
            new Audio('http://www.soundjay.com/button/beep-07.wav').play();
            clearInterval(interval);

            //Réactive les boutons désactivés
            for(i=0; i<indiceAccess+1; i++)
            {
                let btn = (i===0?'#btn':'#btn_'+i);

                if(btn != idBtn)
                {
                    $(btn).attr('disabled', false);
                }
                else{
                    //Coche la checkbox
                    $(idCkb).prop('checked', true);
                }
            }
        }
    }, 1000);
}
//reset timer avec 4 paramètres
function resetAccessories(time, idDiv, idBtn,idCkb)
{
    let i = 0;

    clearInterval(interval);
    $(idBtn).html('Démarrer le minuteur');
    $(idDiv).html("");
    $(idBtn).attr('onclick','countdownAccessories("'+time+'","'+idDiv+'","'+idBtn+'","'+idCkb+'")');

    //Réactive les boutons désactivés
    for(i=0; i<indiceAccess+1; i++)
    {
        let btn = (i===0?'#btn':'#btn_'+i);

        if(btn!= idBtn)
        {
            $(btn).attr('disabled', false);
        }
    }
}

//Duplication du formulaire accessoire
function duplicateAccessories()
{
    indiceAccess++;
    let idAccess=indiceAccess;
    let element = document.getElementById("div").cloneNode(true);
    element.id = "div_" + indiceAccess;
    element.class = "card mt-3 shadow-sm";
    let u = 0;

    let title = element.getElementsByTagName("b");
    for(u=0; u<title.length; u++)
    {
        if(title[u].id !="")
        {
            title[u].id += "_" + indiceAccess;
            title[u].innerHTML += indiceAccess+1;
        }
    }

    let elts = element.getElementsByTagName("input");
    for(u=0; u<elts.length; u++)
    {
        if(elts[u].id != "")
        {
            elts[u].id += "_" + indiceAccess;
        }
        if(elts[u].type =="text" || elts[u].type == "number")
        {
            elts[u].value = "";
        }
        else if(elts[u].type =="radio" || elts[u].type =="checkbox")
        {
            elts[u].checked = false;
            if(elts[u].name==="typeControle" || elts[u].name==="sigleCE")
            {
                elts[u].onchange = function(){gestionformulaire("#partie1_" + idAccess, "#partie2_" + idAccess, "#partie3_" + idAccess, "#partie4_" + idAccess, idAccess);};
            }
            elts[u].name += "_" + indiceAccess;
        }
    }

    elts = element.getElementsByTagName("td");
    for(u=0; u<elts.length; u++)
    {
        if(elts[u].id != "")
        {
            elts[u].id += "_" + indiceAccess;
        }
    }

    elts = element.getElementsByTagName("button");
    for(u=0; u<elts.length; u++)
    {
        if(elts[u].id != "")
        {
            elts[u].id += "_" + indiceAccess;
            elts[u].onclick = function (){countdownAccessories(time , "#countdown_" + idAccess ,
            "#btn_" + idAccess, "#attente_" + idAccess);};
        }
        else if(elts[u].id == "")
        {
            elts[u].onclick = function (){observationsAuto("#div_" + idAccess);};
        }
    }

    elts = element.getElementsByTagName("div");
    for(u=0; u<elts.length; u++)
    {
        if(elts[u].id != "")
        {
            elts[u].id += "_" + indiceAccess;
        }
    }

    elts = element.getElementsByTagName("textarea");
    for(u=0; u<elts.length; u++)
    {
        if(elts[u].id != "")
        {
            elts[u].id = element.id + "Ta";
        }
        elts[u].value = "";
    }
    document.getElementById("divBloc").appendChild(element);
    document.getElementById("chargeNominale_"+ idAccess).onchange = function(){autoCompletionCharge("#chargeNominale_" + idAccess, "#charge_" + idAccess);};

    $('#partie1_' + idAccess).show();
    $('#partie2_' + idAccess).show();
    $('#partie3_' + idAccess).show();
    $('#partie4_' + idAccess).show();

}

//autocomplétion de la charge calculée
function autoCompletionCharge(idCharge, idCalculCharge)
{
    $(idCalculCharge).val(($(idCharge).val()*1.5).toFixed(2));
}

//Masque certains champs du formulaire en fonction du type de contrôle à effectuer
function gestionformulaire(idPartie1, idPartie2, idPartie3, idPartie4, indice)
{
    let nameType = "typeControle" + "_" + indice;
    let nameSigle = "sigleCE" + "_" + indice;

    if(indice===0)
    {
        nameType = "typeControle";
        nameSigle = "sigleCE";
    }

    let x = $('input[name=' + nameType + ']');
    let y = $('input[name=' + nameSigle + ']');
    let u, i;

    //Afficher tous les champs
    $(idPartie1).show();
    $(idPartie2).show();
    $(idPartie3).show();
    $(idPartie4).show();

    for(u=0; u<x.length; u++)
    {
        if(x[u].value === "neuf" && x[u].checked)
        {
            for(i=0; i<y.length; i++)
            {
                if(y[i].value==="oui" && y[i].checked)
                {
                    $(idPartie1).hide();
                    $(idPartie2).hide();
                }
                else if(y[i].value==="non" && y[i].checked)
                {
                    $(idPartie2).hide();
                    $(idPartie3).hide();
                }
            }
        }
        else if (x[u].value === "occaz" && x[u].checked)
        {
            $(idPartie3).hide();
        }
        else if (x[u].value === "periodique" && x[u].checked)
        {
            $(idPartie1).hide();
            $(idPartie2).hide();
        }
    }
}