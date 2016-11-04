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

  authProviderServices.factory('AuthProviderService', ['$resource', 
    function($resource) {

      // var user;
      // return {
      //   setUser : function(aUser){
      //     user = aUser;
      //     return user;
      //   },
      //   isAuthenticated : function(){
      //     return(user) ? user : false;
      //   }
      // };

      var isAuthenticated = function(token){
        return $resource('services/user/isAuthenticated/' + token);
      }

      var api = function(){
        return $resource('services/user/:id',null,{
                          'login': {method: 'POST'},
                          'isAuthenticated': {method: 'GET'},
                          'logout':{method: 'post'}
                        });
      }
  }]);
})();
