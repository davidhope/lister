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
      // :mls comes from url and sends to the ListingDetailCtrl in $routeParams
      when('/listings/:mls', {
        templateUrl: 'partials/listing-detail.html',
        controller: 'ListingDetailCtrl'
      }).
      otherwise({
        redirectTo: '/listings'
      });
  }]);
