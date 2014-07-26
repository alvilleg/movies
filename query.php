<?php
	function __autoload($class_name) {
		echo $class_name."<br/>";
    	include $class_name . '.php';
	}

	include("prelude.php");
 $api_key = "f09d819ed8472a76885ae1c995eeb878";
 $query = $_POST['q'];
 echo "Parameters: ".$query;


 // Create the client
 $client = new client();
 $client->set_api_key($api_key);
 $result = $client->get_movies($query);
 $result_person = $client->get_movies_by_actor($query);
 //
 print_movie_table($result,$client);
 print_person_table($result_person,$client);
 
 // http://api.themoviedb.org/3/search/movie/CQg9ZeVnKO1fhxBXLXaddn4iS7.jpg
 // https://api.themoviedb.org/3/movie/9587/images?api_key=f09d819ed8472a76885ae1c995eeb878&language=en&include_image_language=en,null
 // http://image.tmdb.org/t/p/w9587/9E6UwPQMybyMx1kqatzk5PD6WCg.jpg


 //echo json_encode($result);
 //echo "================<br/>";

function print_person_table($result,$client){
	 echo "<table style='width:90%;'>";
	 echo "<th>Name</th>";
	 
	 print_r($result);	

	 foreach ($result['results'] as $person ) {
 		echo "<tr>";
 		echo "<td>";
 		echo "<a href='".$client->get_person_details_URL($person)."' >". $person['name']."</a>";
 		echo "</td>";

 		echo "<td class='poster'>";
 			echo '<img width="100px" src="'.$client->get_person_img_URL($person).'" />';
 		echo "</td>";

 		echo "</tr>";
	 	
	 }
	 echo "</table>";
}


function print_movie_table($result,$client){
	 echo "<table style='width:90%;'>";
	 echo "<th>Release date</th>";
	 echo "<th>Title</th>";
	 echo "<th>&nbsp;</th>";
	 
	 print_r($result);	

	 foreach ($result['results'] as $movie ) {
 		echo "<tr>";
 		echo "<td>";
 		echo $movie['release_date'];
 		echo "</td>";

 		echo "<td>";
 		echo $movie['title'];
 		echo "</td>";

 		echo "<td class='poster'>";
 			echo '<img width="100px" src="'.$client->get_movie_poster_URL($movie).'" />';
 		echo "</td>";

 		echo "</tr>";
	 	
	 }
	 echo "</table>";
}

?>
<html>
