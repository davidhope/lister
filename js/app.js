'use strict';

/* App Module */

var listingApp = angular.module('listingApp', [
  'ngRoute',
  'listingAnimations',
  'listingControllers',
  'listingFilters',
  'listingServices'
]);

listingApp.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/listings', {
        templateUrl: 'partials/listings.html',
        controller: 'ListingCtrl'
      }).
      when('/listings/:mls', {
        templateUrl: 'partials/listing-detail.html',
        controller: 'ListingDetailCtrl'
      }).
      otherwise({
        redirectTo: '/listings'
      });
  }]);
