const plik_tresc = document.getElementById('plik_tresc_id');

plik_tresc.addEventListener('change', function(){
  document.getElementById('label_plik_tresc_id').innerHTML
                =  this.files[0].name;
})
