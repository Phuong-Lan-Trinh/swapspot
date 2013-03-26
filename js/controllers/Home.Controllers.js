'use strict';

//Page level controller
//Can have multiple mini controllers, similar to methods
angular.module('Home.Controllers', ['Home.Controllers.Index']);

//Define the default index "method" for the Home.Controllers
// Called HomeIndexCtrl
	angular.module('Home.Controllers.Index', [])
		.controller('HomeIndexCtrl', [
			'$scope',
			function($scope){
			$scope.data = 'HELLO!';
			}
	]);