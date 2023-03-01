<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function checkString($nazwa)
{
    require 'php_helpers/blackList.php';
    $nazwa = strtolower($nazwa);
    if (strlen($nazwa) > 100) {
        echo '<script>alert("twój komentarz jest za długi")</script>';
        return false;
    }
    $reg = '~\b' . implode('\b|\b', $blackList) . '\b~';

    $nazwa = strtr($nazwa, "013458", "oieasb");
    $nazwa = strtr($nazwa, "!$", "is");

    preg_match_all($reg, preg_replace('~[.,?! ]~', '', $nazwa), $matches);

    if (count($matches[0]) > 0) {
        echo '<script>alert("Proszę nie przeklinać/obgadywać dziekana :/")</script>';
        return false;
    }
    return true;
}

function uploadFile($file, $target_file)
{
    // echo "to jest plik: " . $target_file . "<br>";
    // Check if file already exists
    if (file_exists($target_file)) {
        echo '<script>alert("Sorry, file already exists.")</script>';
        return false;
    }

    // Check file size
    // echo "rozmiar " . $_FILES[$file]["size"] . "<br>";
    if ($_FILES[$file]["size"] > 1000000000) {
        echo '<script>alert("Sorry, your file is too large.")</script>';
        return false;
    }

    // Allow certain file formats
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($imageFileType != "pdf" && $imageFileType != "xz" && $imageFileType != "zip") {
        echo '<script>alert("Sorry, only PDF, ZIP, tar.xz files are allowed.")</script>';
        return false;
    }
    if (move_uploaded_file($_FILES[$file]["tmp_name"], $target_file)) {
        echo '<script>alert("The file " . htmlspecialchars(basename($_FILES[$file]["name"])) . " has been uploaded.")</script>';
        return true;
    }
    echo '<script>alert("Not uploaded " . $_FILES[$file]["name"] . " because of error #" . $_FILES[$file]["error"])</script>';
    return false;
}

function counter(){
	$file = '/home/students/mat/w/ww439108/public_html/archiwum/file_counter.txt';

	// default the counter value to 1
	$counter = 1;

	// add the previous counter value if the file exists    
	if (file_exists($file)) {
		$counter += intval(file_get_contents($file));
	}

	// write the new counter value to the file
	file_put_contents($file, $counter);
	return $counter;
}
function getFilesUpload($target_dir, $tresc, $rozw)
{

	$filteredNumbers = array_filter(preg_split("/\D+/", shell_exec("du -s")));
	$size = reset($filteredNumbers);
	if($size>2000000)
	{
		echo '<script>alert("Nie ma już miejsca na więcej plików.")</script>';
        return false;
	}
    if (checkString($_POST["komentarz"]) == false)
        return false;

    // echo $target_dir;
    // echo "<br> tresc: ";
    // echo $tresc; echo "<br> rozw: ";
    // echo $rozw;
    if (! file_exists($_FILES[$tresc]['tmp_name']) || ! is_uploaded_file($_FILES[$tresc]['tmp_name'])) {
        echo '<script>alert("wgraj plik z zadaniami proszę...")</script>';
        return false;
    }
    $file_counter=counter();
    $path_zad = $target_dir ."zad(".$file_counter .")_". basename($_FILES[$tresc]["name"]);
    $uploadOk = uploadFile($tresc, $path_zad);
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == false) {
        return false;
    }

    // jeśli plik zadań wgrany
    if (isset($_POST['data_testu'])) {
        $date = date('Y-m-d', strtotime($_POST['data_testu']));
    }

    if (! file_exists($_FILES[$rozw]['tmp_name']) || ! is_uploaded_file($_FILES[$rozw]['tmp_name'])) {
        $path_rozw = "";
    } else {
        $path_rozw = $target_dir ."roz(".$file_counter .")_". basename($_FILES[$rozw]["name"]);
        $uploadOk = uploadFile($rozw, $path_rozw);
    }
    $informacje = array(
        $date,
        $path_zad,
        $path_rozw,
        $_POST["rodzaj"],
        $_POST["komentarz"],
        $_SESSION["zalogowany"],
         date("Y-m-d H-i-s")
    );
    if (($handle = fopen($target_dir . "files_informations.csv", "a")) !== FALSE) {
        fputcsv($handle, $informacje);
        fclose($handle);
        return true;
    } else {
        echo '<script>alert("AAAAAAAAAAAAA")</script>';
        return false;
    }
}

function printForm($nazwa)
{
    echo <<< EOT
    <form action="" method="post" enctype="multipart/form-data">
    	<input type="date" name="data_testu"
    		   value="1970-01-01"
    		   min="1970-01-01" max="2030-12-31">
    	  <select id="rodzaj" name="rodzaj">
    		<option value="Egzamin">Egzamin</option>
    		<option value="Egzamin*">Egzamin*</option>
    		<option value="Kolokwium">Kolokwium</option>
    		<option value="Kolokwium*">Kolokwium*</option>
    	  </select>
    <input type="file" id="{$nazwa}_id" name="{$nazwa}_id" value="" hidden/>
    <label for="{$nazwa}_id" class="label info" id="label_{$nazwa}_id">wgraj tresci zadań</label>
    <input type="file" id="roz_{$nazwa}_id" name="roz_{$nazwa}_id" value="" style="display:none;"/>
    <label for="roz_{$nazwa}_id" class="label info" id="label_roz_{$nazwa}_id">wgraj rozwiazania zadań</label>
    <input type="text" name="komentarz" placeholder="Komentarz">
    <input type="submit" name="submit_{$nazwa}" value="Save" />
    </form>
    
    <script>
    const plik_{$nazwa} = document.getElementById('{$nazwa}_id');
    const rozw_{$nazwa} = document.getElementById('roz_{$nazwa}_id');
    
    plik_{$nazwa}.addEventListener('change', function(){
      document.getElementById('label_{$nazwa}_id').innerHTML
    	            =  this.files[0].name;
    })
    rozw_{$nazwa}.addEventListener('change', function(){
      document.getElementById('label_roz_{$nazwa}_id').innerHTML
    	            =  this.files[0].name;
    })
    </script>
    EOT;
}
?>
