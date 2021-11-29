let isDisplay = true;

function handleClickSpoiler() {
    console.log('handleClickSpoiler', isDisplay);
    //vérifier l'état du booléen isDislay
    if (isDisplay === true) {
        //alors on cache le texte
        document.getElementById('js-form-spoiler').className = '';
        //on change la variable isDisplay à false
        //ça précise que le texte est caché
        isDisplay = false;
        //alert('Je suis caché');

    }
    else{
        document.getElementById('js-form-spoiler').className = 'app-spoiler';
        isDisplay = true;
    }

}

function ajoutLieu() {
    var name = prompt('Entrer un nom pour votre lieu : ','Nom du lieu');
    if (name == null)
    {
        alert("Il nous faut un nom pour le lieu... recommencez");
    }
    else{

        var longitude = prompt('Quel est la longitude du lieu : ','172.6366455');
        var latitude = prompt('Quel est la latitude du lieu : ','-43.530955');
        var ville = prompt('Quel est la ville de votre lieu : ','Christchurch')
        if (ville == null)
        {
            alert("Il nous faut un nom pour la ville... recommencez");
        }
        else{
            if (name != "") {
                alert(name);
            }
        }
}
}
