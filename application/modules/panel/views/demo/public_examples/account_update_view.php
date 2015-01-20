<!DOCTYPE html>
<head>

    <title>Autopublicador Social</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="UTF-8" />
    <?php echo $this->load->view('includes2/head');?>




</head>

<body>
    <?php echo $this->load->view('includes2/header');

?>
            
			<section class="content">
				<section class="container">
					
<section class="row">
<section class="col-md-12">


<section id="infoMessage"><?php echo isset($message)?$message:'';?></section>      
<section class="col-md-6">
	<h3> Datos personales</h3>
	<?php echo form_open(uri_string());?>

      <section class="form-group">    
            <label class="label-form">Correo eletrónico</label>
           <input type="text" disabled class=" form-control" value="<?php echo $user['uacc_email']; ?>"/>
            
      </section>
	
      <section class="form-group">    
            <label>Plan actual</label><br />
            <?php $gropu=$this->flexi_auth->get_users_group_query('ugrp_name')->result();
            	echo $gropu[0]->ugrp_name; ?>
            
      </section>
        <section class="form-group">    
          
            <label class="label-form">Nombre</label>
           <input type="text" class="form-control " name="update_first_name" value="<?php echo $user['upro_first_name']; ?>"/>
            



       <?php $country=array (
  'AF' => 'Afganistan',
  'AX' => 'Åland-eilande',
  'AL' => 'Albanië',
  'DZ' => 'Algerië',
  'AS' => 'Amerikaans Samoa',
  'AD' => 'Andorra',
  'AO' => 'Angola',
  'AI' => 'Anguilla',
  'AQ' => 'Antarktika',
  'AG' => 'Antigua en Barbuda',
  'AR' => 'Argentinië',
  'AM' => 'Armenië',
  'AW' => 'Aruba',
  'AC' => 'Ascension-eiland',
  'AZ' => 'Aserbeidjan',
  'AU' => 'Australië',
  'BS' => 'Bahamas',
  'BH' => 'Bahrein',
  'BD' => 'Bangladesj',
  'BB' => 'Barbados',
  'BE' => 'België',
  'BZ' => 'Belize',
  'BJ' => 'Benin',
  'BM' => 'Bermuda',
  'BT' => 'Bhoetan',
  'BF' => 'Boerkina Fasso',
  'BO' => 'Bolivië',
  'BA' => 'Bosnië en Herzegowina',
  'BW' => 'Botswana',
  'BV' => 'Bouveteiland',
  'BR' => 'Brasilië',
  'IO' => 'Britse Indiese Oseaan Gebied',
  'VG' => 'Britse Maagde-eilande',
  'BN' => 'Broenei',
  'BG' => 'Bulgarye',
  'BI' => 'Burundi',
  'EA' => 'Ceuta en Melilla',
  'CL' => 'Chili',
  'CY' => 'Ciprus',
  'CP' => 'Clipperton-eiland',
  'CC' => 'Cocos- [Keeling] eilande',
  'KM' => 'Comore',
  'CK' => 'Cookeilande',
  'CR' => 'Costa Rica',
  'CD' => 'Demokratiese Republiek van die Kongo',
  'DK' => 'Denemarke',
  'DG' => 'Diego Garcia',
  'DJ' => 'Djiboeti',
  'DM' => 'Dominika',
  'DO' => 'Dominikaanse Republiek',
  'DE' => 'Duitsland',
  'EC' => 'Ecuador',
  'EG' => 'Egipte',
  'IM' => 'Eiland Man',
  'GQ' => 'Ekwatoriaal-Guinee',
  'ER' => 'Eritrea',
  'EE' => 'Estland',
  'ET' => 'Ethiopië',
  'EU' => 'Europese Unie',
  'FK' => 'Falklandeilande',
  'FO' => 'Faroëreilande',
  'FJ' => 'Fidji',
  'PH' => 'Filippyne',
  'FI' => 'Finland',
  'FR' => 'Frankryk',
  'GF' => 'Frans-Guyana',
  'PF' => 'Frans-Polinesië',
  'TF' => 'Franse Suidelike Gebiede',
  'GA' => 'Gaboen',
  'GM' => 'Gambië',
  'GE' => 'Georgië',
  'GH' => 'Ghana',
  'GI' => 'Gibraltar',
  'GD' => 'Grenada',
  'GR' => 'Griekeland',
  'GL' => 'Groenland',
  'GB' => 'Groot-Brittanje',
  'GP' => 'Guadeloupe',
  'GU' => 'Guam',
  'GT' => 'Guatemala',
  'GG' => 'Guernsey',
  'GN' => 'Guinee',
  'GW' => 'Guinee-Bissau',
  'GY' => 'Guyana',
  'HT' => 'Haïti',
  'HM' => 'Heard-eiland en McDonald-eilande',
  'HN' => 'Honduras',
  'HU' => 'Hongarye',
  'HK' => 'Hongkong',
  'IE' => 'Ierland',
  'IN' => 'Indië',
  'ID' => 'Indonesië',
  'IQ' => 'Irak',
  'IR' => 'Iran',
  'IL' => 'Israel',
  'IT' => 'Italië',
  'CI' => 'Ivoorkus',
  'JM' => 'Jamaika',
  'JP' => 'Japan',
  'YE' => 'Jemen',
  'JE' => 'Jersey',
  'JO' => 'Jordanië',
  'KY' => 'Kaaimanseilande',
  'CV' => 'Kaap Verde',
  'KH' => 'Kambodja',
  'CM' => 'Kameroen',
  'CA' => 'Kanada',
  'IC' => 'Kanarie-eilande',
  'KZ' => 'Kasakstan',
  'QA' => 'Katar',
  'KE' => 'Kenia',
  'CX' => 'Kerseiland',
  'KG' => 'Kirgisië',
  'KI' => 'Kiribati',
  'KW' => 'Koeweit',
  'CO' => 'Kolombië',
  'CG' => 'Kongo',
  'HR' => 'Kroasië',
  'CU' => 'Kuba',
  'LA' => 'Laos',
  'LS' => 'Lesotho',
  'LV' => 'Letland',
  'LB' => 'Libanon',
  'LR' => 'Liberië',
  'LY' => 'Libië',
  'LI' => 'Liechtenstein',
  'LT' => 'Litaue',
  'LU' => 'Luxemburg',
  'MO' => 'Macau SAR China',
  'MK' => 'Macedonië',
  'MG' => 'Madagaskar',
  'MW' => 'Malawi',
  'MV' => 'Maledive',
  'MY' => 'Maleisië',
  'ML' => 'Mali',
  'MT' => 'Malta',
  'MA' => 'Marokko',
  'MH' => 'Marshall-eilande',
  'MQ' => 'Martinique',
  'MU' => 'Mauritius',
  'YT' => 'Mayotte',
  'MX' => 'Meksiko',
  'MM' => 'Mianmar',
  'FM' => 'Mikronesië',
  'MD' => 'Moldova',
  'MC' => 'Monaco',
  'MN' => 'Mongolië',
  'ME' => 'Montenegro',
  'MS' => 'Montserrat',
  'MZ' => 'Mosambiek',
  'MR' => 'Mouritanië',
  'NA' => 'Namibië',
  'NR' => 'Naoeroe',
  'NL' => 'Nederland',
  'AN' => 'Nederlands-Antille',
  'NP' => 'Nepal',
  'NI' => 'Nicaragua',
  'NC' => 'Nieu-Kaledonië',
  'NZ' => 'Nieu-Seeland',
  'NE' => 'Niger',
  'NG' => 'Nigerië',
  'NU' => 'Niue',
  'KP' => 'Noord-Korea',
  'MP' => 'Noordelike Marianaeilande',
  'NO' => 'Noorweë',
  'NF' => 'Norfolk-eiland',
  'UA' => 'Oekraine',
  'UZ' => 'Oesbekistan',
  'OM' => 'Oman',
  'QO' => 'Omliggende Oseanië',
  'TL' => 'Oos-Timor',
  'AT' => 'Oostenryk',
  'PK' => 'Pakistan',
  'PW' => 'Palau',
  'PS' => 'Palestina',
  'PA' => 'Panama',
  'PG' => 'Papoea Nieu-Guinee',
  'PY' => 'Paraguay',
  'PE' => 'Peru',
  'PN' => 'Pitcairn',
  'PL' => 'Pole',
  'PT' => 'Portugal',
  'PR' => 'Puerto Rico',
  'RE' => 'Réunion',
  'RO' => 'Roemenië',
  'RU' => 'Rusland',
  'RW' => 'Rwanda',
  'KN' => 'Saint Kitts en Nevis',
  'VC' => 'Saint Vincent en die Grenadine',
  'SV' => 'Salvador',
  'WS' => 'Samoa',
  'SM' => 'San Marino',
  'ST' => 'Sao Tome en Principe',
  'SA' => 'Saoedi-Arabië',
  'SN' => 'Senegal',
  'CF' => 'Sentraal-Afrikaanse Republiek',
  'RS' => 'Serwië',
  'CS' => 'Serwië en Montenegro',
  'SC' => 'Seychelle',
  'SL' => 'Sierra Leone',
  'SG' => 'Singapoer',
  'BL' => 'Sint Barthélemy',
  'SH' => 'Sint Helena',
  'LC' => 'Sint Lucia',
  'MF' => 'Sint Martin',
  'PM' => 'Sint-Pierre en Miquelon',
  'SY' => 'Sirië',
  'CN' => 'Sjina',
  'SK' => 'Slowakye',
  'SI' => 'Slowenië',
  'SD' => 'Soedan',
  'SB' => 'Solomon Eilande',
  'SO' => 'Somalië',
  'ES' => 'Spanje',
  'LK' => 'Sri Lanka',
  'ZA' => 'Suid-Afrika',
  'GS' => 'Suid-Georgië en die Suid-Sandwich-eilande',
  'KR' => 'Suid-Korea',
  'SR' => 'Suriname',
  'SJ' => 'Svalbard en Jan Mayen',
  'SZ' => 'Swaziland',
  'SE' => 'Swede',
  'CH' => 'Switserland',
  'TJ' => 'Tadjikistan',
  'TW' => 'Taiwan',
  'TZ' => 'Tanzanië',
  'TH' => 'Thailand',
  'CZ' => 'Tjeggiese Republiek',
  'TG' => 'Togo',
  'TK' => 'Tokelau',
  'TO' => 'Tonga',
  'TT' => 'Trinidad en Tobago',
  'TA' => 'Tristan da Cunha',
  'TD' => 'Tsjaad',
  'TN' => 'Tunisië',
  'TM' => 'Turkmenië',
  'TC' => 'Turks en Caicos Eilande',
  'TR' => 'Turkye',
  'TV' => 'Tuvalu',
  'UG' => 'Uganda',
  'UY' => 'Uruguay',
  'VI' => 'V.S. Maagde-eilande',
  'VU' => 'Vanuatu',
  'VA' => 'Vatikaan',
  'VE' => 'Venezuela',
  'AE' => 'Verenigde Arabiese Emirate',
  'US' => 'Verenigde State van Amerika',
  'VN' => 'Viëtnam',
  'UM' => 'VS klein omliggende eilande',
  'WF' => 'Wallis en Futuna',
  'EH' => 'Wes-Sahara',
  'BY' => 'Wit-Rusland',
  'IS' => 'Ysland',
  'ZM' => 'Zambië',
  'ZW' => 'Zimbabwe',
);?>
 </section>
      <section class="form-group">
      <label for="">País</label>
      <select id="country" name="update_country" class="form-control">
			<?php foreach($country as $key => $val) {
			 ?>
				<option
					<?php if($key==$user['upro_country']){
					 ECHO 'selected="selected"';} ?>
					 value="<?php echo $key;?>">
					 <?php echo $val; ?>
					 </option>
				<?php } ?>
     	</select>
      </section>
      <section class="form-group">    
          
            <label class="label-form">Ciudad</label>
           <input type="text" class="form-control " name="update_city" value="<?php echo $user['upro_first_name']; ?>aaa"/>
            
      </section>
      <section class="form-group">    
          
            <label class="label-form">Dirección</label>
           <input type="text" class="form-control " name="update_address" value="<?php echo $user['upro_first_name']; ?>"/>
            
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
								<label class="label-form" for="current_password">Contraseña antigua:</label>
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
</section>
</section>
</section>
</section>                  
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>