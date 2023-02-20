<?php
session_start();
require 'upload.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


?>

<!doctype html>

<html lang="pl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Archiwum egzaminów</title>
  <meta name="description" content="archiwum egzaminów">
  <meta name="author" content="Wiktor Wichrowski>

  <meta property="og:title" content="Archiwum egzaminów">
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://students.mimuw.edu.pl/~ww439108/archiwium/">
  <meta property="og:description" content="OSI training">
  <meta property="og:image" content="https://students.mimuw.edu.pl/~ww439108/archiwum/rainbow.png">

  <link rel="icon" href="https://students.mimuw.edu.pl/~ww439108/archiwum/rainbow.png">
  <link rel="icon" href="https://students.mimuw.edu.pl/~ww439108/archiwum/penguin.svg" type="image/svg+xml">
  <link rel="apple-touch-icon" href="https://students.mimuw.edu.pl/~ww439108/archiwium/rainbow.png">

  <link rel="stylesheet" href="https://students.mimuw.edu.pl/~ww439108/archiwum/css/styles.css?v=1.0">
  <link rel="stylesheet" href="https://students.mimuw.edu.pl/~ww439108/archiwum/css/styles_collapsible.css?v=1.0">
  <script src="js/collapse-list.js"></script>
  <script src="js/file-chooser.js"></script>
</head>

<body>
<div id="content">

<div id="title">
  <h1>
    <font color="#FF8080">
      <em>
        <strong>A</strong>
      </em>
    </font>
    <font color="#8080FF">
      <em>
        <strong>R</strong>
      </em>
    </font>
    <font color="#FF8080">
      <em>
        <strong>C</strong>
      </em>
    </font>
    <font color="#8080FF">
      <em>
        <strong>H</strong>
      </em>
    </font>
    <font color="#FF8080">
      <em>
        <strong>I</strong>
      </em>
    </font>
    <font color="#8080FF">
      <em>
        <strong>W</strong>
      </em>
    </font>
    <font color="#FF8080">
      <em>
        <strong>U</strong>
      </em>
    </font>
    <font color="#8080FF">
      <em>
        <strong>M</strong>
      </em>
    </font>
  </h1>
</div>

<chapter>
<chapter_title>Matematyka</chapter_title> 
 <normal_text> 
 

<?php
function humanFileSize($size,$unit="") {
  if( (!$unit && $size >= 1<<30) || $unit == "GB")
    return number_format($size/(1<<30),2)."GB";
  if( (!$unit && $size >= 1<<20) || $unit == "MB")
    return number_format($size/(1<<20),2)."MB";
  if( (!$unit && $size >= 1<<10) || $unit == "KB")
    return number_format($size/(1<<10),2)."KB";
  return number_format($size)." bytes";
}
function getFiles($path) {
    // open directory 
    $directory = opendir($path);
    // get each entry
    while($entryName = readdir($directory)) {$items[] = $entryName;} closedir($directory);
    sort($items);
    return $items;
}
function drawTable($path) {
	echo "<table>\n";
	echo "<thead><tr><th style=\"text-align: right\">Data</th> <th> Zadania: </th> <th>Rozwiązania:</th> <th>Komentarz:</th> </tr> </thead>\n";
  	echo "<tbody>\n";

  	//open file list:
	if (($handle = fopen($path."/files_informations.csv", "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			//todo: wyrzuc error
			echo "<tr>";
			echo "<td> $data[0]</td>";
			echo "<td> <a href=\"$data[1]\"> $data[3]</a></td>";
			if($data[2]!=""){
				echo "<td> <a href=\"$data[2]\"> $data[3] rozw </a></td>";
			}else{
				echo "<td> brak</td>";
			}
			echo "<td> $data[4]</td>";
			echo "</tr>";
		}
		fclose($handle);
		

	}
  	echo "</tbody></table>\n";
	if(isset($_POST['submit'])){ //check if form was submitted
		$result = getFilesUpload($path."/");
		$_POST = array();
		if($result){
			header("Location: thank_you");
		}

	}
	echo "<br>";
	printForm($path);

}


    $pdfDirectory="pdf";
    $year=getFiles($pdfDirectory);
    echo "<ul class=\"collapse\">\n";

        for($index=0; $index < count($year); $index++) 
        {
            if (substr("$year[$index]", 0, 1) != "." && is_dir($pdfDirectory."/".$year[$index]))
            {
	    		echo "<li>$year[$index]<ul>";
				$subjects=getFiles($pdfDirectory."/".$year[$index]);
				for($j=0; $j < count($subjects); $j++) 
       			{
       				if (substr("$subjects[$j]", 0, 1) != "." && is_dir($pdfDirectory."/".$year[$index]."/".$subjects[$j]))
            		{
			    		echo "<li>$subjects[$j]<ul>";
			    		drawTable($pdfDirectory."/".$year[$index]."/".$subjects[$j]);
						echo "</ul></li>"; 
					}
				}
            	echo "</ul></li>";         
        	}
        }
    echo "</ul>";
    ?>
   

</normal_text> 
</div>

</body>
</html>
