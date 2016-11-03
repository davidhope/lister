(function () {
  'use strict';

  /* Services */

  var listingServices = angular.module('listingServices', ['ngResource']);
  var statusTypeServices = angular.module('statusTypeServices', ['ngResource']);
  var authProviderServices = angular.module('authProviderServices', ['ngResource']);
  
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

  authProviderServices.factory('AuthProviderService', ['$resource', 
    function($resource) {
      var user;
      return {
        setUser : function(aUser){
          user = aUser;
        },
        isLoggedIn : function(){
          return(user) ? user : false;
        }
      };
  }]);
})();
