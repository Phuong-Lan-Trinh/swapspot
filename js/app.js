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