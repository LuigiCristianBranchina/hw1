const form = document.forms['ricerca'];
form.addEventListener('submit', onAggiunta);
console.log("Sono il js.");
const imgs = document.querySelectorAll("#container-play div.playlist img");
for (img of imgs){
    img.addEventListener('click', openCollection);
}
const buttons = document.querySelectorAll(".button_elimina");
for(button of buttons){
    button.addEventListener("click", deletePlaylist);
}

function onAggiunta(event){
    console.log("Aggiunta");
    const nomePlay = document.querySelector("#titolo_playlist").value;
    fetch("./add_playlist.php?nome="+nomePlay);
    const contenitore = document.querySelector("#container-play");
    const divs = contenitore.querySelectorAll("div.playlist");
    for (el of divs){
        if((el.dataset.titolo === nomePlay)){
            event.preventDefault();
            return;
        }
    }
    const div = document.createElement("div");
    div.classList.add("playlist");
    div.dataset.titolo=nomePlay;
    const img = document.createElement("img");
    const h1 = document.createElement("h1");
    const button = document.createElement("button");
    img.src="./images/playlist.jpg";
    img.classList.add("img_play");
    img.addEventListener("click", openCollection);
    h1.id="titolo-play";
    h1.textContent="Titolo: "+nomePlay;
    button.classList.add("button_elimina");
    button.textContent="Elimina playlist";
    button.addEventListener("click", deletePlaylist);
    div.appendChild(img);
    div.appendChild(h1);
    div.appendChild(button);
    contenitore.appendChild(div);
    event.preventDefault();
}

function deletePlaylist(event){
    const nomePlay = event.currentTarget.parentNode.dataset.titolo;
    fetch("./delete_playlist.php?nome_playlist="+nomePlay);
    event.currentTarget.parentNode.classList.remove("playlist");
    event.currentTarget.parentNode.classList.add("hidden");
    event.currentTarget.parentNode.innerHTML="";
}

function openCollection(event){
    const nomePlay = event.currentTarget.parentNode.dataset.titolo;
    location.href = "./collection.php?nome="+nomePlay;
}