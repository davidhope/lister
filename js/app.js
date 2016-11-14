(function () {
  'use strict';

  /* App Module */
  var listingApp = angular.module('listingApp', [
    'ngRoute',
    'ngStorage',
    'navControllers',
    'homeControllers',
    'processingControllers',
    'authControllers',
    'listingAnimations',
    'listingControllers',
    'listingFilters',
    'listingServices',
    'authProviderServices',
    'processingServices',
    'statusTypeServices'
  ]);

  

  listingApp.config(['$routeProvider',
    function($routeProvider) {
      $routeProvider.
        when('/', {
          // templateUrl: 'partials/index.html',
          // controller: 'HomeCtrl'
          templateUrl: 'partials/listings.html',
          controller: 'ListingCtrl'
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
        when('/processing', {
          templateUrl: 'partials/processing.html',
          controller: 'ProcessingCtrl'
        }).
        otherwise({
          redirectTo: '/'
        });
    }]);

  listingApp.run(['$rootScope','$location','$log','$sessionStorage','AuthProviderService', 
    function ($rootScope, $location, $log, $sessionStorage, AuthProviderService) {
      $rootScope.$storage = $sessionStorage; 

      $rootScope.$on('$routeChangeStart', function (event) {
        if (!$rootScope.$storage.user || !AuthProviderService.isAuthenticated({token:$rootScope.$storage.user.token})) {
          $log.log('DENY : Redirecting to Login');
          $location.path('/login');
        }
      });
    }]);

})();
