(function () {
  'use strict';

  /* App Module */
  var listingApp = angular.module('listingApp', [
    'ngRoute',
    'homeControllers',
    'authControllers',
    'listingAnimations',
    'listingControllers',
    'listingFilters',
    'listingServices',
    'authProviderServices',
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
        when('/listings/:id', {
          templateUrl: 'partials/listing-detail.html',
          controller: 'ListingDetailCtrl'
        }).
        when('/login', {
          templateUrl: 'partials/login.html',
          controller: 'AuthCtrl'
        }).
        otherwise({
          redirectTo: '/'
        });
    }]);

  listingApp.run(['$rootScope', '$location', '$log', 'AuthProviderService', 
    function ($rootScope, $location, $log, AuthProviderService) {
      $rootScope.$on('$routeChangeStart', function (event) {
        $log.log(event);

        //AuthProviderService.setUser({'userId':123});

        if (!AuthProviderService.isAuthenticated()) {
          $log.log('DENY : Redirecting to Login');
          $location.path('/login');
        }else {
          $log.log(AuthProviderService.isAuthenticated());
        }
      });
    }]);

})();
