const form = document.forms['ricerca'];
form.addEventListener('submit', onRicerca);
console.log(document.getElementById('ricerca'));
console.log("Sono il js");


function onRicerca(event){
    event.preventDefault();
    debugger;
    console.log("Ricerca");
    const titolo1 = document.querySelector("#titolo_video");
    const titolo = titolo1.value.replace(/ /g, "");
    fetch("./do_search.php?cerca="+titolo).then(onResponse).then(onJSON);
}

function onResponse(response){
    return response.json();
}

function onJSON(json){
    const contenitore = document.querySelector("#container-risultati");
    contenitore.innerHTML="";
    for (obj of json.items){
        const titolo = obj.snippet.title;
        const descr = obj.snippet.description;
        const thumb = obj.snippet.thumbnails.high.url;
        const videoId = obj.id.videoId;
        const div01 = document.createElement("div");
        div01.classList.add("div-video");
        div01.dataset.number = json.items.indexOf(obj);
        const div02 = document.createElement("div");
        div02.classList.add("frame-div");
        const iframe = document.createElement("iframe");
        iframe.classList.add("frame-video");
        iframe.id="iframe";
        iframe.src = "//www.youtube.com/embed/"+videoId;
        iframe.dataset.autoplaySrc="//www.youtube.com/embed/"+videoId+"?autoplay=1";
        const div03 = document.createElement("div");
        div03.classList.add("info-video");
        const div04 = document.createElement("div");
        div04.classList.add("titolo-video");
        div04.innerHTML=titolo;
        const div05 = document.createElement("div");
        div05.classList.add("descrizione-video");
        div05.innerHTML=descr;
        const id1 = document.createElement("span");
        id1.classList.add("hidden");
        id1.innerHTML=videoId;
        const img01 = document.createElement("img");
        img01.classList.add("hidden");
        img01.src=thumb;
        const button = document.createElement("button");
        button.classList.add("button-agg");
        button.innerHTML="Aggiungi video alla Playlist selezionata";
        button.addEventListener("click", aggiungiVideo);
        div03.appendChild(div04);
        div03.appendChild(div05);
        div03.appendChild(img01);
        div03.appendChild(id1);
        div03.appendChild(button);
        div02.appendChild(iframe);
        div01.appendChild(div02);
        div01.appendChild(div03);
        contenitore.appendChild(div01);
    }

}

function aggiungiVideo(event){
    const sel = document.querySelector("#nome_playlist");
    if (sel.value === ""){
        window.alert("Crea una playlist prima di inserire un video.");
        console.log("Nessuna playlist è presente. Crearne una.");
    }
    else{
        const div1=event.currentTarget.parentNode;
        const formdata = new FormData();
        const titolo = div1.querySelector(".titolo-video").textContent;
        const descr = div1.querySelector(".descrizione-video").textContent;
        const thumb = div1.querySelector("img").src;
        const id1 = div1.querySelector("span").textContent;
        formdata.append("titolo", titolo);
        formdata.append("descrizione", descr);
        formdata.append("thumbnail", thumb);
        formdata.append("idVideo", id1);
        formdata.append("nomePlay", sel.value);
        fetch("./add.php", {method:"post", body:formdata}).then(onResponse1);
    }
}

function onResponse1(response){
    if(response.ok){
        window.alert("Contenuto inserito correttamente");
    }
    else
        window.alert("Errore nell'inserimento. Probabilmente il contenuto esiste già nella playlist selezionata.");
}