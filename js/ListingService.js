'use strict';

/* Services */

var listingServices = angular.module('listingServices', ['ngResource']);
var statusTypeServices = angular.module('statusTypeServices', ['ngResource']);

listingServices.factory('ListingService', ['$resource',

  function($resource){

    //return $resource('listings/services/listing/:id');

    return $resource('services/listing/:id',null,{
        'GetByStatus': {method: 'GET',isArray: true}
    });

  }
]);

statusTypeServices.factory('StatusTypeService', ['$resource',
  function($resource){
    return $resource('services/statustype/:id',null,{});
  }
]);
