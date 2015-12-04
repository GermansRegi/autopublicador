<?php 
$config['googleplus']['application_name'] = 'API Project'; #Use must have to use same application name which you register with google. Using APIs & Auth->Consent Screen
$config['googleplus']['client_id'] = '135420347214-v2l0jvmsaqegrd6klodh170bhdumvia8.apps.googleusercontent.com';
$config['googleplus']['client_secret'] = '7Z6Ah_TsgkgxazXsrzWXm1JF';
$config['googleplus']['redirect_uri'] = 'http://www.sergiregi.com/autopublicador/panel/google/connectar'; #Add redirect url which you add in google console.
$config['googleplus']['api_key'] = ''; #Add Browser Key
$config['googleplus']['scopes'] = Array('https://www.googleapis.com/auth/plus.me', 'https://www.googleapis.com/auth/plus.login','https://www.googleapis.com/auth/plus.moments.write');
$config['googleplus']['actions'] = Array('http://schemas.google.com/AddActivity');
