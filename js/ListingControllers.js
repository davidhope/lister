(function () {
  'use strict';

  /* Controllers */

  var listingControllers = angular.module('listingControllers', []);
  var homeControllers = angular.module('homeControllers', []);

  homeControllers.controller('HomeCtrl', ['$scope',
    //function($scope) {}
  ]);

  listingControllers.controller('ListingCtrl', ['$scope', '$log', '$routeParams', 'ListingService','StatusTypeService',
    function($scope, $log, $routeParams, ListingService, StatusTypeService) {

      $scope.listings = ListingService.query();
      $scope.orderProp = 'address';
      $scope.statusFilter = '';
      $scope.statusTypes = StatusTypeService.query();

      $scope.getByStatus = function(){
        $log.log($scope.statusFilter);
        //$scope.listings = ListingService.GetByStatus({status:$scope.statusFilter});
      };

    }
  ]);

  listingControllers.controller('ListingDetailCtrl', ['$scope', '$log', '$routeParams', '$location', 'ListingService','StatusTypeService',
    function($scope, $log, $routeParams, ListingService, StatusTypeService) {

      $scope.statusTypes = StatusTypeService.query();

      //$routeParams.mls comes from app.js route for ListingDetailCtrl
      $scope.listing = ListingService.get({id: $routeParams.listingId}, function(listing) {
        console.log('here');
        //$scope.mainImageUrl = listing.images[0];
        /*
        $scope.currentPrice = Math.max.apply(Math,$scope.listing.listingprice.map(function(lp){return lp;}));
        $scope.currentPrice = $scope.listing.listingprice.reduce(
          function(prev, current) {
            return (prev.listingPriceId > current.listingPriceId) ? prev : current;
          });

        $scope.currentStatus = $scope.listing.listingstatus.reduce(
          function(prev, current) {
            return (prev.listingStatusId > current.listingStatusId) ? prev : current;
          });

        $log.log($scope.currentPrice);
        */
      });

      $scope.cancel = function(){
        //console.log();
        $location.url('/');
      };

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
})();
