<!DOCTYPE html>
<head>

    <title>Socialsuites</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="UTF-8" />
    <?php echo $this->load->view('includes2/head');?>




</head>

<body>
    <?php echo $this->load->view('includes2/header');

?>
            
  <?php if (! empty($message)) { ?>
                    <section class=" panel bg-info" id="infoMessage">
                      <div class="text-center panel-heading bg-info bg-info-dark-info-message">
                      <?php echo $message; ?>
                      </div>
                    </section>
                  <?php } ?>
            
<section class="col-md-6">
	<h3> Datos personales</h3>
	<?php echo form_open(uri_string());?>

      <section class="form-group">    
            <label class="label-form">Correo eletrónico</label>
           <input type="text" disabled class=" form-control" value="<?php echo $user[0]->uacc_email; ?>"/>
            
      </section>
	
      <section class="form-group">    
            <label>Plan actual</label><br />
            <?php $gropu=$this->flexi_auth->get_users_group_query('ugrp_name')->result();
            	echo $gropu[0]->ugrp_name; ?>
            
      </section>
      
      
      <section class="form-group">
      	<label  class="label-form">Zona horaria</label>
      	<select name="timezone_offset"  class="form-control">
      	<?php
	foreach($this->config->item('timezones') as $KEY=>$val) 
       {
          

          $timezone=new DateTimeZone($val);
          $offset=($timezone->getOffset(new Datetime)/3600);
          $val=$val." (".($offset<0?$offset:'+'.$offset).")";
          if($user[0]->upro_timezone_offset==(real)$KEY
          	)
     	{
     		ECHO "<OPTIOn selected='selected' value='$KEY'>$val</option>";	
     	}
     	else
       		ECHO "<OPTIOn value='$KEY'>$val</option>";
       	
		}
		?>  
      
      	?>
      	</select>

      </section>
        <section class="form-group">    
          
            <label class="label-form">Nombre</label>
           <input type="text" class="form-control " name="update_first_name" value="<?php echo $user[0]->upro_first_name; ?>"/>
            



       <?php 

  $countries = array(
 'Europa'=>array(
  "AL"=>"Albania",
  "DE"=>"Alemania",
  "AD"=>"Andorra",
  "AM"=>"Armenia",
  "AT"=>"Austria",
  "AZ"=>"Azerbaiyán",
  "BE"=>"Bélgica",
  "BY"=>"Bielorrusia",
  "BA"=>"Bosnia y Herzegovina",
  "BG"=>"Bulgaria",
  "CY"=>"Chipre",
  "VA"=>"Ciudad del Vaticano (Santa Sede)",
  "HR"=>"Croacia",
  "DK"=>"Dinamarca",
  "SK"=>"Eslovaquia",
  "SI"=>"Eslovenia",
  "ES"=>"España",
  "EE"=>"Estonia",
  "FI"=>"Finlandia",
  "FR"=>"Francia",
  "GE"=>"Georgia",
  "GR"=>"Grecia",
  "HU"=>"Hungría",
  "IE"=>"Irlanda",
  "IS"=>"Islandia",
  "IT"=>"Italia",
  "XK"=>"Kosovo",
  "LV"=>"Letonia",
  "LI"=>"Liechtenstein",
  "LT"=>"Lituania",
  "LU"=>"Luxemburgo",
  "MK"=>"Macedonia, República de",
  "MT"=>"Malta",
  "MD"=>"Moldavia",
  "MC"=>"Mónaco",
  "ME"=>"Montenegro",
  "NO"=>"Noruega",
  "NL"=>"Países Bajos",
  "PL"=>"Polonia", 
  "PT"=>"Portugal",
  "UK"=>"Reino Unido",
  "CZ"=>"República Checa",
  "RO"=>"Rumanía", 
  "RU"=>"Rusia",
  "SM"=>"San Marino",
  "SE"=>"Suecia", 
  "CH"=>"Suiza",
  "TR"=>"Turquía",
  "UA"=>"Ucrania",
  "YU"=>"Yugoslavia",
 ),

 "África"=>array(
  "AO"=>"Angola",
  "DZ"=>"Argelia",
  "BJ"=>"Benín",
  "BW"=>"Botswana",
  "BF"=>"Burkina Faso",
  "BI"=>"Burundi",
  "CM"=>"Camerún",
  "CV"=>"Cabo Verde",
  "TD"=>"Chad",
  "KM"=>"Comores",
  "CG"=>"Congo",
  "CD"=>"Congo, República Democrática del",
  "CI"=>"Costa de Marfil",
  "EG"=>"Egipto",
  "ER"=>"Eritrea",
  "ET"=>"Etiopía",
  "GA"=>"Gabón",
  "GM"=>"Gambia",
  "GH"=>"Ghana",
  "GN"=>"Guinea",
  "GW"=>"Guinea Bissau",
  "GQ"=>"Guinea Ecuatorial",
  "KE"=>"Kenia",
  "LS"=>"Lesoto",
  "LR"=>"Liberia",
  "LY"=>"Libia",
  "MG"=>"Madagascar",
  "MW"=>"Malawi",
  "ML"=>"Malí",
  "MA"=>"Marruecos",
  "MU"=>"Mauricio",
  "MR"=>"Mauritania",
  "MZ"=>"Mozambique",
  "NA"=>"Namibia",
  "NE"=>"Níger",  
  "NG"=>"Nigeria",
  "CF"=>"República Centroafricana",
  "ZA"=>"República de Sudáfrica",
  "RW"=>"Ruanda",
  "EH"=>"Sahara Occidental",
  "ST"=>"Santo Tomé y Príncipe",
  "SN"=>"Senegal",  
  "SC"=>"Seychelles", 
  "SL"=>"Sierra Leona",
  "SO"=>"Somalia",
  "SD"=>"Sudán",
  "SS"=>"Sudán del Sur",
  "SZ"=>"Suazilandia",
  "TZ"=>"Tanzania",
  "TG"=>"Togo",
  "TN"=>"Túnez",
  "UG"=>"Uganda",
  "DJ"=>"Yibuti",
  "ZM"=>"Zambia",  
  "ZW"=>"Zimbabue",
 ),

 "Oceanía"=>array(
  "AU"=>"Australia",
  "FM"=>"Micronesia, Estados Federados de",
  "FJ"=>"Fiji",
  "KI"=>"Kiribati",
  "MH"=>"Islas Marshall",
  "SB"=>"Islas Salomón",
  "NR"=>"Nauru",
  "NZ"=>"Nueva Zelanda",
  "PW"=>"Palaos",
  "PG"=>"Papúa Nueva Guinea",
  "WS"=>"Samoa",
  "TO"=>"Tonga",
  "TV"=>"Tuvalu", 
  "VU"=>"Vanuatu", 
 ),

 "Sudamérica"=>array(
  "AR"=>"Argentina",
  "BO"=>"Bolivia",
  "BR"=>"Brasil",
  "CL"=>"Chile",
  "CO"=>"Colombia",
  "EC"=>"Ecuador",
  "GY"=>"Guayana",
  "PY"=>"Paraguay",
  "PE"=>"Perú",
  "SR"=>"Surinam",
  "TT"=>"Trinidad y Tobago",
  "UY"=>"Uruguay",
  "VE"=>"Venezuela",
 ),

 "Norteamérica y Centroamérica"=>array(
  "AG"=>"Antigua y Barbuda",
  "BS"=>"Bahamas",
  "BB"=>"Barbados",
  "BZ"=>"Belice",
  "CA"=>"Canadá",
  "CR"=>"Costa Rica",
  "CU"=>"Cuba",
  "DM"=>"Dominica",
  "SV"=>"El Salvador",
  "US"=>"Estados Unidos",
  "GD"=>"Granada",
  "GT"=>"Guatemala",
  "HT"=>"Haití",
  "HN"=>"Honduras",
  "JM"=>"Jamaica",
  "MX"=>"México",
  "NI"=>"Nicaragua",
  "PA"=>"Panamá",
  "PR"=>"Puerto Rico",
  "DO"=>"República Dominicana",
  "KN"=>"San Cristóbal y Nieves",
  "VC"=>"San Vicente y Granadinas",
  "LC"=>"Santa Lucía",
 ),

 "Asia"=>array(
  "AF"=>"Afganistán",
  "SA"=>"Arabia Saudí",
  "BH"=>"Baréin",
  "BD"=>"Bangladesh",
  "MM"=>"Birmania",
  "BT"=>"Bután",
  "BN"=>"Brunéi",
  "KH"=>"Camboya",
  "CN"=>"China",
  "KP"=>"Corea, República Popular Democrática de",
  "KR"=>"Corea, República de",
  "AE"=>"Emiratos Árabes Unidos",
  "PH"=>"Filipinas",
  "IN"=>"India",
  "ID"=>"Indonesia",
  "IQ"=>"Iraq", 
  "IR"=>"Irán",
  "IL"=>"Israel",
  "JP"=>"Japón",
  "JO"=>"Jordania",
  "KZ"=>"Kazajistán",
  "KG"=>"Kirguizistán",
  "KW"=>"Kuwait",
  "LA"=>"Laos",
  "LB"=>"Líbano",
  "MY"=>"Malasia",
  "MV"=>"Maldivas",
  "MN"=>"Mongolia",
  "NP"=>"Nepal",
  "OM"=>"Omán",
  "PK"=>"Paquistán",
  "QA"=>"Qatar",
  "SG"=>"Singapur",
  "SY"=>"Siria",
  "LK"=>"Sri Lanka",
  "TJ"=>"Tayikistán",
  "TH"=>"Tailandia",
  "TP"=>"Timor Oriental",
  "TM"=>"Turkmenistán",
  "UZ"=>"Uzbekistán",
  "VN"=>"Vietnam",
  "YE"=>"Yemen",
 ), 
);?>
 </section>
      <section class="form-group">
      <label for="">País</label>
      <select id="country" name="update_country" class="form-control">
	
			<?php
			foreach ($countries as $country=> $value) {
			 	?>
			 	
			 	 <?php
				  foreach($value as $key => $val) {
				 ?>
					<option
						<?php if($key==$user[0]->upro_country){
						 ECHO 'selected="selected"';} ?>
						 value="<?php echo $key;?>">
						 <?php echo $val; ?>
						 </option>
					<?php } 
				}?>
     	</select>
      </section>
      <section class="form-group">    
          
            <label class="label-form">Ciudad</label>
           <input type="text" class="form-control " name="update_city" value="<?php echo $user[0]->upro_city; ?>"/>
            
      </section>
      <section class="form-group">    
          
            <label class="label-form">Dirección</label>
           <input type="text" class="form-control " name="update_address" value="<?php echo $user[0]->upro_address; ?>"/>
            
      </section>
      	<div class="text-center col-sm-12">
			
			<input class="btn btn-primary" type="submit" name="update_account" id="submit" value="Guardar"	/>
		</div>
      </form>
</section>
<section class="col-md-6">
	<h3> Cambiar contraseña</h3>
					<?php echo form_open(uri_string());?>

							<div class="form-group">
								<label class="label-form" for="current_password">Contraseña actual:</label>
								<input class="form-control" type="password" id="current_password" name="current_password" value="<?php echo set_value('current_password');?>"/>
							</div>
							<div class="form-group">
								<label class="label-form" for="new_password">Nueva contraseña:</label>
								<input class="form-control" type="password" id="new_password" name="new_password" value="<?php echo set_value('new_password');?>"/>
							</div>
							<div class="form-group">
								<label class="label-form" for="confirm_new_password">Repetir nueva contraseña:</label>
								<input class="form-control" type="password" id="confirm_new_password" name="confirm_new_password" value="<?php echo set_value('confirm_new_password');?>"/>
							</div>
							<div class="text-center col-sm-12">
								
								<input class="btn btn-primary" type="submit" name="change_password" id="submit" value="Cambiar"	/>
							</div>
					
					
				
 </section>
      

<?php echo form_close();?>

<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>