var USERNAMEOK;
var VALIDAZIONEPASS = true;
var VALIDAZIONEUSER = true;
var VALIDAZIONEEMAIL = true;

function validazione(event)
{
    // Verifica se tutti i campi sono riempiti
    if(form.nome.value.length == 0 ||
       form.cognome.value.length == 0 ||
       form.email.value.length == 0 ||
       form.password.value.length == 0 ||
       form.username.value.length == 0 ||
       form.confpassword.value.lenght == 0 ||
       form.data_nascita.value.lenght == 0)
    {
        // Avvisa utente
        const div = document.querySelector("#errorecomp");
        div.classList.remove("hidden");
        // Blocca l'invio del form
        event.preventDefault();
    }
    if((VALIDAZIONEEMAIL==false) || (VALIDAZIONEPASS==false) || (VALIDAZIONEUSER==false)){
        event.preventDefault();
    }
    ì
}

function funcPassword(){
    if (form.password.value !== form.confpassword.value){
        // Avvisa utente
        const p1 = document.querySelector("#pswd");
        const p2 = document.querySelector("#confpswd");
        p1.classList.add("rettangolo");
        p2.classList.add("rettangolo");
        const div = document.querySelector("#pass_differenti");
        div.classList.remove("hidden");
        VALIDAZIONEPASS = false;
    }
    else{
        const div = document.querySelector("#pass_differenti");
        div.classList.add("hidden");
        const p1 = document.querySelector("#pswd");
        const p2 = document.querySelector("#confpswd");
        p1.classList.remove("rettangolo");
        p2.classList.remove("rettangolo");
        VALIDAZIONEPASS = true;
    }
}

function funcEmail(){
    let email = form.email.value;
    if (!(email.includes("@") && email.includes("."))){
        // Avvisa utente
        pemail.classList.add("rettangolo");
        divemail.classList.remove("hidden");
        VALIDAZIONEEMAIL = false;
    }
    else{
        divemail.classList.add("hidden");
        pemail.classList.remove("rettangolo");
        VALIDAZIONEEMAIL = true;
    }

}

function funcUsername(){
    USERNAMEOK = form.username.value;
    fetch("./verificaUsername.php"+"?usern="+USERNAMEOK).then(responseAggiorna).then(onJSON);

}
function responseAggiorna(response) {
    let oggetto = response.json();
    return oggetto;
}
function onJSON(json){
    if (json.length == 0){
            pnomeutente.classList.remove("rettangolo");
            divnome.classList.add("hidden");
            USERNAMEOK = null;
            VALIDAZIONEUSER = true;
    }
    else{
        for(let obj of json){
            if(obj.username === USERNAMEOK){
                // Avvisa utente
                divnome.classList.remove("hidden");
                pnomeutente.classList.add("rettangolo");
                VALIDAZIONEUSER = false;
            }
        }
    }
}

//MAIN
//Con i tre cicli for evito che la scritta esca fuori anche senza motivo.
const pnomeutente = document.querySelector("#nomeutente");
const pemail = document.querySelector("#email");
//for(classe in pnomeutente.classList){
//   if (classe === "rettangolo")
//        divnome.classList.remove(classe);
//}

const divnome = document.querySelector("#nome_occ");
for(classe in divnome.classList){
    if (classe === "hidden")
        divnome.classList.remove(classe);
}
divnome.classList.add("hidden");
const divemail = document.querySelector("#err_email");
for(classe in divemail.classList){
    if (classe === "hidden")
        divemail.classList.remove(classe);
}
divemail.classList.add("hidden");
const divpass = document.querySelector("#pass_differenti");
for(classe in divpass.classList){
    if (classe === "hidden")
        divpass.classList.remove(classe);
}
divpass.classList.add("hidden");
const divcompila = document.querySelector("#errorecomp");
for(classe in divcompila.classList){
    if (classe === "hidden")
        divcompila.classList.remove(classe);
}
divcompila.classList.add("hidden");

// Riferimento al form
const form = document.forms['signup_form'];
// Aggiungi listener
form.addEventListener('submit', validazione);