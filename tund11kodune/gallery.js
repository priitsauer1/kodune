let modal;
let modalImg;
let caption;
let photoDir = ../picuploadw600h400;

window.onload = function(){
	modal = document.getElementById("myModal");
	modalImg = document.getElementById("modalImg");
	caption = document.getElementById("caption");
	let alltThumbs = document.getElementById("galley").getElementsByTagName("img");
	let thumbCount = allThumbs.lenght;
	for(let i = 0; i < thumbCount; i ++){
		alltThumbs[i].addEventListener("click", openModal);
	}
	document.getElementById("close").addEventListener("click",closemodal);
}
function openModal(e){
	caption.innerHTML = "<p>" + e.target.alt + "</p>";
	modal.style.display ="block";
}

function closeModal(){
	modal.style.display ="none";
}
function saveRating() {
    let rating = 0;
    for (let i = 1; i < 5; i++) {
        if (document.getElementById("rate" + i).checked) {
            //rating = document.getElementById("rate" + i).value;
            rating = i;
        }
    }
    if (rating > 0) {
        //AJAX
        let webRequest = new XMLHttpRequest();
        webRequest.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
            }
        };
        webRequest.open("GET", "savepicrating.php?rating=" + rating, true);
        webRequest.send();
    }
}
