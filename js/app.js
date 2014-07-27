/**
  AngularJS controllers 
 **/

var app = angular.module('movieApp', ['siyfion.sfTypeahead','ui.bootstrap']);

// Main controller
app.controller('MainCtrl', 
  function($scope,$http,$log,$modal) {

    $scope.selectedNumber = '';
    $scope.hideProfile=true;
    $scope.hideMovies=true;

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
  
    $scope.initSelectedNumber = function(id_, name_){
      $scope.selectedNumber = {id:id_,name:name_};
      $scope.predicate = 'release_date';
      $scope.reverse = false;
      
      return $scope.showMovies();
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


    $scope.showMovies = function(){

      if(!$scope.selectedNumber.id){
        $scope.showError="Please select one person";
        return;
      }
      $scope.showError="";

      $scope.hideProfile =false;
      $scope.hideMovies =false;  
      $http({
        method: 'GET',
        url: "/query_movies.php?id="+$scope.selectedNumber.id
      }
      ).success(function(data) {
        $scope.movies = data.cast;
        $scope.pageIndexes =[];
      });    
      //
      $http({
                  method: 'GET',
                  url: "/query_person_profile.php?id="+$scope.selectedNumber.id
              }
              ).success(function(data) {
                  $scope.selectedProfile = data;
              
      });                   
    }

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

        modalInstance.result.then(function (id,name) {
          $scope.initSelectedNumber(id,name);
        }, function () {
          $log.info('Modal dismissed at: ' + new Date());
        });    


        return 
      }); 
    }          


    $scope.getMoviesByKeyword = function(page){
      if(!$scope.queryMovies){
        $scope.showError="";
        return;
      }
      $scope.hideMovies=false;
      $scope.hideProfile=true;
      $scope.selectedNumber = '';
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
});

// Please note that $modalInstance represents a modal window (instance) dependency.
// It is not the same as the $modal service used above.

var ModalInstanceCtrl = function ($scope, $modalInstance, items) {
  $scope.items = items;  
  $scope.ok = function () {
    $modalInstance.dismiss();
  };

  $scope.close = function (id,name) {
    $modalInstance.close(id,name);
  };

  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
};
