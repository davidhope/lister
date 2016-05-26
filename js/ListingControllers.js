'use strict';

/* Controllers */

var listingControllers = angular.module('listingControllers', []);
var homeControllers = angular.module('homeControllers', []);


homeControllers.controller('HomeCtrl', ['$scope',
  function($scope) {}
]);

listingControllers.controller('ListingCtrl', ['$scope', '$log', '$routeParams', 'ListingService',
  function($scope, ListingService) {
    $scope.listings = ListingService.query();
    $scope.orderProp = 'address';

    $scope.getByStatus = function(){
      $scope.listings = ListingService.getByStatus({status:$routeParams.status});
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
      $scope.listing.price += 100.00;
    };

    $scope.decreasePrice = function() {
      $log.log($scope.listing.price);
      $scope.listing.price -= 100.00;
    };

  }]);
