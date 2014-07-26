var app = angular.module("moviesApp",['ui.bootstrap']);
    app.controller("SuggestionController",
        function ($scope,$http) {

             $scope.hideMovies=true;
             $scope.hideProfile=true;
                
             $scope.getSuggestions = function(){
                    $scope.hideSuggestions=false;
                    $scope.hideMovies=true;

                    $http({
                            method: 'GET',
                            url: "/query_person.php?q="+$scope.query
                        }
                        ).success(function(data) {
                            $scope.suggestions = data;        
                    });
                    //
                    $scope.suggestionStyle = "size=20;left: 40px;top: 40px;visibility: visible;position: absolute;overflow: visible;background-color:#fff;background-size:auto;"    
                }

            
            $scope.getMoviesByKeyword = function(page){
                    $scope.hideMovies=false;
                    $scope.hideProfile=true;
                    $scope.selectedProfile = {};
                    $http({
                            method: 'GET',
                            url: "/query.php?q="+$scope.queryMovies+"&page="+page
                        }
                        ).success(function(data) {
                             console.log(data);   
                            $scope.movies = data.results;  
                            console.log($scope.movies);   
                            $scope.page=data.page;
                            $scope.totalPages=data.total_pages;  
                            var pageIndexes =[];
                            $scope.pageIndexes = pageIndexes;
                            var start= data.page>5?data.page-5 : 1;
                            var end=start+10;
                            if(end>data.total_pages){
                                end=data.total_pages;
                            }
                            for(var i=start;i<=end;i++){
                                pageIndexes.push(i);    
                            } 
                    });                    
                    //       
                }            

            $scope.showMovies = function(profile){
                $scope.hideSuggestions=true;
                $scope.hideMovies=false;
                $scope.hideProfile=false;
                $scope.selectedProfile = profile;
                $http({
                            method: 'GET',
                            url: "/query_movies.php?id="+profile.id
                        }
                        ).success(function(data) {
                            $scope.movies = data.cast;
                        
                });    
                //
                $http({
                            method: 'GET',
                            url: "/query_person_profile.php?id="+profile.id
                        }
                        ).success(function(data) {
                            $scope.personProfile = data;
                        
                });                   
            }    
        }
    );