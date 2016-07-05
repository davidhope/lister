'use strict';

/* Controllers */

var listingControllers = angular.module('listingControllers', []);
var homeControllers = angular.module('homeControllers', []);
var uploadControllers = angular.module('uploadControllers',[]);

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
    $scope.listing = ListingService.get({id: $routeParams.listingId}, function(listing) {
      //$scope.mainImageUrl = listing.images[0];
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

uploadControllers.controller('DemoFileUploadController', ['$scope', '$http', '$filter', '$window',
    function ($scope, $http) {

        var isOnGitHub = false, url = 'upload/server/php/';

        $scope.options = {
            url: url
        };

        $scope.loadingFiles = true;

        $http.get(url)
            .then(
                function (response) {
                    $scope.loadingFiles = false;
                    $scope.queue = response.data.files || [];
                },
                function () {
                    $scope.loadingFiles = false;
                }
            );
    }
]);

uploadControllers.controller('FileDestroyController', ['$scope', '$http',
    function ($scope, $http) {
        var file = $scope.file,
            state;
        if (file.url) {
            file.$state = function () {
                return state;
            };
            file.$destroy = function () {
                state = 'pending';
                return $http({
                    url: file.deleteUrl,
                    method: file.deleteType
                }).then(
                    function () {
                        state = 'resolved';
                        $scope.clear(file);
                    },
                    function () {
                        state = 'rejected';
                    }
                );
            };
        } else if (!file.$cancel && !file._index) {
            file.$cancel = function () {
                $scope.clear(file);
            };
        }
    }
]);
