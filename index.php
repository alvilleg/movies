<html ng-app="moviesApp">
<?php
	include("prelude.php");
?>

<body>
<div ng-controller="SuggestionController">
	<input autocomplete="off" name="q" ng-model="query" ng-keyup="getSuggestions();" />

	<ul ng-hide="hideSuggestions" style="{{suggestionStyle}}" id="suggestions" >
		<li class="suggestion" ng-repeat="suggestion in suggestions.results" 
			ng-click="showMovies(suggestion.id);" role="option"
			>
			<a href="#">{{suggestion.name}} {{suggestion.id}} </a>
		</li>	
	</ul>


	<div ng-hide="hideMovies">
		<table class="table table-striped">
		<tr>
				<td >&nbsp; </td>
				<td ><a href="" ng-click="predicate = 'release_date'; reverse=!reverse">Release date</a></td>
				<td ><a href="" ng-click="predicate = 'name'; reverse=!reverse">Title</a> </td>
				<td >Character </td>
				<td >&nbsp;</td>
		<tr>

		<tr class="movies" ng-repeat="movie in movies.cast | orderBy:predicate:reverse" >
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
