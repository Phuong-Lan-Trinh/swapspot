'use strict';

angular.module('Header.Controllers', []);

//this is not a page level controller, its a subcontroller, therefore we just define the controllers as part of the Header.Controllers
//make sure to not redefine the [], or else it will overwrite and not append!
angular.module('Header.Controllers')
	.controller('HeaderCtrl', [
		'$scope',
		function($scope){
			$scope.testData = 'Hello World';
		}
	]);