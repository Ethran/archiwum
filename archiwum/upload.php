<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


	function uploadFile($file,$rozw, $target_dir ) {
		 if($rozw)
		 {
		 	$target_file = $target_dir ."rozw_". basename($_FILES[$file]["name"]);
		}
		else
		{
			$target_file = $target_dir . basename($_FILES[$file]["name"]);
		}
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		echo "to jest plik: ".$target_file."<br>";
		// Check if file already exists
		if (file_exists($target_file)) {
		  echo "Sorry, file already exists.<br>";
		  return 0;
		}

		// Check file size
		echo "rozmiar ".$_FILES[$file]["size"]."<br>";
		if ($_FILES[$file]["size"] > 1000000000) {
		  echo "Sorry, your file is too large."."<br>";
		  return 0;
		}

		// Allow certain file formats
		if($imageFileType != "pdf" && $imageFileType != "tar.xz" ) {
		  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
		  return 0;
		}
		if (move_uploaded_file($_FILES[$file]["tmp_name"], $target_file)) {
			echo "The file ". htmlspecialchars( basename( $_FILES[$file]["name"])). " has been uploaded.<br>";
			return 1;
	  	}
		echo "Not uploaded ".$_FILES[$file]["name"]." because of error #".$_FILES[$file]["error"]."<br>";
		return 0;

	}

function getFilesUpload($target_dir = "uploads/") {
	echo $target_dir;
	$tresc="plik_tresc";
	$rozw="plik_rozwiazania";

	$uploadOk = uploadFile($tresc, false, $target_dir );
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.<br>";
		return false;
	}

	
		//jeśli plik zadań wgrany
		if (isset($_POST['data_testu'])) {
			$date = date('Y-m-d', strtotime($_POST['data_testu']));
		}
		$path_zad=$target_dir . basename($_FILES[$tresc]["name"]);
		if (!file_exists($_FILES[$rozw]['tmp_name']) || !is_uploaded_file($_FILES[$rozw]['tmp_name'])) 
		{
			$path_rozw="";
		}
		else
		{
			$path_rozw= $target_dir ."rozw_".basename($_FILES[$tresc]["name"]);
			$uploadOk = uploadFile($rozw, true, $target_dir );
		}
		$target_dir . basename($_FILES[$rozw]["name"]);
		$informacje= array($date, $path_zad, $path_rozw,$_POST["rodzaj"], $_POST["komentarz"]);
		if (($handle = fopen($target_dir."files_informations.csv", "a")) !== FALSE) {
			fputcsv($handle, $informacje);
			fclose($handle);
			return true;
		}
		else{		
		return false;
			echo "AAAAAAAAAAAA";
		}

}

function printForm($nazwa){
	$nazwa=hash('ripemd160', $nazwa);
	echo <<< EOT
	<style>
	.label {
	  	color: white;
	  	padding: 5px;
		font-family: 'Source Code Pro', monospace;
		font-family: 'Ubuntu Mono', monospace;	
	}
	.label:hover {
	 	color: white;
	  	padding: 5px;
		font-weight: bold;
		font-family: 'Source Code Pro', monospace;
		font-family: 'Ubuntu Mono', monospace;	
	}

	.info {background-color: #2196F3;} /* Blue */
	</style>
	<form action="" method="post" enctype="multipart/form-data">
		<input type="date" name="data_testu"
			   value="2023-02-20"
			   min="2000-01-01" max="2030-12-31">
		  <select id="rodzaj" name="rodzaj">
			<option value="Egzamin">Egzamin</option>
			<option value="Egzamin*">Egzamin*</option>
			<option value="Kolokwium">Kolokwium</option>
			<option value="Kolokwium*">Kolokwium*</option>
		  </select>
	<input type="file" id="{$nazwa}_id" name="plik_tresc" value="" hidden/>
	<label for="{$nazwa}_id" class="label info" id="label_{$nazwa}_id">wgraj tresci zadań</label>
	<input type="file" id="roz_{$nazwa}_id" name="plik_rozwiazania" value="" style="display:none;"/>
	<label for="roz_{$nazwa}_id" class="label info" id="label_roz_{$nazwa}_id">wgraj rozwiazania zadań</label>
	<input type="text" name="komentarz" placeholder="Komentarz">
	<input type="submit" name="submit" value="Save" />
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
