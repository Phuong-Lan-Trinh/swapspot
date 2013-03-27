'use strict';

angular.module('Dummy.Controllers', ['Dummy.Controllers.Index']);

angular.module('Dummy.Controllers.Index', [])
	.controller('DummyIndexCtrl', [
		'$scope',
		function($scope){
			$scope.data="Hello I am the Dummy Controller";
		}
	]);	