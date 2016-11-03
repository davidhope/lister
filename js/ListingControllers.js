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

  listingControllers.controller('ListingDetailCtrl', ['$scope', '$log', '$routeParams', '$window', 'ListingService','StatusTypeService',
    function($scope, $log, $routeParams, $window, ListingService, StatusTypeService) {

      $scope.statusTypes = StatusTypeService.query();

      //console.log($routeParams.id);
      //$routeParams.mls comes from app.js route for ListingDetailCtrl
<<<<<<< HEAD
      $scope.listing = ListingService.get({id: $routeParams.listingId}, function(listing) {

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
        
>>>>>>> c4d655630c291241778a7b0c79b6b46527a4a9a4
      });

      $scope.cancel = function(){
        //console.log();
        $window.location.href = '/';
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
