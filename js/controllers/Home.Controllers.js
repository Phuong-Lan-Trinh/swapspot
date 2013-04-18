'use strict';

//Page level controller
//Can have multiple mini controllers, similar to methods
angular.module('Controllers')
	.controller('HomeIndexCtrl', [
		'$scope',
		'UserScheduleServ',
		'MatchedSchedulesServ',
		function($scope, UserScheduleServ, MatchedSchedulesServ){
		
			$scope.scheduleSubmit = function(){
				
				var payload = {
					location: $scope.scheduleForm.location,
					timestart: $scope.scheduleForm.timestart,
					timeEnd: $scope.scheduleForm.timeEnd
				};
				
				console.log(payload);
				
				//time to send it to the server
				UserScheduleServ.save(
					{},
					payload,
					function(successResponse){
					
						var schedulesId = successResponse.content.id;
						MatchedSchedulesServ.get(
							{
								id: schedulesId
							},
							function(successResponse){
						
								console.log(successResponse);
						
							},
							function(failResponse){
							
								console.log('FAIL');
							
							}
						);
					
					},
					function(failResponse){
					
						console.log('FAIL');
					
					}
				);
				
			};
		}
	]);