'use strict';

/* App Module */

var listingApp = angular.module('listingApp', [
  'ngRoute',
  'homeControllers',
  'listingAnimations',
  'listingControllers',
  'listingFilters',
  'listingServices'
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
