'use strict';

angular.module('Footer.Controllers', ['ErrorResponse.Service']);

angular.module('Footer.Controllers')
	.controller('FooterCtrl', [
		'$scope',
		'httpMessages',
		function($scope, httpMessages){
		
			/*
			$scope.$watch(function(){
				return $scope.isAlerting;
			}, function(){
				$scope.isAlerting = !$scope.isAlerting;
			});
			*/
			
			$scope.httpMessages = httpMessages;
		}
	]);