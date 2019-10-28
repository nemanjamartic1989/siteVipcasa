<!-- INFO FORMA -->
  

<div class="info-container">
<button type="button" class="info-button" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"><div class="b-left pull-left"><h4>Pošalji upit</h4></div><div class="b-right pull-right"><h4>></h4></div></button>
</div>



<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">POŠALJI UPIT</h4>
      </div>
      <div class="modal-body">
      <script type="text/javascript">
        function form_check(){
            //jAlert('You have to fill your surname *', 'Form Alert Dialog');
            
            var contactname = document.getElementById('contactname');
            if(contactname.value != ""){
            //return true
            }else{
            $('#processing').html('Unesite ime!');
            return false
            }
            
            var contactlokacija = document.getElementById('contactlokacija');
            if(contactlokacija.value != ""){
           // return true
            }else{
            $('#processing').html('Izaberite lokaciju!');
            return false
            }
           	
           	var contactmessage = document.getElementById('contactmessage');
            if(contactmessage.value != ""){
           // return true
            }else{
            $('#processing').html('Unesite poruku!');
            return false
            }
            
            var contactno = document.getElementById('contactno');
            if(contactno.value != ""){
           // return true
            }else{
            $('#processing').html('Unesite telefon!');
            return false
            }
            
            var contactemail = document.getElementById('contactemail');
            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            
            //if(person_email.value != ""){
            if(contactemail.value.search(filter) == -1){
            $('#processing').html('Unesite pravilnu email adresu!');
            return false
                
            }else{
            //return true
            }
 
            
            return true
            
           
           }
           
           function clear_data(){
           var contactname = document.getElementById('contactname');
           contactname.value = "";
           
           var contactemail = document.getElementById('contactemail');
           contactemail.value = "";
           
           var contactmessage = document.getElementById('contactmessage');
           contactmessage.value = "";
           
           var contactno = document.getElementById('contactno');
           contactno.value = "";
           $('#processing').html(' ');
           }
        </script>
        <form>
          <div class="form-group">
          	<label>Lokacija: <span>*</span></label>
			<br/>
			<select id="contactlokacija" name="contactlokacija">
            <?php
		    $sqlLok = "SELECT l.id, l.naziv, l.mesto, l.adresa, l.status FROM lokacija l ORDER BY l.id ASC";
		    $rezLok = mysql_query($sqlLok);
		    if(mysql_num_rows($rezLok)>0){
		        while (list($id_l, $nazivl, $mestol, $adresal, $statusl)=@mysql_fetch_row($rezLok)) {
		        		echo '<option value="'.$id_l.'">'.$nazivl.'</option>';
		    		}
		    	}
		    ?>
			</select>
			<br/>
		  
			<label>Ime: <span>*</span></label>
			<br/>
			<input type="text" id="contactname" name="contactname" placeholder=""/><br/>
			<br/>
			<label>Email: <span>*</span></label>
			<br/>
			<input type="text" id="contactemail" name="contactemail" placeholder=""/><br/>
			<br/>
			<label>Broj telefona: <span>*</span></label>
			<br/>
			<input type="text" id="contactno" name="contactno" placeholder=""/><br/>
			<br/>
			<label>Poruka:</label>
			<br/>
			<textarea id="contactmessage" name="contactmessage" placeholder=""></textarea><br/>
			<br/>
			<p id="processing" style="background-color: #2c3257;color: #fff;text-transform: uppercase;padding-left: 20px;padding-right: 20px;"></p>
          </div>
   
	      </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn" data-dismiss="modal">Odustani</button>
        <button type="button" class="btn" onclick="provera = form_check(); if(provera){var contactname = $('#contactname').val(); var contactlokacija = $('#contactlokacija').val(); var contactemail = $('#contactemail').val(); var contactno = $('#contactno').val(); var contactmessage = $('#contactmessage').val(); $('#processing').load('/ajax/ajax.php',{akcija: 'registracija_proces', contactname: contactname, contactlokacija: contactlokacija, contactemail: contactemail, contactno: contactno, contactmessage: contactmessage}).fadeIn('slow');}">Pošalji</button>
      </div>
    </div>
  </div>
</div>