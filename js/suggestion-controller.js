var app = angular.module("moviesApp",['ui.bootstrap']);
    app.controller("SuggestionController",
        function ($scope,$http,$modal,$log) {

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


            $scope.items = ['item1', 'item2', 'item3'];
            
            $scope.getMovieDetails = function (movieId,size) {
                      $http({
                            method: 'GET',
                            url: "/query_movie_details.php?id="+movieId
                        }
                        ).success(function(data) {

                            $scope.movieDetails = data;
                            $log.info('Details: '+data);

                            var modalInstance = $modal.open({
                              templateUrl: 'myModalContent.html',
                              controller: ModalInstanceCtrl,
                              size: size,
                              resolve: {
                                items: function () {
                                    return data;
                                }                   
                              }
                            });
                            $log.info('open');

                            modalInstance.result.then(function (selectedItem) {
                              $scope.selected = selectedItem;
                            }, function () {
                              $log.info('Modal dismissed at: ' + new Date());
                            });    


                            return 
                        }); 
                    }



               $scope.selectedNumber = 'X';
  
  // instantiate the bloodhound suggestion engine
  var numbers = new Bloodhound({
    datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.num); },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    local:[{num:"alde",name:"alde"}]
    /*remote: {
        url: '/query_person.php?qa=y',
        replace: function(url, uriEncodedQuery) {
          var newUrl = url + '&q=' + uriEncodedQuery;
          return newUrl;
        },
        filter: function (movies) {
            return $.map(movies.results, function (movie) {
                return movie;
            });
        }
    }*/
  });
   
  // initialize the bloodhound suggestion engine
  numbers.initialize();
  
  $scope.numbers=numbers;

  $scope.numbersDataset = {
    displayKey: 'name',
    source: numbers.ttAdapter()
  };
  
  $scope.addValue = function () {
    numbers.add({
      num: 'twenty'
    });
  };
  
  $scope.setValue = function () {
    $scope.selectedNumber = { num: 'seven' };
  };
  
  $scope.clearValue = function () {
    $scope.selectedNumber = null;
  };

        }
    );




// Please note that $modalInstance represents a modal window (instance) dependency.
// It is not the same as the $modal service used above.

var ModalInstanceCtrl = function ($scope, $modalInstance, items) {

  $scope.items = items;  

  $scope.ok = function () {
     console.log("ok 2");
    $modalInstance.close();
  };

  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
};




app.controller('MainCtrl', function($scope) {
  
  $scope.selectedNumber = 'X';
  
  // instantiate the bloodhound suggestion engine
  var numbers = new Bloodhound({
    datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.num); },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
        url: '/query_person.php?qa=y',
        replace: function(url, uriEncodedQuery) {
          var newUrl = url + '&q=' + uriEncodedQuery;
          return newUrl;
        },
        filter: function (movies) {
            return $.map(movies.results, function (movie) {
                return movie;
            });
        }
    }
  });
   
  // initialize the bloodhound suggestion engine
  numbers.initialize();
  
  $scope.numbers=numbers;

  $scope.numbersDataset = {
    displayKey: 'name',
    source: numbers.ttAdapter()
  };
  
  $scope.addValue = function () {
    numbers.add({
      num: 'twenty'
    });
  };
  
  $scope.setValue = function () {
    $scope.selectedNumber = { num: 'seven' };
  };
  
  $scope.clearValue = function () {
    $scope.selectedNumber = null;
  };
  
  // Typeahead options object
  $scope.exampleOptions = {
    highlight: true
  };
  
  $scope.exampleOptionsNonEditable = {
    highlight: true,
    editable: false // the new feature
  };
  
});

