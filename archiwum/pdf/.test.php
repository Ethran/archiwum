 <!DOCTYPE HTML>
<html>
<head>
<style>
.label {
  color: white;
  padding: 8px;
	font-family: 'Source Code Pro', monospace;
    font-family: 'Ubuntu Mono', monospace;	
}
.label:hover {
  color: white;
  padding: 8px;
    font-weight: bold;
 font-family: 'Source Code Pro', monospace;
    font-family: 'Ubuntu Mono', monospace;	
}

#plik_tresc:valid  + .label
{
    background: #ccc
    display: inline-block;
}
#plik_tresc:invalid  + .label
{
    background: #fff
    display: inline-block;
}

.info {background-color: #2196F3;} /* Blue */
.success {background-color: #04AA6D;} /* Green */
.warning {background-color: #ff9800;} /* Orange */
.danger {background-color: #f44336;} /* Red */ 
.other {background-color: #e7e7e7; color: black;} /* Gray */ 


label {
  background-color: indigo;
  color: white;
  padding: 0.5rem;
  font-family: sans-serif;
  border-radius: 0.3rem;
  cursor: pointer;
  margin-top: 1rem;
}

#file-chosen{
  margin-left: 0.3rem;
  font-family: sans-serif;
}
</style>
</head>
<body>
<?php require 'upload.php';
 if(isset($_POST['submit'])){ //check if form was submitted
 	echo "test";
	getFiles();
	$_POST = array();
 }else{
 	printForm();
 }
?>



<br>

<!-- actual upload which is hidden -->
<input type="file" id="actual-btn" hidden/>

<!-- our custom upload button -->
<label for="actual-btn" id="lab">Choose File</label>


<script>
const actualBtn = document.getElementById('actual-btn');

actualBtn.addEventListener('change', function(){
  document.getElementById('lab').innerHTML
                =  this.files[0].name;
})
</script>

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
<input type="file" id="plik_tresc_id" name="plik_tresc" value="" hidden/>
<label for="plik_tresc_id" class="label info" id="label_plik_tresc_id">wgraj tresci zadań</label>
<input type="file" id="plik_rozwiazania" name="plik_rozwiazania" value="" style="display:none;"/>
<label for="plik_rozwiazania" class="label info">wgraj rozwiazania zadań</label>
<input type="text" name="komentarz" placeholder="Komentarz">
<input type="submit" name="submit" value="Save" />
</form>
<script>
const plik_tresc = document.getElementById('plik_tresc_id');

plik_tresc.addEventListener('change', function(){
  document.getElementById('label_plik_tresc_id').innerHTML
                =  this.files[0].name;
})
</script>

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
<input type="file" id="ecb69b16a28886bbbdf95e7806540e1328f75cb8_id" name="plik_tresc" value="" hidden/>
<label for="ecb69b16a28886bbbdf95e7806540e1328f75cb8_id" class="label info" id="label_ecb69b16a28886bbbdf95e7806540e1328f75cb8_id">wgraj tresci zadań</label>
<input type="file" id="plik_rozwiazania" name="plik_rozwiazania" value="" style="display:none;"/>
<label for="plik_rozwiazania" class="label info">wgraj rozwiazania zadań</label>
<input type="text" name="komentarz" placeholder="Komentarz">
<input type="submit" name="submit" value="Save" />
</form>

<script>
const plik_tresc = document.getElementById('ecb69b16a28886bbbdf95e7806540e1328f75cb8_id');

plik_tresc.addEventListener('change', function(){
  document.getElementById('label_ecb69b16a28886bbbdf95e7806540e1328f75cb8_id').innerHTML
	            =  this.files[0].name;
})
</script>


</body>
</html> 
