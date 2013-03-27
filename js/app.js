'use strict';

var app=angular.module('App', [
	'Controllers'
	
]);
angular.module('Controllers', [
	'Home.Controllers',
	]);
	
app.config(
	[
		'$routeProvider',
		'$locationProvider',
		function($routeProvider,$locationProvider){
		
			//HTML5 Mode URLs
			// $location Provider.html5Mode(true).hashPrefix('!');
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
					
				)
		}
	
	]
)