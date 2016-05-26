'use strict';

/* Services */

var listingServices = angular.module('listingServices', ['ngResource']);

listingServices.factory('ListingService', ['$resource',
  function($resource){

    var ListingService = {};

    return $resource('listings/services/listing/:id',{},{
      {
        GetByStatus: {
          method: 'GET',
          params: {status: },
          isArray: true
        }
    });

  }
]);
