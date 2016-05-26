'use strict';

/* Services */

var listingServices = angular.module('listingServices', ['ngResource']);

listingServices.factory('ListingService', ['$resource',

  function($resource){

    //return $resource('listings/services/listing/:id');

    return $resource('listings/services/listing/:id',null,{
        'GetByStatus': {method: 'GET',isArray: true}
    });

  }
]);
