<?php
function addPicData($fileName, $altText, $privacy){
	$notice = null;
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("INSERT INTO vpphotos (userid, filename, alttext, privacy) VALUES (?, ?, ?, ?)");
	echo $conn->error;
	$stmt->bind_param("issi", $_SESSION["userId"], $fileName, $altText, $privacy);
	if($stmt->execute()){
		$notice = " Pildi andmed salvestati andmebaasi!";
	} else {
		$notice = " Pildi andmete salvestamine ebaönnestus tehnilistel põhjustel! " .$stmt->error;
	}
	$stmt->close();
	$conn->close();
	return $notice;
}

function showPics($privacy, $page, $limit){
	$picHTML = null;
	$skip = ($page - 1) * $limit;
	
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	//$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos WHERE privacy<=? AND deleted IS NULL");
	$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos WHERE privacy<=? AND deleted IS NULL ORDER BY id DESC LIMIT ?,?");
	echo $conn->error;
	$stmt->bind_param("iii", $privacy, $skip, $limit);
	$stmt->bind_result($fileNameFromDb, $altTextFromDb);
	$stmt->execute();
	while($stmt->fetch()){
		    while ($stmt->fetch()) {

        $picHTML .= '<div class="thumbGallery">' . "\n";
        $picHTML .= '<img src="' . $GLOBALS["pic_upload_dir_thumb"] . $fileNameFromDb . '" alt="';
        if (empty($altTextFromDb)) {
            $picHTML .= "Illustreeriv foto";
        } else {
            $picHTML .= $altTextFromDb;
        }
        $picHTML .= '" data-fn="' . $fileNameFromDb . '">' . "\n";
        $picHTML .= ' data-id="' . $idFromDb . '"';
        $picHTML .= '>' . "\n";
		$picHTML .= '<p id="score' . $idFromDb . '">';
        $picHTML .= "<p>" . $lastNameFromDB . " " . $firstNameFromDb . "</p> \n";

        if ($avgFromDb == 0) {
            $picHTML .= "Pole hinnatud";
        } else {
            $picHTML .= "Hinne: " . round($avgFromDb, 2);
        }
        $picHTML .= "</p> \n";
        $picHTML .= "</div>";
		//<img src="kataloog/pildifail" alt="tekst" data-fn="pildifail">
		$picHTML .= '<img src="' .$GLOBALS["pic_upload_dir_thumb"] .$fileNameFromDb .'" alt="';
		if(empty($altTextFromDb)){
			$picHTML .= "Illustreeriv foto";
		} else {
			$picHTML .= $altTextFromDb;
		}
		$picHTML .= '" data-fn="' .$fileNameFromDb .'">' ."\n";
	}
	if($picHTML == null){
		$picHTML = "<p>Kahjuks pilte ei leitud!</p>";
	}
	
	$stmt->close();
	$conn->close();
	return $picHTML;
}

function countPics($privacy){
	$picCount;
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT COUNT(id) FROM vpphotos WHERE privacy<=? AND deleted IS NULL");
	echo $conn->error;
	$stmt->bind_param("i", $privacy);
	$stmt->bind_result($countFromDb);
	$stmt->execute();
	$stmt->fetch();
	$picCount = $countFromDb;
	$stmt->close();
	$conn->close();
	return $picCount;
}
}