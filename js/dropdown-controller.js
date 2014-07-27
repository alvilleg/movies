var app = angular.module('myApp', []);
app.controller('myController', function($scope,$http) {
  $scope.selectedCountry = null;
  $scope.countries = {};
  $scope.mockSearchFlight = function() {
      $scope.countries= {
        'Zurich': 'Switzerland',
        'Canada': 'Vancouver'
      }
  }
  $scope.searchFlight = function(term) {
     
                    $http({
                            method: 'GET',
                            url: "/query_person.php?q="+term
                        }
                        ).success(function(data) {
                            $scope.countries = data;        
                    });   
  }

  $scope.openModal = function ($movieId) {

    var modalInstance = $modal.open({
      templateUrl: 'myModalContent.html',
      controller: ModalInstanceCtrl,
      size: size,
      resolve: {
        items: function () {
          return $scope.items;
        }
      }
    });



}).directive('keyboardPoster', function($parse, $timeout){
  var DELAY_TIME_BEFORE_POSTING = 0;
  return function(scope, elem, attrs) {
    
    var element = angular.element(elem)[0];
    var currentTimeout = null;
   
    element.oninput = function() {
      var model = $parse(attrs.postFunction);
      var poster = model(scope);
      if(currentTimeout) {
        $timeout.cancel(currentTimeout)
      }
      currentTimeout = $timeout(function(){
        poster(angular.element(element).val());
      }, DELAY_TIME_BEFORE_POSTING)
    }
  }
});
