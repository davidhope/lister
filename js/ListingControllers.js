'use strict';

/* Controllers */

var listingControllers = angular.module('listingControllers', []);
var homeControllers = angular.module('homeControllers', []);


homeControllers.controller('HomeCtrl', ['$scope',
  function($scope) {}
]);

listingControllers.controller('ListingCtrl', ['$scope', '$log', '$routeParams', 'ListingService',
  function($scope, $log, $routeParams, ListingService) {

    $scope.listings = ListingService.query();
    $scope.orderProp = 'address';
    $scope.statusFilter = '';

    $scope.getByStatus = function(){
      $log.log($scope.statusFilter);
      $scope.listings = ListingService.GetByStatus({status:$scope.statusFilter});
    }
}]);

listingControllers.controller('ListingDetailCtrl', ['$scope', '$log', '$routeParams', 'ListingService',
  function($scope, $log, $routeParams, ListingService) {

    $scope.statuses = ['For Sale', 'Sold', 'Cancelled', 'Pending', 'Rented', 'Withdrawn'];

    //$routeParams.mls comes from app.js route for ListingDetailCtrl
    $scope.listing = ListingService.get({mls: $routeParams.mls}, function(listing) {
      $scope.mainImageUrl = listing.images[0];
    });


    $scope.save = function(listing){
      $log.log(listing);
      $scope.listing.$save();
    };

    $scope.delete = function(listing){
      $log.log(listing);
      $scope.listing.$delete();
    };

    $scope.setImage = function(imageUrl) {
      $scope.mainImageUrl = imageUrl;
    };

    $scope.increasePrice = function() {
      $log.log($scope.listing.price);
      var _price = parseInt($scope.listing.price);
      _price += 100.00;
      $scope.listing.price = _price;
    };

    $scope.decreasePrice = function() {
      $log.log($scope.listing.price);
      var _price = parseInt($scope.listing.price);
      _price -= 100.00;
      $scope.listing.price = _price;
    };

  }]);
