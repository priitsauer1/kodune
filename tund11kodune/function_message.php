<?php>
function storeMessage($message){
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn -> prepear("INSERT INTO vpmsg(userid, message) VALUES(?,?)");
	echo $conn -> error;
	$stmt -> bind_param("is",$_SESSION["userId"], $message);
	if($stmt -> execute()){
		$notice = "sõnum salvestati"
	}	else{
		  $notice="salvestamis error" .$stmt -> error;
	}	  
	   
	$stmt->close();
	$conn->close();
	return $notice;
}
function readAllmessages(){
	$notice = null
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn -> ("SELECT message, created FROM vpmsg WHERE deleted IS NULL");
	echo $conn -> error;
	$stmt -> bind_result($messageFromDB, $createdFromDB);
	$stmt ->execute();
	while/($stmt -> fetch()){
		$notice .= "<li>" .$messageFromDB ." (lisatud)" .$createdFromDB .")</li> \n";
		    
	}
	if(!empty($notice))
		$notice = "<ul> \n" .$notice ."</ul> \n";
    }
	$stmt->close();
	$conn->close();
?>