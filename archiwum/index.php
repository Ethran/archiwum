<?php
session_start();
ob_start();
require 'php_helpers/upload.php';
require 'php_helpers/login.php';
require 'php_helpers/showTable.php';
require ("/home/students/mat/w/ww439108/public_html/archiwum/php_helpers/header.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (isset($_POST['login']) && isset($_POST['email'])) {
	login_register();
}
?>



<body>
	<div id="content">

		<div id="title">
			<h1>
				<font color="#FF8080"> <em> <strong>A</strong>
				</em>
				</font> <font color="#8080FF"> <em> <strong>R</strong>
				</em>
				</font> <font color="#FF8080"> <em> <strong>C</strong>
				</em>
				</font> <font color="#8080FF"> <em> <strong>H</strong>
				</em>
				</font> <font color="#FF8080"> <em> <strong>I</strong>
				</em>
				</font> <font color="#8080FF"> <em> <strong>W</strong>
				</em>
				</font> <font color="#FF8080"> <em> <strong>U</strong>
				</em>
				</font> <font color="#8080FF"> <em> <strong>M</strong>
				</em>
				</font>
			</h1>
		</div>

 
<?php
echo <<< EOT
<chapter> <chapter_title>Testy</chapter_title> <normal_text
			style="margin-right: 2%; margin-left: 2%">
EOT;
wypiszPrzedmiot("Testy");
echo <<< EOT
</normal_text>
<chapter> <chapter_title>Matematyka</chapter_title> <normal_text
			style="margin-right: 2%; margin-left: 2%"> 
EOT;

wypiszPrzedmiot("Matematyka");
echo <<< EOT
</normal_text>
<chapter> <chapter_title>Informatyka</chapter_title> <normal_text
			style="margin-right: 2%; margin-left: 2%"> 
EOT;
wypiszPrzedmiot("Informatyka");
echo <<< EOT
</normal_text>
<chapter> <chapter_title>Bioinformatyka</chapter_title> <normal_text
			style="margin-right: 2%; margin-left: 2%"> 
EOT;
wypiszPrzedmiot("Bioinformatyka");
echo "</normal_text>"
?>




	<div class="welcome-popup" id="WelcomeMessage">
		<h1>Witaj na stronie archiwum egzaminów!</h1>
		
		<span style="font-size: 1.4vw">Jeśli chesz wrzucić materiały:</span><br>
		&nbsp;&emsp; - upewnij się że skany są dobrej jakości<br>
		&nbsp;&emsp; - strona przyjmuje tylko pliki .pdf oraz niektóre pliki archiwów: .zip oraz tar.gz<br>
		&nbsp;&emsp; - proszę nie wrzucaj dużych plików, niestety nie mam dużo miejsa na dysky :/<br>
		Jeśli już to zrobiłeś to uzupełnij fomularz w prawym dolnym rogu.<br>
		PS: Ta strona używa ciasteczek<br>
		<span style="font-size: 0.1vw">Klikając "Close" sprzedajesz duszę diabłu.</span>
		<button class="close-button" onclick="closeWelcome()">Close</button>
		<script>
		    var welcome = localStorage.getItem('welcome') || '';
		    if (welcome == 'yes') {
				document.getElementById("WelcomeMessage").style.display = "none";
   		 	}
		function closeWelcome() {
		  document.getElementById("WelcomeMessage").style.display = "none";
		  localStorage.setItem('welcome','yes');
		} 
		</script>
	</div>
	
	<?php
		if(!isset($_SESSION["zalogowany"]) || !$_SESSION["zalogowany"]){
   			echo "<button class=\"open-button\" onclick=\"openForm()\">Login</button>";
   		}	
	?>
		
		<div class="form-popup" id="myForm">
		  <form action="" class="form-container" method="post" enctype="multipart/form-data">
			<h1>Miło cię widzieć!</h1>

			<label for="email"><b>Email: (z MIM-u)</b></label>
			<input type="text" placeholder="np: xx123456@students.mimuw.edu.pl" name="email" required>

			<label for="psw"><b>kod: (jeśli jesteś pierwszy raz zostaw puste)</b></label>
			<input type="password" placeholder="kod z maila" name="psw">

			<button type="submit" name="login" class="btn">Login</button>
			<button type="button" class="btn cancel" onclick="closeForm()">Close</button>
		  </form>
		</div>

		<script>
		function openForm() {
		  document.getElementById("myForm").style.display = "block";
		}

		function closeForm() {
		  document.getElementById("myForm").style.display = "none";
		}	
		</script>
	</div>

</body>
</html>
<?php
ob_flush();
?>
