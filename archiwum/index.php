<?php
session_start();
require 'upload.php';
require 'login.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (isset($_POST['login']) && isset($_POST['email'])) {
	login_register();
}


function humanFileSize($size, $unit = "")
{
    if ((! $unit && $size >= 1 << 30) || $unit == "GB")
        return number_format($size / (1 << 30), 2) . "GB";
    if ((! $unit && $size >= 1 << 20) || $unit == "MB")
        return number_format($size / (1 << 20), 2) . "MB";
    if ((! $unit && $size >= 1 << 10) || $unit == "KB")
        return number_format($size / (1 << 10), 2) . "KB";
    return number_format($size) . " bytes";
}

function getFiles($path)
{
    // open directory
    $directory = opendir($path);
    // get each entry
    while ($entryName = readdir($directory)) {
        $items[] = $entryName;
    }
    closedir($directory);
    sort($items);
    return $items;
}

function drawTable($path)
{
    echo "<table>\n";
    echo "<thead><tr><th style=\"text-align: right\">Data</th> <th> Zadania: </th> <th>Rozwiązania:</th> <th>Komentarz:</th> </tr> </thead>\n";
    echo "<tbody>\n";

    // open file list:
    if (($handle = fopen($path . "/files_informations.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // todo: wyrzuc error
            echo "<tr>";
            echo "<td> $data[0]</td>";
            echo "<td> <a href=\"$data[1]\"> $data[3]</a></td>";
            if ($data[2] != "") {
                echo "<td> <a href=\"$data[2]\"> $data[3] rozw </a></td>";
            } else {
                echo "<td> brak</td>";
            }
            echo "<td> $data[4]</td>";
            echo "</tr>";
        }
        fclose($handle);
    }
    echo "</tbody></table>\n";
    $nazwa = hash('ripemd160', $path . "/");
    if (isset($_POST["submit_" . $nazwa])) { // check if form was submitted
        $result = getFilesUpload($path . "/", $nazwa . "_id", "roz_" . $nazwa . "_id");
        $_POST = array();
        if ($result) {
            header("Location: thank_you");
        }
    }
    echo "<br>";//.$_SESSION["zalogowany"];
   	if(isset($_SESSION["zalogowany"]) && $_SESSION["zalogowany"]){
    	printForm($nazwa);
    }
}

function wypiszPrzedmiot($pdfDirectory)
{
    $year = getFiles($pdfDirectory);
    echo "<ul class=\"collapse\">\n";

    for ($index = 0; $index < count($year); $index ++) {
        if (substr("$year[$index]", 0, 1) != "." && is_dir($pdfDirectory . "/" . $year[$index])) {
            echo "<li>$year[$index]<ul>";
            $subjects = getFiles($pdfDirectory . "/" . $year[$index]);
            for ($j = 0; $j < count($subjects); $j ++) {
                if (substr("$subjects[$j]", 0, 1) != "." && is_dir($pdfDirectory . "/" . $year[$index] . "/" . $subjects[$j])) {
                    echo "<li>$subjects[$j]<ul>";
                    drawTable($pdfDirectory . "/" . $year[$index] . "/" . $subjects[$j]);
                    echo "</ul></li>";
                }
            }
            echo "</ul></li>";
        }
    }
    echo "</ul>";
}

?>

<!doctype html>

<html lang="pl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Archiwum egzaminów</title>
<meta name="description" content="archiwum egzaminów">
<meta name="author" content="Wiktor Wichrowski>

  <meta 
	
	
	property="og:title" content="Archiwum egzaminów">
<meta property="og:type" content="website">
<meta property="og:url"
	content="https://students.mimuw.edu.pl/~ww439108/archiwium/">
<meta property="og:description" content="OSI training">
<meta property="og:image"
	content="https://students.mimuw.edu.pl/~ww439108/archiwum/rainbow.png">

<link rel="icon"
	href="https://students.mimuw.edu.pl/~ww439108/archiwum/rainbow.png">
<link rel="icon"
	href="https://students.mimuw.edu.pl/~ww439108/archiwum/penguin.svg"
	type="image/svg+xml">
<link rel="apple-touch-icon"
	href="https://students.mimuw.edu.pl/~ww439108/archiwium/rainbow.png">
<link rel="stylesheet"
	href="https://students.mimuw.edu.pl/~ww439108/css/styles.css?v=1.0">
<link rel="stylesheet"
	href="https://students.mimuw.edu.pl/~ww439108/archiwum/css/styles.css?v=1.0">
<link rel="stylesheet"
	href="https://students.mimuw.edu.pl/~ww439108/archiwum/css/styles_collapsible.css?v=1.0">
<script src="js/collapse-list.js"></script>
<script src="js/file-chooser.js"></script>
</head>

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

		<chapter> <chapter_title>Matematyka</chapter_title> <normal_text
			style="margin-right: 2%; margin-left: 2%"> 
 

<?php
wypiszPrzedmiot("Matematyka");
?>
</normal_text> <chapter> <chapter_title>Informatyka</chapter_title> <normal_text
			style="margin-right: 2%; margin-left: 2%"> 
<?php
wypiszPrzedmiot("Informatyka");
?>
</normal_text> <chapter> <chapter_title>Bioinformatyka</chapter_title> <normal_text
			style="margin-right: 2%; margin-left: 2%"> 
<?php
wypiszPrzedmiot("Bioinformatyka");
?>
</normal_text>



	<div class="welcome-popup" id="WelcomeMessage">
		Witaj na stronie archiwum egzaminów!
		<dl>
		  <dt>Jeśli chesz wrzucić materiały:</dt>
		  <dd>- upewnij się że skany są dobrej jakości</dd>
		  <dd>- strona przyjmuje tylko pliki .pdf oraz niektóre pliki archiwów: .zip oraz tar.gz</dd>
		  <dd>- proszę nie wrzucaj dużych plików, niestety nie mam dużo miejsa na dysky :/</dd>
		</dl>
		Jeśli już to zrobiłeś to uzupełnij fomularz w lewym dolnym rogu.<br>
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
	<button class="open-button" onclick="openForm()">Login</button>

	
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

?>
