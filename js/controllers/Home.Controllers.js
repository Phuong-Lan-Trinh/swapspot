'use strict';

//Page level controller
//Can have multiple mini controllers, similar to methods
angular.module('Controllers')
	.controller('HomeIndexCtrl', [
			'$scope',
			function($scope){
			$scope.data = 'HELLO!';
			}		
		]);
	

//Define the default index "method" for the Home.Controllers
// Called HomeIndexCtrl
	
