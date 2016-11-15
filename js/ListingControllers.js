(function () {
  'use strict';

  /* Controllers */

  var listingControllers = angular.module('listingControllers', []);
  var homeControllers = angular.module('homeControllers', []);
  var authControllers = angular.module('authControllers',[]);
  var navControllers = angular.module('navControllers',[]);
  var salesListControllers = angular.module('salesListControllers',[]);
  var processingControllers = angular.module('processingControllers',[]);

  navControllers.controller('NavCtrl', ['$rootScope','$log','$location','$sessionStorage','AuthProviderService',
    
    function($rootScope, $log, $location, $sessionStorage, AuthProviderService){

      var init = function(){
        $rootScope.$storage = $sessionStorage; 
      }

      $rootScope.logout = function(){
        $log.log('nav ctrl logging out');
        $rootScope.$storage.$reset();
        $location.path('/login');
        AuthProviderService.logout();
      }

    }
  ]);

  homeControllers.controller('HomeCtrl', ['$scope','$log',
    function($scope, $log) {
      // $log.log('Home Controller');
    }
  ]);

  salesListControllers.controller('SalesListCtrl', ['$scope','$log',
    function($scope, $log) {
      // $log.log('Home Controller');
    }
  ]);

  processingControllers.controller('ProcessingCtrl', ['$scope','$log', 'ProcessingService',
    function($scope, $log, ProcessingService) {
      $log.log('Processing Controller');

      var init = function(){
        $scope.step1 = false;
        $scope.step2 = false;
        $scope.step3 = false;
        $scope.step4 = false;
        $scope.step5 = false;
        $scope.step6 = false;
        $scope.step7 = false;
        $scope.step8 = false;
        $scope.step9 = false;
      }
        
      $scope.beginProcessing = function(){
        $log.log('Processing Started');

        $scope.step1 = ProcessingService.step1();
        $log.log('step1 Started');
        $scope.apply();
        $scope.step2 = ProcessingService.step2();
        $log.log('step2 Started');
        $scope.apply();
        $scope.step3 = ProcessingService.step3();
        $log.log('step3 Started');
        $scope.apply();
        $scope.step4 = ProcessingService.step4();
        $log.log('step4 Started');
        $scope.apply();
        $scope.step5 = ProcessingService.step5();
        $log.log('step5 Started');
        $scope.apply();
        $scope.step6 = ProcessingService.step6();
        $log.log('step6 Started');
        $scope.apply();
        $scope.step7 = ProcessingService.step7();
        $log.log('step7 Started');
        $scope.apply();
        $scope.step8 = ProcessingService.step8();
        $log.log('step8 Started');
        $scope.apply();
        $scope.step9 = ProcessingService.step9();
        $log.log('step9 Started');
        $scope.apply();


        $log.log('Processing complete');
      };

      init();
    }
  ]);

  authControllers.controller('AuthCtrl', ['$rootScope','$scope','$log','$location','$localStorage','$sessionStorage','AuthProviderService',
    function($rootScope, $scope, $log, $location, $localStorage, $sessionStorage, AuthProviderService){
      //$log.log('authcontroller');
      //$rootScope.$storage = $sessionStorage; 
       
      var init = function(){
        $scope.failedAttempt = false;

        if($rootScope.$storage.user == null){
          $scope.email = '';
          $scope.password = '';
        }
      }
        
      $scope.login = function(){
        $log.log('authcontroller logging in: ' + $scope.email + ' - '  + $scope.password);
        $rootScope.$storage.user = AuthProviderService.login({email: $scope.email, password: $scope.password}, successCb, errorCb);

        function successCb(data){
          $log.log('success: ' + data);
          $location.path('/');
        }

        function errorCb(data){
          $log.warn('error: ' + data);
          $scope.failedAttempt = true;
        }
      };

      init();
    }
  ]);

  listingControllers.controller('ListingCtrl', ['$scope', '$log', '$routeParams', 'ListingService','StatusTypeService',
    function($scope, $log, $routeParams, ListingService, StatusTypeService) {
      $scope.loaded = false;

      $log.log('query started');
      $scope.listings = ListingService.query(function(data){
        $scope.loaded = true;
        $log.log('query complete');
      });

      $scope.orderProp = 'address';
      $scope.statusFilter = '';

      $scope.statusTypes = StatusTypeService.query();

      $scope.getByStatus = function(){
        //$log.log($scope.statusFilter);
        $scope.listings = ListingService.GetByStatus({status:$scope.statusFilter});
      };

    }
  ]);

  listingControllers.controller('ListingDetailCtrl', ['$scope', '$log', '$routeParams', '$location', 'ListingService','StatusTypeService',
    function($scope, $log, $routeParams, $location, ListingService, StatusTypeService) {

      $scope.statusTypes = StatusTypeService.query();

      //console.log($routeParams.id);
      //$routeParams.mls comes from app.js route for ListingDetailCtrl

      $scope.listing = ListingService.get({id: $routeParams.id}, function(listing) {
        $scope.toggleMessage = false;
        //$scope.mainImageUrl = listing.images[0];
        /*
        $scope.currentPrice = Math.max.apply(Math,$scope.listing.listingprice.map(function(lp){return lp;}));
        $scope.currentPrice = $scope.listing.listingprice.reduce(
          function(prev, current) {
            return (prev.listingPriceId > current.listingPriceId) ? prev : current;
          });

        $scope.currentStatus = $scope.listing.listingstatus.reduce(
          function(prev, current) {
            return (prev.listingStatusId > current.listingStatusId) ? prev : current;
          });

        $log.log($scope.currentPrice);
        */
        
      });

      $scope.cancel = function(){
        //console.log();
        //$window.location.href = '/';
        $location.path('/listings');
      };

      $scope.save = function(listing){
        $log.log(listing);
        $scope.listing.$save(function(data){
                              $scope.toggleMessage = true;
                              $scope.message = 'Saved Successfully';
                              $scope.messageClass = 'fade-in alert alert-success';
                            },
                            function(err){
                              $scope.toggleMessage = true;
                              $scope.message = err.data;
                              $scope.messageClass = 'fade-in alert alert-danger';
                            });
      };

      $scope.delete = function(listing){
        $log.log(listing);
        //$scope.listing.$delete();
      };

      $scope.setImage = function(imageUrl) {
        $scope.mainImageUrl = imageUrl;
      };

      $scope.increasePrice = function() {
        $log.log($scope.listing.price);
        var _price = parseInt($scope.listing.price);
        _price += 100.00;
        $scope.listing.price = _price;
      };

      $scope.decreasePrice = function() {
        $log.log($scope.listing.price);
        var _price = parseInt($scope.listing.price);
        _price -= 100.00;
        $scope.listing.price = _price;
      };

    }]);
})();
