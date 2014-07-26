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
                    $scope.suggestionStyle = "left: 50px;top: 50px;visibility: visible;position: absolute;overflow: visible;background-color:#fff;background-size:auto;"    
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
        }
    );