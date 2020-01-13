//window.alert("näe, tööta");
//console.log("näe, töötab");

window.onload = function(){
	document.getElementById("submitPic").disabled = true;
	document.getElementById("notice").innerHTML = "vali üleslaadimieks pilt";
	document.getElementById("fileToUpload").addEventListener("change", checkSize);
}

function checkSize(){
	if(document.getElementById("fileToUpload").files[0].size <= 500000){
		document.getElementById("submitPic").disabled = false;
		document.getElementById("notice").innerHTML = "";
	} else {
		document.getElementById("notice").innerHTML = "Valitud pilt on liiga suur!";
		document.getElementById("submitPic").disabled = true;
	}
}