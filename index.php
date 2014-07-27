<html ng-app="moviesApp">
<?php
	include("prelude.php");
?>

<body>
	<section role="main" class="container main-body">

<header class="header header-fixed">
	<section class="navbar navbar-inverse docs-navbar-primary ng-scope">
        <div class="container">
          <div class="row">
            <div class="col-md-9 header-branding">
              <a class="brand navbar-brand" href="#">
                <img class="logo" src="img/movie-logo.svg">
              </a>
              <ul class="nav navbar-nav">
                <li class="divider-vertical"></li>
                <li><a href="#"><i class="icon-home icon-white"></i> Home</a></li>
              </li>
            </div>
        </div>        
    </section>    
</header>	

<h1>Movie search</h1>




<div ng-controller="SuggestionController">

	<script type="text/ng-template" id="myModalContent.html">
        <div class="modal-header">
            <h3 class="modal-title">{{items.title}}</h3>
        </div>
        <div class="modal-body">
        	<img src="http://image.tmdb.org/t/p/w92{{items.poster_path}}" />
        	<br/>
        	<span ng-if="items.tagline"> "{{items.tagline}}"</span>
        	<br/>
           {{items.overview}}
           <br>
           <br>
           
           <b>Genres:</b> 
           <span ng-repeat="gen in items.genres">{{gen.name}}<span ng-show=" !$last">,</span> 
           </span>
           
           <br/>
           <br/>
           
           <b>Produced by:</b> 
           <span ng-repeat="prod in items.production_companies">{{prod.name}}<span ng-show=" !$last">, 
           </span>
           </span>

        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" ng-click="ok()">OK</button>
            <button class="btn btn-warning" ng-click="cancel()">Cancel</button>
        </div>
    </script>

	<table style="width:100%;">
	<tr>
	<td>	
	<label>By person</label>
	<input autocomplete="off" name="q" ng-model="query" ng-keyup="getSuggestions()" placeholder="Enter a key word for search persons"/>
	</td>
	<td>
	<label>By keyword</label>
	<input autocomplete="off" ng-init="c=0;" name="qm" ng-model="queryMovies" ng-keyup="$event.keyCode==13? getMoviesByKeyword(1): null" placeholder="Enter a key word for search movies"/>
	<span>Press Enter to execute the search <span>
	</td>
	</tr>
	</table>

	<ul ng-hide="hideSuggestions" style="{{suggestionStyle}}" id="suggestions" >
		<li class="suggestion" ng-repeat="suggestion in suggestions.results| orderBy:'name'" 
			ng-click="showMovies(suggestion)" role="option"
			>
			<a href="#">{{suggestion.name}} {{suggestion.id}} </a>
		</li>	
	</ul>

	
	<div ng-init="predicate = 'release_date';" ng-hide="hideMovies" >
		
		<div ng-hide="hideProfile" id="profile">
			<table>
				<tr><td style="width:20em;">
			<img src="http://image.tmdb.org/t/p/w92{{personProfile.profile_path}}" />
			<br>
			<span >Name:</span> {{personProfile.name}}
			<br>
			<span >Place of birth:</span> {{personProfile.place_of_birth}}
			<br>
			<span >Birthday: </span>{{personProfile.birthday}}
			<br>
			</td>
			<td>
				{{personProfile.biography}}
			</td>
			</table>	
		</div>

		<h2>Movies</h2>
		<ul class="pagination">
			<li ng-repeat="pg in pageIndexes">
				<a  href="#" ng-click="getMoviesByKeyword(pg)" >{{pg}}</a>
			</li>
			
		</ul>
		
		<table class="table table-striped">
		<tr>
				<td >&nbsp;</td>

				<td ><a href="" ng-click="predicate = 'title'; reverse=!reverse">Title</a> </td>

				<td ng-if="!hideProfile">Character</td>
				<td ><a href="" ng-click="predicate = 'release_date'; reverse=!reverse">Release date</a></td>
		<tr>

		<tr class="movies" ng-repeat="movie in movies | orderBy:predicate:reverse" >
			<td ><img src="http://image.tmdb.org/t/p/w92{{movie.poster_path}}" /> </td>
			<td ><a ng-click="getMovieDetails(movie.id);" href="#{{movie.id}}">{{movie.title}}&nbsp;{{count}}</a> 

			</td>
			<td ng-if="!hideProfile">{{movie.character}}</td>
			<td >{{movie.release_date}} &nbsp;</td>
		</div>
	</table>

</div>

</section>
<body>
</html>
