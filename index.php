<style>
	.poster{
		width: 100px;
		height: 100px;
	}

	.poster img{
		height:"42px"; 
		width:"42px";
	}
</style>

<?php
	function __autoload($class_name) {
    	include $class_name . '.php';
	}

	echo "Hello World!";

 $apiKey = "f09d819ed8472a76885ae1c995eeb878";

 $query = "little";
 $url = "http://api.themoviedb.org/3/search/movie";

 // http://api.themoviedb.org/3/search/movie/CQg9ZeVnKO1fhxBXLXaddn4iS7.jpg
 // https://api.themoviedb.org/3/movie/9587/images?api_key=f09d819ed8472a76885ae1c995eeb878&language=en&include_image_language=en,null
 // http://image.tmdb.org/t/p/w9587/9E6UwPQMybyMx1kqatzk5PD6WCg.jpg

 $caller = new Caller();
 $req_data =  'query='.urlencode($query).'&api_key='.$apiKey.'&page=5';

 //
 echo "<a href='".$url.'?'.$req_data."&page=1' >Movies</a><br>";
 $result = $caller->doGet($url,$req_data);

 echo json_encode($result);
 echo "================<br/>";

 echo "<table>";
 foreach ($result as $page ) {
 	
 	foreach ($page as $movie) {
 		echo "<tr>";
 		echo "<td>";
 		echo $movie['release_date'];
 		echo "</td>";

 		echo "<td>";
 		echo $movie['title'];
 		echo "</td>";

 		echo "<td>";
 		echo $movie['backdrop_path'];
 		echo "</td>";

 		echo "<td class='poster'>";
 			$imgUrl = "http://image.tmdb.org/t/p/w500".$movie[poster_path];
 			echo '<img width="100px" src="'.$imgUrl.'" />';
 		echo "</td>";

 		echo "</tr>";
 	}
 }
 echo "</table>";


?>
