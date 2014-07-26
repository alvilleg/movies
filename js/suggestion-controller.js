var app = angular.module("moviesApp",['ui.bootstrap']);
    app.controller("SuggestionController",
        function ($scope,$http) {
             $scope.getSuggestions = function(){
                    $scope.hideSuggestions=false;
                    $http({
                            method: 'GET',
                            url: "/query_person.php?q="+$scope.query
                        }
                        ).success(function(data) {
                            $scope.suggestions = data;        
                    });                         
                    $scope.suggestionStyle = "size=20;left: 40px;top: 40px;visibility: visible;position: absolute;overflow: visible;background-color:#fff;background-size:auto;"    
                }

            $scope.showMovies = function(id){
                $scope.hideSuggestions=true;
                $http({
                            method: 'GET',
                            url: "/query_movies.php?id="+id
                        }
                        ).success(function(data) {
                            $scope.movies = data;
                        
                });                       
            }    

            $scope.status = {
    isopen: false
  };

  $scope.toggled = function(open) {
    console.log('Dropdown is now: ', open);
  };

  $scope.toggleDropdown = function($event) {
    $event.preventDefault();
    $event.stopPropagation();
    $scope.status.isopen = !$scope.status.isopen;
  };


 $scope.items = [
    'The first choice!',
    'And another choice for you.',
    'but wait! A third!'
  ];


        }
    );