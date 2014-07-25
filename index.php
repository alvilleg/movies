<?php

echo "Hello World!";

 $apiKey = "f09d819ed8472a76885ae1c995eeb878";

 $query = "little";
 $url = "http://api.themoviedb.org/3/search/movie";

 $caller = new Caller();
 $req_data =  'query='.$query.'&api_key='.$apiKey;

 urlencode ($req_caller->json_encode_ex($data));
 echo 'Last error'.json_last_error(); 
	//
 echo "<a href=".$url.'?'.$req_data." >Movies</a><br>";
 $result = $req_caller->doPost($zoningApiUrl,$req_data);

 echo $result;


?>
