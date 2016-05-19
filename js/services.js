'use strict';

/* Services */

var listingServices = angular.module('listingServices', ['ngResource']);

listingServices.factory('ListingService', ['$resource',
  function($resource){
    return $resource('listings/:mls.json', {}, {
      query: {method:'GET', params:{mls:'listings'}, isArray:true},
      save: {},
      delete{}
    });
  }]);
