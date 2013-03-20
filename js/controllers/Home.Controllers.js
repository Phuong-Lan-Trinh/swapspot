'use strict';

//Page Level Controller
//Can have multiple mini controllers, similar to methods
angular.module('Home.Controllers', ['Home.Controllers.Index']);

//Define the default index "method" for the the Home.Controllers
//Called HomeIndexCtrl
angular.module('Home.Controllers.Index', [])
	.controller('HomeIndexCtrl', [
		'$scope',
		function($scope){
			$scope.data = 'HELLO!';
		}
	]);