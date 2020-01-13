
<?php
    require("../../../config.php");
    session_start();
	$rating = $_REQUEST["rating"];
    $photoId = $_REQUEST["photoId"];
	$userid = $_SESSION["userId"];

    $conn = new mysqli($GLOBALS["serverpost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
    $stmt = $conn->prepare("INSERT INTO vpphotoratings (photoId, userid, rating) VALUES(?,?,?)");
    $stmt->bind_param("iii", $photoId, $userid, $rating);
    $stmt->execute();
    $stmt->close();
    $conn->close();