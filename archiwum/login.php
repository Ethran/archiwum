<?php

function check_if_exist($email){
	// open file list:
	if (($handle = fopen("logins.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        	if($data[0]==$email)
        	{
        		return $data;
        	}
        }
        fclose($handle);
	}
	return false;
}
function send($email, $kod){
    $subject = 'Twój kod już na ciebie czeka!';
	$message = "<h1>twój kod to: $kod<h1>";
	$headers = 'From: kolory@students.mimuw.edu.pl' . "\r\n" .
				'Reply-To: no-replay@students.mimuw.edu.pl' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();
	mail($email, $subject, $message, $headers);
}

function login_register(){
   	if(isset($_SESSION["zalogowany"]) && $_SESSION["zalogowany"]){
   		return true;
   	}
	$email = $_POST["email"];
	// check if e-mail address is well-formed
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	    echo '<script>alert("niepoprawny email")</script>';
	    return false;
	}
	//sprawdzenie czy email pochodzi z mimu
	$pattern='~^[a-z]{2}[0-9]{6}\@students\.mimuw\.edu\.pl$~';
	if (!preg_match($pattern,$email)) {
	    echo '<script>alert("email nie z MIM")</script>';
	    return false;
	}

	$email=hash('ripemd160', $email);
	
	$dat2=check_if_exist($email);
	if($dat2){
		if(!isset($_POST['psw']))
		{	
		    echo '<script>alert("AAAAAAAAAAAAA! brak kodu w bazie!")</script>';
		    return false;
		}else{
			$kod=hash('ripemd160', $_POST['psw']);
			if($dat2[1]!=$kod){
				echo '<script>alert("zły kod, spróbuj ponownie")</script>';
				return false;
			}
			else{
				echo "super!";
				$_SESSION["zalogowany"]=$email;
				return true;
			}
		}

	}
	else{
		$kod=rand(1000,9999);
		$informacje = array(
		    $email,
		    hash('ripemd160',$kod)
		);
		if (($handle = fopen("logins.csv", "a")) !== FALSE) {
		    fputcsv($handle, $informacje);
		    fclose($handle);
			send($_POST["email"], $kod);
			echo "wprowadzone do bazy danych!";
		    return true;
		} else {
		    echo '<script>alert("AAAAAAAAAAAAA")</script>';
		    return false;
		}
	}
	echo "test2";
}
?>
