<html ng-app="moviesApp">
<?php
	include("prelude.php");
?>

<body>
<div ng-controller="SuggestionController">
	<input autocomplete="off" name="q" ng-model="query" ng-keyup="13: :getSuggestions();" />

	<ul ng-hide="hideSuggestions" style="{{suggestionStyle}}" id="suggestions" >
		<li class="suggestion" ng-repeat="suggestion in suggestions.results" 
			ng-click="showMovies(suggestion.id,suggestion.name);" role="option"
			>
			<a href="#">{{suggestion.name}} {{suggestion.id}} </a>
		</li>	
	</ul>


	<div ng-hide="hideMovies">
		<table class="table table-striped">
		<tr>
				<td>&nbsp;</td>
				<td >Release date</td>
				<td >Title </td>
				<td >Character </td>
				<td >&nbsp;</td>
		<tr>

		<tr class="movies" ng-repeat="movie in movies.cast" >
			<td>{{$index}}</td>	
			<td >{{movie.release_date}} &nbsp;</td>
			<td ><a href="#{{movie.id}}">{{movie.title}}&nbsp;</a> </td>
			<td >{{movie.character}}</td>
			<td ><img src="http://image.tmdb.org/t/p/w92{{movie.poster_path}}" /> </td>
		</div>
	</table>

</div>

<body>
</html>
