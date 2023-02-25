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
    $message =<<< EOT
<!DOCTYPE html>
<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" lang="en">
 <head>
  <title></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Droid+Serif" rel="stylesheet" type="text/css">
  <style>
   * {
    box-sizing: border-box
   }

   body {
    margin: 0;
    padding: 0
   }

   a[x-apple-data-detectors] {
    color: inherit !important;
    text-decoration: inherit !important
   }

   #MessageViewBody a {
    color: inherit;
    text-decoration: none
   }

   p {
    line-height: inherit
   }


   @media (max-width:620px) {

    .image_block img.big,
    .row-content {
     width: 100% !important
    }


    .stack .column {
     width: 100%;
     display: block
    }

   }
  </style>
 </head>
 <body style="background-color:#fff;margin:0;padding:0;-webkit-text-size-adjust:none;text-size-adjust:none">
  <table class="nl-container" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;background-color:#fff">
   <tbody>
    <tr>
     <td>
      <table class="row row-1" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;background-color:#26496b">
       <tbody>
        <tr>
         <td>
          <table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;background-color:#26496b;color:#000;width:600px" width="600">
           <tbody>
            <tr>
             <td class="column column-1" width="100%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;vertical-align:top;padding-top:45px;padding-bottom:0;border-top:0;border-right:0;border-bottom:0;border-left:0">
              <table class="text_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word">
               <tr>
                <td class="pad">
                 <div style="font-family:Georgia,'Times New Roman',serif">
                  <div class style="font-size:14px;font-family:'Droid Serif',Georgia,Times,'Times New Roman',serif;mso-line-height-alt:16.8px;color:#555;line-height:1.2">
                   <p style="margin:0;font-size:22px;text-align:center;mso-line-height-alt:26.4px">
                    <span style="color:#ffffff;font-size:80px;">
                     <strong>Kolory</strong>
                    </span>
                   </p>
                  </div>
                 </div>
                </td>
               </tr>
              </table>
              <table class="divider_block block-2" width="100%" border="0" cellpadding="20" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0">
               <tr>
                <td class="pad">
                 <div class="alignment" align="center">
                  <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%" style="mso-table-lspace:0;mso-table-rspace:0">
                   <tr>
                    <td class="divider_inner" style="font-size:1px;line-height:1px;border-top:1px solid #bbb">
                     <span>&#8202;</span>
                    </td>
                   </tr>
                  </table>
                 </div>
                </td>
               </tr>
              </table>
              <table class="text_block block-3" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word">
               <tr>
                <td class="pad" style="padding-bottom:25px;padding-left:10px;padding-right:10px;padding-top:5px">
                 <div style="font-family:Georgia,'Times New Roman',serif">
                  <div class style="font-size:12px;color:#fff;line-height:1.5">
                   <p style="margin:0;font-size:24px;text-align:center;mso-line-height-alt:57px">
                    <span style="font-size:38px;">Twój kod to: {$kod} <br>
                    </span>
                   </p>
                  </div>
                 </div>
                </td>
               </tr>
              </table>
              <table class="image_block block-4" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0">
               <tr>
                <td class="pad" style="width:100%;padding-right:0;padding-left:0">
                 <div class="alignment" align="center" style="background-image: url(https://students.mimuw.edu.pl/~ww439108/archiwum/img/kolory.png);
    background-size: 100% auto;
    background-repeat: no-repeat;
    background-position: left top;
    height: 100vh;
    text-align: center;
">
                  <div style="    
    position: relative;
    float: left;
    top: 55%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #ffffff;
    font-family: Bradley Hand, cursive;
    font-size: 28px;">
    "Kolory. Skrzyżowanie czerwonego z niebieskim. W skrzyżowaniu czerwonego z niebieskim jest trochę czerwonego. I niebieskiego, trochę. I nie ma nic więcej." 
    <div style="text-align: left;
    position: relative;
    float: right;
    font-size: 12px;">
                    <br>~ Łukasz Degórski
                   </div>
                  </div>
                 </div>
                </td>
               </tr>
              </table>
             </td>
            </tr>
           </tbody>
          </table>
         </td>
        </tr>
       </tbody>
      </table>
     </td>
    </tr>
   </tbody>
  </table>
 </body>
{$kod}
</html>
EOT;
	$headers = 	"Content-type:text/html;charset=UTF-8" . "\r\n". 
				"MIME-Version: 1.0" . "\r\n".
				'From: kolory@students.mimuw.edu.pl' . "\r\n" .
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
				//echo "super!";
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
