Movies
======

Movie search app: 

Search actors and movies using the http://www.themoviedb.org/ APIs

The application was created in PHP using AngularJS and bootstrap

It's running in http://alde-movie-search.herokuapp.com/


### Main page: 
[index.php](./index.php)

### API calls: 
 * Wrap api calls: [client.php](./client.php)
 * Use curl libray to execute the POST or GET methods: [caller.php](./caller.php)
  
 
### AngularJS Controller
  Ajax calls and model updates: [app.js](./js/app.js)

### API calls
These are used for AJAX calls:
 * Find persons by keyword: [query_person.php](./query_person.php)
 * Find person profile by id: [query_person_profile.php](./query_person_profile.php)
 * Find movies by keyword: [query_movies.php](./query_movies.php)
 * Find movie details: overview, cast and crew: [query_movie_details.php](./query_movie_details.php)
 
