(function () {
  'use strict';

  /* Services */

  var listingServices = angular.module('listingServices', ['ngResource']);
  var statusTypeServices = angular.module('statusTypeServices', ['ngResource']);
  var authProviderServices = angular.module('authProviderServices', ['ngResource']);
  var processingServices = angular.module('processingServices', ['ngResource']);

  listingServices.factory('ListingService', ['$resource',
    function($resource){
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


  processingServices.factory('ProcessingService', ['$resource',
    function($resource){

      return $resource('services/processing/:id',null,{
        'stepOne': {method: 'POST', params: {step:'1'}},
        'stepTwo': {method: 'POST', params: {step:'2'}},
        'stepThree': {method: 'POST', params: {step:'3'}},
        'stepFour': {method: 'POST', params: {step:'4'}},
        'stepFive': {method: 'POST', params: {step:'5'}},
        'stepSix': {method: 'POST', params: {step:'6'}},
        'stepSeven': {method: 'POST', params: {step:'7'}},
        'stepEight': {method: 'POST', params: {step:'8'}},
        'stepNine': {method: 'POST', params: {step:'9'}},
      });

    }
  ]);

  authProviderServices.factory('AuthProviderService', ['$resource','$log',
    function($resource, $log) {

      return $resource('services/user/:id',null,{
                        'login': {url: 'services/user/login', method: 'POST'},
                        'isAuthenticated': {url: 'services/user/isAuthenticated/token/:token',method: 'GET'},
                        'logout':{url: 'services/user/logout', method: 'GET'}
                      });

  }]);
})();
