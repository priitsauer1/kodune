<?php
  require("../../../config_vp2019.php");
  require("functions_main.php");
  require("functions_user.php");
  require("header.php");
  $database = "if19_priit_sa_1";
  
  //kui pole sisseloginud
  if(!isset($_SESSION["userId"])){
	  //siis jõuga sisselogimise lehele
	  header("Location: myindex.php");
	  exit();
  }
  
  //väljalogimine
  if(isset($_GET["logout"])){
	  session_destroy();
	  header("Location: myindex.php");
	  exit();
  }
  
  $userName = $_SESSION["userFirstname"] ." " .$_SESSION["userLastname"];
  
  $notice = null;
  $myDescription = null;
  
  if(isset($_POST["submitProfile"])){
	$notice = storeUserProfile($_POST["description"], $_POST["bgcolor"], $_POST["txtcolor"]);
	if(!empty($_POST["description"])){
	  $myDescription = $_POST["description"];
	}
	$_SESSION["bgColor"] = $_POST["bgcolor"];
	$_SESSION["txtColor"] = $_POST["txtcolor"];
  } else {
	$myProfileDesc = showMyDesc();
	if($myProfileDesc != ""){
	  $myDescription = $myProfileDesc;
    }
  }
  

$notice = null;
  $newPassword = null;
  $password = null;
  $passwordError = null;
  $newpasswordError = null;
  $confirmpasswordError = null;
  
  if(isset($_POST["submitUserData"])){
	 
	if (!isset($_POST["password"]) or empty($_POST["password"])){
	  $passwordError = "Palun sisesta salasõna!";
	} else {
	  if(strlen($_POST["password"]) < 8){
	    $passwordError = "liiga lühike";
	  }
	}
	  
	if (!isset($_POST["confirmpassword"]) or empty($_POST["confirmpassword"])){
	  $confirmpasswordError = "kinnitage salasõna";  
	} else {
	  if($_POST["confirmpassword"] != $_POST["password"]){
	    $confirmpasswordError = "Salasõnad ei kattu";
	  }
	}
	if(empty($emailError) and empty($passwordError) and empty($confirmpasswordError)){
		$notice = change_password( $_POST["oldpassword"], $_POST["password"]);
	} else {
		$notice = "Ei saa salvestada, andmed on puudulikud!";
	}
	
  }
?>
<body>
    <p>See leht on loodud koolis õppetöö raames
    ja ei sisalda tõsiseltvõetavat sisu!</p>
    <hr>
    <p><a href="?logout=1">Logi välja!</a> | Tagasi <a href="home.php">avalehele</a></p>
	<hr>
	<p>See leht on valminud TLÜ õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	<hr>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	 
		<label>Vana Salasõna</label><br>
		<input name="oldpassword" type="oldpassword"><span><?php echo $passwordError; ?></span><br>
		<label>Uus Salasõna</label><br>
		<input name="password" type="password"><span><?php echo $passwordError; ?></span><br>
		<label>Korrake uut salasõna:</label><br>
		<input name="confirmpassword" type="password"><span><?php echo $confirmpasswordError; ?></span><br>

	  <input name="submitUserData" type="submit" value="Vaheta Parooli"><span><?php echo $notice; ?></span>
	</form>
	<hr>
</body>
</html>