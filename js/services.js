'use strict';

/* Services */

var listingServices = angular.module('listingServices', ['ngResource']);

listingServices.factory('Listing', ['$resource',
  function($resource){
    return $resource('listings/:listingId.json', {}, {
      query: {method:'GET', params:{listingId:'listings'}, isArray:true}
    });
  }]);
