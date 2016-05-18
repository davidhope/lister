'use strict';

/* Controllers */

var listingControllers = angular.module('listingControllers', []);

listingControllers.controller('ListingCtrl', ['$scope', 'Listing',
  function($scope, Listing) {
    $scope.listings = Listing.query();
    $scope.orderProp = 'address';
  }]);

listingControllers.controller('ListingDetailCtrl', ['$scope', '$routeParams', 'Listing',
  function($scope, $routeParams, Phone) {
    $scope.listing = Listing.get({listingId: $routeParams.listingId}, function(phone) {
      //$scope.mainImageUrl = listing.images[0];
    });

    $scope.setImage = function(imageUrl) {
      //$scope.mainImageUrl = imageUrl;
    };
  }]);
