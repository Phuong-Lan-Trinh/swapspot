'use strict';
/* ==========================================================================
   BOOTSTRAPPER (notice the cascading dependencies, AngularJS uses the order you defined to configure the injector!)
   ========================================================================== */
 
//app is an module that is dependent on several top level modules
var app = angular.module('App', [
	'Controllers',
	'Filters',
	'Services',
	'Directives',
	'ngResource', //for RESTful resources
	'ngCookies',// for cookies manipulation
]);

//Define all the page level controllers (Application Logic)
angular.module('Controllers', []);
//Define all shared filters (UI Filtering)
angular.module('Filters', []);
//Define all shared services (Interaction with Backend)
angular.module('Services', []);
//Define all shared directives (UI Logic)
angular.module('Directives', []);

/* ==========================================================================
ROUTER
========================================================================== */

//Define all routes here and which page level controller should handle them
	
app.config(
	[
		'$routeProvider',
		'$locationProvider',
		function($routeProvider,$locationProvider){
		
			//HTML5 Mode URLs
			$locationProvider.html5Mode(true).hashPrefix('!');
			//time for routing
			$routeProvider
				.when(
					'/',
					{
						templateUrl: 'home_index.html',
						controller: 'HomeIndexCtrl'
					}
				)
				.otherwise(
					{
						redirectTo: '/'
					}
					
				);
		}
	
	]);
	
//GLOBAL FEATURES
app.run([
	'$rootScope',
	'$cookies',
	'$http',
	function($rootScope, $cookies, $http){

		//XSRF INTEGRATION
		$rootScope
			.$watch(
				function(){
					return $cookies[serverVars.csrfCookieName]; // if this function see any differences from the second iteration to the previous one it will tell the browser to change
				},
				function(){
					$http.defaults.headers.common['X-XSRF-TOKEN'] = $cookies[serverVars.csrfCookieName]; 
				}
			);	
	}
]);
	
