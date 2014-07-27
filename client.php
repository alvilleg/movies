<?php
/*
	Client for the themoviedb API
*/
class Client{

	function __construct(){
  	}

	// Gets a list of movies with the keywork,
	// this return the first page, and the number of pages
	// also number of results by page
	function get_movies($keyword,$page){
		$url = "http://api.themoviedb.org/3/search/movie";
		$caller = new caller();
		$req_data =  'query='.urlencode($keyword).'&api_key='.$this->api_key.'&page='.$page;
		$result = $caller->doGet($url,$req_data);
		return $result;
	}

	// return the movie poster URL
	function get_movie_poster_URL($movie){
		if($movie[poster_path]){
			return "http://image.tmdb.org/t/p/w92".$movie[poster_path];
		}
	}


	function get_person_details_URL($person){
		return "http://api.themoviedb.org/3/person/".$person[id]."?api_key=".$this->api_key;
	}

	function get_person_img_URL($person){
		if($person[profile_path]){
			return "http://image.tmdb.org/t/p/w45".$person[profile_path];
		}
	}
	

	// returns movie details
	function get_movie_details($id){
		$url = "http://api.themoviedb.org/3/movie/".$id;
		$caller = new caller();
		$req_data =  'api_key='.$this->api_key; //.'&page=5';
		$result = $caller->doGet($url,$req_data);
		//
		$credits = $this->get_movie_credits($id);
		$credits_obj= json_decode($credits);
		//
		$movie_obj = json_decode($result);
		
		
		$movie_obj->credits=$credits_obj;
		return json_encode($movie_obj);
	}

	// returns movie credits
	function get_movie_credits($id){
		$url = "http://api.themoviedb.org/3/movie/".$id."/credits";
		$caller = new caller();
		$req_data =  'api_key='.$this->api_key; //.'&page=5';
		$result = $caller->doGet($url,$req_data);
		return $result;
	}

	//returns persons for keyword
	function get_persons($keyword){
		$url = "http://api.themoviedb.org/3/search/person";
		$caller = new caller();
		$req_data =  'query='.urlencode($keyword).'&api_key='.$this->api_key."&search_type=ngram"; //.'&page=5';
		$result = $caller->doGet($url,$req_data);
		return $result;
	}	

	//returns the movies a person has acted
	function get_person_movies($id){
		$url = "http://api.themoviedb.org/3/person/".$id."/movie_credits";
		$caller = new caller();
		$req_data =  'api_key='.$this->api_key; //.'&page=5';
		$result = $caller->doGet($url,$req_data);
		return $result;
	}	

	//returns the persons profile: biography
	
	function get_person_profile($id){
		$url = "http://api.themoviedb.org/3/person/".$id;
		$caller = new caller();
		$req_data =  'api_key='.$this->api_key; //.'&page=5';
		$result = $caller->doGet($url,$req_data);
		return $result;
	}	

	function set_api_key($api_key){
    	$this->api_key = $api_key;
  	}


  	function get_api_key($api_key){
    	$this->api_key = $api_key;
  	}
  	
  	public function __get( $property )
  	{
    	if( ! is_callable( array($this,'get_'.(string)$property) ) )
      		throw new BadPropertyException($this, (string)$property);

    	return call_user_func( array($this,'get_'.(string)$property) );
  	}

  	public function __set( $property, $value )
  	{
    	if( ! is_callable( array($this,'set_'.(string)$property) ) )
      		throw new BadPropertyException($this, (string)$property);

    	call_user_func( array($this,'set_'.(string)$property), $value );
  	}


}

?>