<!--
    Main page for movie search
-->    


<!DOCTYPE html>
<html ng-app="movieApp">

  <head>
    <meta charset="utf-8" />
    <title>AngularJS Plunker</title>
    <link rel="stylesheet" href="./css/style.css">

    <link href="./css/bootstrap.min.css" rel="stylesheet" />

    <script>document.write('<base href="' + document.location + '" />');</script>
    <script src="./js/jquery-1.9.1.js"></script>
    <script  src="./js/angular.js"></script>

    <script src="./js/ui-bootstrap-tpls.min.js"></script>

    <script  src="./js/typeahead.bundle.min.js"></script>
    <script  src="./js/bloodhound.min.js"></script>
    <script src="./js/angular-typeahead.js"></script>
    <script src="./js/app.js"></script>


    <style>
        
        div#profile{
        }

        div#profile table tr td span{
            font-weight: bold;
        }

        .header .brand img {
            margin-top:5px;
            height: 30px;
        }    

        span.error{
            color: #a94442;
        }
    </style>

  </head>

  <body ng-controller="MainCtrl">
    <section role="main" class="container main-body">
    <!-- Header -->    
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
    <!-- -->
    <?php
        $id = $_GET["id"];
        $name = $_GET["name"];
        if($id){
            echo '<span ng-init="initSelectedNumber('.$id.',\''.$name.'\') ">';
        }
    ?>
    <!-- -->
    <script type="text/ng-template" id="myModalContent.html">
        <div class="modal-header">
            <h3 class="modal-title">{{items.title}}</h3>
        </div>
        <div class="modal-body">
            <img ng-if="items.poster_path" src="http://image.tmdb.org/t/p/w92{{items.poster_path}}" />
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
           <br/>
           <br/>
           <b>Cast:</b> 
           <span ng-repeat="cast in items.credits.cast"><a href="#" ng-click="close(cast.id,cast.name)">{{cast.name}}</a><span ng-show=" !$last">, 
           </span>
           </span> 


            <br/>
           <br/>
           <b>Crew:</b> 
           <span ng-repeat="c in items.credits.crew">{{c.job}}: <a href="#" ng-click="close(c.id,c.name)">{{c.name}}</a><span ng-show=" !$last">, 
           </span>
           </span>
           

        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" ng-click="ok()">OK</button>
        </div>
    </script>

    <h1>Movie search</h1>
    <!-- -->
    <table style="width:100%;padding-bottom:3em;">
        <tr>
            <td>
                <label>By person </label>
            </td>
            <td>   
                <input class='typeahead' type="text" sf-typeahead options="exampleOptions" 
                datasets="numbersDataset" ng-model="selectedNumber" ng-keyup="$event.keyCode == 13? showMovies() : null ">
                 <span class="error" >{{showError}}</span>
            </td>
        </tr>
        <tr>
            <td style="padding-top:1em;">
                <label>By keyword</label>
            </td>
            <td >    
                    <input class='typeahead' autocomplete="off" ng-init="c=0;" name="qm" ng-model="queryMovies" 
                           ng-keyup="$event.keyCode==13? getMoviesByKeyword(1): null" placeholder="Enter a key word for search movies"/>
                    <br/>


            </td>
        </tr>
        <tr>    
            <td colspan="2">
                <span>Press Enter to execute the search </span>
            </td>
        </tr>
    </table>
    <br>
    <br>
    <div ng-init="predicate = 'release_date';" ng-hide="hideMovies" >
        <div ng-if="selectedProfile" ng-hide="hideProfile" id="profile">
            <table>
                <tr><td style="width:20em;">
            <img ng-if="selectedProfile.profile_path" src="http://image.tmdb.org/t/p/w92{{selectedProfile.profile_path}}" />
            <br>
            <h3> {{selectedProfile.name}}</h3>
            
            {{selectedProfile.place_of_birth}}
            <br>
            {{selectedProfile.birthday}}
            <br>
            </td>
            <td>
                {{selectedProfile.biography}}
            </td>
            </table>    
        </div>

        <h2>Movies </h2>
        
        <ul ng-if="!selectedProfile.id" class="pagination">
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
                <td ><img ng-click="getMovieDetails(movie.id);" ng-if="movie.poster_path" src="http://image.tmdb.org/t/p/w92{{movie.poster_path}}" /> </td>
                <td ><a ng-click="getMovieDetails(movie.id);" href="#{{movie.id}}">{{movie.title}}&nbsp;{{count}}</a> 

                </td>
                <td ng-if="!hideProfile">{{movie.character}}</td>
                <td >{{movie.release_date}} &nbsp;</td>
            </tr>
        </table>
    </div>  


    </section>

  </body>

</html>