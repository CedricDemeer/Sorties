let url='/symfony/public/ville2';
let test="";
document.querySelector("#ville").addEventListener('input',function (){

    let array=document.getElementById('tbody1');
    jsondata=JSON.stringify(this.value)

    fetch(url,
        {
            method:"POST",
            body:jsondata
        })
        .then(response=>response.json())
        .then(response=>{


            for (let responseKey in response) {

                let nom=response[responseKey].nom;
                console.log(response[responseKey].nom);
                document.body.onload=addligne(nom);
                test=this.value;
            }

        })

})

function clear()
{
    test=this.value;
    console.log(test);
    window.location.reload();

}

function addligne(nom){

    let TR=document.createElement("tr");;
    let TD1=document.createElement("td");
    let TXT1=document.createTextNode(nom);
    TD1.appendChild(TXT1);
    TR.appendChild(TD1);
    document.getElementById('tbody1').appendChild(TR);

}

