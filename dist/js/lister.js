

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    /* this will only need to be called when charts are on the loaded*/
    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    var element = $('ul.nav a').filter(function() {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }
});

(function () {
  'use strict';

  /* App Module */
  var listingApp = angular.module('listingApp', [
    'ngRoute',
    'homeControllers',
    'listingAnimations',
    'listingControllers',
    'listingFilters',
    'listingServices',
    'statusTypeServices'
  ]);

  listingApp.config(['$routeProvider',
    function($routeProvider) {
      $routeProvider.
        when('/', {
          templateUrl: 'partials/index.html',
          controller: 'HomeCtrl'
        }).
        when('/listings', {
          templateUrl: 'partials/listings.html',
          controller: 'ListingCtrl'
        }).
        // :mls comes from url and sends to the ListingDetailCtrl in $routeParams
        when('/listings/:listingId', {
          templateUrl: 'partials/listing-detail.html',
          controller: 'ListingDetailCtrl'
        }).
        otherwise({
          redirectTo: '/'
        });
  }]);
})();

(function () {
  'use strict';

  /* Controllers */

  var listingControllers = angular.module('listingControllers', []);
  var homeControllers = angular.module('homeControllers', []);

  homeControllers.controller('HomeCtrl', ['$scope',
    function($scope) {}
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
      }
  }]);

  listingControllers.controller('ListingDetailCtrl', ['$scope', '$log', '$routeParams', 'ListingService','StatusTypeService',
    function($scope, $log, $routeParams, ListingService, StatusTypeService) {

      $scope.statusTypes = StatusTypeService.query();

      //$routeParams.mls comes from app.js route for ListingDetailCtrl
      $scope.listing = ListingService.get({id: $routeParams.listingId}, function(listing) {
        //$scope.mainImageUrl = listing.images[0];
        //$scope.currentPrice = Math.max.apply(Math,$scope.listing.listingprice.map(function(lp){return lp;}));
        $scope.currentPrice = $scope.listing.listingprice.reduce(function(prev, current) {
                                  return (prev.listingPriceId > current.listingPriceId) ? prev : current
                              })

        $scope.currentStatus = $scope.listing.listingstatus.reduce(function(prev, current) {
                                  return (prev.listingStatusId > current.listingStatusId) ? prev : current
                              })

        $log.log($scope.currentPrice);
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
})();

(function () {
  'use strict';

  /* Services */

  var listingServices = angular.module('listingServices', ['ngResource']);
  var statusTypeServices = angular.module('statusTypeServices', ['ngResource']);

  listingServices.factory('ListingService', ['$resource',

    function($resource){

      //return $resource('listings/services/listing/:id');

      return $resource('services/listing/:id',null,{
          'GetByStatus': {method: 'GET',isArray: true}
      });

    }
  ]);

  statusTypeServices.factory('StatusTypeService', ['$resource',
    function($resource){
      return $resource('services/statustype/:id',null,{});
    }
  ]);
})();

(function () {
  var listingAnimations = angular.module('listingAnimations', ['ngAnimate']);

  listingAnimations.animation('.listing', function() {

    var animateUp = function(element, className, done) {
      if(className != 'active') {
        return;
      }
      element.css({
        position: 'absolute',
        top: 500,
        left: 0,
        display: 'block'
      });

      jQuery(element).animate({
        top: 0
      }, done);

      return function(cancel) {
        if(cancel) {
          element.stop();
        }
      };
    }

    var animateDown = function(element, className, done) {
      if(className != 'active') {
        return;
      }
      element.css({
        position: 'absolute',
        left: 0,
        top: 0
      });

      jQuery(element).animate({
        top: -500
      }, done);

      return function(cancel) {
        if(cancel) {
          element.stop();
        }
      };
    }

    return {
      addClass: animateUp,
      removeClass: animateDown
    };
  });
})();

(function () {
  'use strict';

  /* Directives */

})();

(function () {
  'use strict';

  /* Filters */
  angular.module('listingFilters', []).filter('checkmark', function() {
    return function(input) {
      return input ? '\u2713' : '\u2718';
    };
  });
})();
