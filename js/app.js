'use strict';

var app=angular.module('App', [
	'Controllers'
	
]);
angular.module('Controllers', [
	'Dummy.Controllers',
	'Home.Controllers',
	'ngCookies',
	'ngResource',// for RESTful resources
]);
	
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
				.when(
					'/dummy',
					{
						templateUrl: 'dummy_index.html',
						controller: 'DummyIndexCtrl'
					}
				)
				.otherwise(
					{
						redirectTo: '/'
					}
					
				)
		}
	
	]);
	
	//GLOBAL FEATURES
	app.run([
		'$rootScope',
		'$cookies',
		'$http',
		function($rootScope, $cookies, $http){
			//XSRF INTEGRATION
			$rootScope.$watch(
					function(){
						return $cookies[serverVars.csrfCookieName]; // if this function see any differences from the second iteration to the previous one it will tell the browser to change
					},
					function(){
						$http.defaults.headers.common['X-XSRF-TOKEN'] = $cookies[serverVars.csrfCookieName]; 
					}
				)	
			}
	]);
	
