//MAIN
const imgs = document.querySelectorAll("div.contenuto img");
for (img of imgs){
    img.addEventListener("click", onDivClick);
}
const modalView = document.querySelector("#modal-view");
modalView.addEventListener("click", onModalClick);
const buttons = document.querySelectorAll(".button_elimina");
for (button of buttons){
    button.addEventListener("click", onDeleteClick);
}


//FUNZIONI
function onDeleteClick(event){
    const nome_playlist=document.querySelector("h1.selPlay").textContent;
    const id_video=event.currentTarget.parentNode.dataset.titolo;
    fetch("./delete_cont.php?id_video="+id_video+"&nome_playlist="+nome_playlist);
    event.currentTarget.parentNode.classList.remove("contenuto");
    event.currentTarget.parentNode.classList.add("hidden");
    event.currentTarget.parentNode.innerHTML="";
}

function onModalClick(event){
    document.body.classList.remove("no-scroll");
    modalView.classList.add("hidden");
    modalView.innerHTML = "";
}

function onDivClick(event){
    const id_video=event.currentTarget.parentNode.dataset.titolo;
    const id_descr="descr_cont"+id_video;
    const titolo_video=document.getElementById(id_video);
    const titolo = titolo_video.textContent;
    const descrizione_video=document.getElementById(id_descr);
    const descrizione = descrizione_video.textContent;
    const div1 = document.createElement("div");
    div1.classList.add("div-video-modal");
    const div2 = document.createElement("div");
    div2.classList.add("frame-div-modal");
    const iframe = document.createElement("iframe");
    iframe.classList.add("frame-video-modal");
    iframe.id="iframe-modal";
    iframe.src="//www.youtube.com/embed/"+id_video;
    iframe.dataset.autoplaySrc="//www.youtube.com/embed/"+id_video+"?autoplay=1";
    div2.appendChild(iframe);
    div1.appendChild(div2);
    const div3 = document.createElement("div");
    div3.classList.add("info-video-modal");
    const div4 = document.createElement("div");
    div4.classList.add("titolo-video-modal");
    div4.textContent=titolo;
    div3.appendChild(div4);
    const div5 = document.createElement("p");
    div5.classList.add("descrizione-video-modal");
    div5.textContent=descrizione;
    div3.appendChild(div5);
    div1.appendChild(div3);
    document.body.classList.add("no-scroll");
    modalView.style.top = "0px";
    modalView.appendChild(div1);
    modalView.classList.remove("hidden");
}