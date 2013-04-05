'user strict';
 angular.module('Controllers')
	.controller('UserScheduleIndexCtrl',[
		'$scope',
		'UserScheduleServ',
		function($scope, UserScheduleServ){
			UserScheduleServ.get(
				[],
				function (response){
					console.log(response);
				},
			
			);
		}
		
		])