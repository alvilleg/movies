<?php
	function __autoload($class_name) {
    	include $class_name . '.php';
	}

 $api_key = "f09d819ed8472a76885ae1c995eeb878";
 $id = $_GET['id'];
 // Create the client
 $client = new client();
 $client->set_api_key($api_key);
 $result_person = $client->get_person_profile($id);
 echo $result_person;
 ?>