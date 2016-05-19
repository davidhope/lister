'use strict';

/* Controllers */

var listingControllers = angular.module('listingControllers', []);

listingControllers.controller('ListingCtrl', ['$scope', 'ListingService',
  function($scope, ListingService) {
    $scope.listings = ListingService.query();
    $scope.orderProp = 'address';
  }]);

listingControllers.controller('ListingDetailCtrl', ['$scope', '$routeParams', 'ListingService',
  function($scope, $routeParams, ListingService) {
    //$routeParams.mls comes from app.js route for ListingDetailCtrl
    $scope.listing = ListingService.get({mls: $routeParams.mls}, function(listing) {
      $scope.mainImageUrl = listing.images[0];
    });

    $scope.setImage = function(imageUrl) {
      $scope.mainImageUrl = imageUrl;
    };

    $scope.increasePrice = function() {
      console.log($scope.listing.price);
      $scope.listing.price += 100.00;
    };

    $scope.decreasePrice = function() {
      console.log($scope.price);
      $scope.listing.price -= 100.00;
    };
  }]);
