(function () {
  'use strict';

  /* App Module */
  var listingApp = angular.module('listingApp', [
    'ngRoute',
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
        when('/processing', {
          templateUrl: 'partials/processing.html',
          controller: 'ProcessingCtrl'
        }).
        otherwise({
          redirectTo: '/'
        });
    }]);

  listingApp.run(['$rootScope', '$location', '$log', 'AuthProviderService', 
    function ($rootScope, $location, $log, AuthProviderService) {

      // $rootScope.login = function(user){
      //   $log.log('logging in');
      //   AuthProviderService.setUser({'userId':123});

      //   //$rootScope.user = AuthProviderService.get({email: $rootScope.user.email, password: }
      //   $location.path('/');
      // };

      // $rootScope.logout = function(){
      //   $log.log('logging out');
      //   AuthProviderService.setUser(null);
      //   $rootScope.user = null;
      //   $location.path('/login');
      // }

      $rootScope.$on('$routeChangeStart', function (event) {
        $log.log($rootScope.user);

        //AuthProviderService.setUser({'userId':123});

        if (!AuthProviderService.isAuthenticated($rootScope.user.token)) {
          $log.log('DENY : Redirecting to Login');
          $location.path('/login');
        }else {
          //$log.log(AuthProviderService.isAuthenticated());
        }
      });
    }]);

})();
