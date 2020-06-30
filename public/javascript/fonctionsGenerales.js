/*
* Fonctions communes aux différents twigs de contrôles
 */

    //Remplissage automatique des formulaires
    function formulaireAuto()
    {
        let x = $('input[type="radio"]');
        let i;

        if(($('#auto').html())=='Préremplir le formulaire')
        {
            for(i=0; i< x.length; i++)
            {
                if(x[i].value =='B' && x[i].type=='radio')
                {
                    x[i].checked = true;
                }
            }
            $('#auto').html('Tout décocher');
        }
        else
        {
            for (i=0; i< x.length; i++)
            {
                x[i].checked = false;
            }
            $('#auto').html('Préremplir le formulaire');
        }
    }

    //Remplissage automatique des champs Observations
    function observationsAuto(id)
    {
        let x = $(id +' input[type="radio"]');
        let i;
        let area="";

        for(i=0; i< x.length; i++)
        {
            if((x[i].value =='D' || x[i].value =='SO') && x[i].checked)
            {
                area += $('#'+x[i].name).attr('data-val')+" : "+x[i].value +"\n";
            }
        }
        $(id+'Ta').val(area);
    }

    //Affiche les consignes lors de l'affichage du formulaire de contrôle pour la grue, la pelle hydraulique
    function conseilsGrue()
    {
        alert( "Conseils pour effectuer le contrôle : \n- Si l'appareil n'est pas equipé d'un équipement, marquer 'sans objet' ou 'SO'. \n- Il est indispensable de sécuriser la surface utilisée pour l'essai à l'aide de cônes de signalisation et du ruban blanc et rouge par exemple, afin d'interdire à toute personne la possibilité de se mettre en danger. \n- En cas de doute sur l'année de construction de l'appareil ou en cas d'absence du marquage CE, considérer que l'appareil est d'avant le 31/12/1992 et utiliser le coefficient 1,33 à la place de 1,25. \n- Il est conseillé d'effectuer au préalable un lavage du véhicule");
    }

    //Affiche les consignes lors de l'affichage du formulaire de contrôle pour le cric / le chariot
    function conseils()
    {
        alert("Conseils pour effectuer le contrôle : \n- Si l'appareil n'est pas equipé d'un équipement, marquer 'sans objet' ou 'SO'. \n- Il est indispensable de sécuriser la surface utilisée pour l'essai à l'aide de cônes de signalisation et du ruban blanc et rouge par exemple, afin d'interdire à toute personne la possibilité de se mettre en danger.");
    }

    //Affiche les consignes lors de l'affichage du formulaire de contrôle pour BOM-Compacteur
    function conseilsBOM()
    {
        alert("Conseils pour effectuer le contrôle : \n- Si l'appareil n'est pas equipé d'un équipement, marquer 'sans objet' ou 'SO'. \n- Il est indispensable de sécuriser la surface utilisée pour l'essai à l'aide de cônes de signalisation et du ruban blanc et rouge par exemple, afin d'interdire à toute personne la possibilité de se mettre en danger. \n- Il est conseillé d'effectuer au préalable un lavage du véhicule");
    }

    //Pour les différents contrôles de la grue
    //Calcul du décollement après remplissage du champs portée par l'utilisateur
    function elevationCalcul()
    {
        let elements = $("input[name='forestiere']");
        let i;
        for (i=0; i<elements.length; i++)
        {
            if(elements[i].value == 'oui' && elements[i].checked)
            {
                $("#calculPortee").val($("#portee").val()*0.3);
                break;
            }
            else if($("#portee").value>12000 || anneeFabrication<= 1992)
            {
                $("#calculPortee").val($("#portee").val()*0.03);
                break;
            }
            else
            {
                $("#calculPortee").val($("#portee").val()*0.075);
                break;
            }
        }
    }

    //Timer avec un paramètre
    function countdown(time)
    {
        $('#countdown').html('Réinitialiser');
        $('#countdown').attr('onclick','reset("'+time+'")');
        $('#attente').prop('checked',false);

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
            $('.countdown').html(timer2);
            if(timer2 === "0:00")
            {
                new Audio('http://www.soundjay.com/button/beep-07.wav').play();
				clearInterval(interval);						
                $('#attente').prop('checked', true);
            }
        }, 1000);
    }
    //reset timer 1 paramètre
    function reset(time)
    {
        clearInterval(interval);
        $('#countdown').html('Démarrer le minuteur');
        $('.countdown').html("");
        $('#countdown').attr('onclick','countdown("'+time+'")');
    }

    //Timer avec 3 paramètres
    function countdown2(time, idDiv,idBtn)
    {
        $(idBtn).html('Réinitialiser');
        $(idBtn).attr('onclick','reset2("'+time+'","'+idDiv+'","'+idBtn+'")');

        //Désactive le 2ème bouton minuteur
        let idToBeDisable = (idBtn === '#btn1h'? '#btn15min' : '#btn1h');
        $(idToBeDisable).attr('disabled', true);

        //Décoche la checkbox
        let checkbox =  (idBtn === '#btn1h' ? '#attente1h' : '#attente15');
        $(checkbox).prop('checked', false);

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
                //réactive le bouton désactivé
                let idToBeEnable = (idBtn === '#btn1h'? '#btn15min' : '#btn1h');
                $(idToBeEnable).attr('disabled', false);

                //coche la checkbox
                checkbox =  (idBtn === '#btn1h' ? '#attente1h' : '#attente15');
                $(checkbox).prop('checked', true);

            }
        }, 1000);
    }
    //reset timer avec 3 paramètres
    function reset2(time, idDiv, idBtn)
    {
        clearInterval(interval);
        $(idBtn).html('Démarrer le minuteur');
        $(idDiv).html("");
        $(idBtn).attr('onclick','countdown2("'+time+'","'+idDiv+'","'+idBtn+'")');

        let idToBeEnable = (idBtn === '#btn1h'? '#btn15min' : '#btn1h');
        $(idToBeEnable).attr('disabled', false);
    }

    //Pour formulaire de contrôle bom-compacteur :
    // masquage de certains champs en fonction de BOM ou compacteur
    function typeAppareil()
    {
        if($('#benneOrdures').is(':checked'))
        {
            alert('BOM');
            $('#conservationBOM').show();
            $('#securiteBOM').show();
            $('#partie7').show();
            $('#conservationCompact').hide();
            $('#securiteCompact').hide();
        }
        else if($('#compacteur').is(':checked'))
        {
            alert('ça me saoule, ce compacteur');
            $('#conservationCompact').show();
            $('#securiteCompact').show();
            $('#conservationBOM').hide();
            $('#securiteBOM').hide();
            $('#partie7').hide();
        }
        else
        {
            $('#conservationCompact').show();
            $('#securiteCompact').show();
            $('#conservationBOM').show();
            $('#securiteBOM').show();
            $('#partie7').show();
        }
    }