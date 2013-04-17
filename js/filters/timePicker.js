'use strict';
// This directive create a dropdown menu for time picking
angular.module('Directives')
	.directive('timePickerDir',[
		function(){
			//here we return the directive definition object
			return{
				scope: {},
				link: function(scope,element, attributes){
					
					element.timepicker({'scrollDefaultNow': true});
					
				}
			};
		}
	])


	.directive('durationDir',[
		function(){
			return{
				scope: {},
				link: function(scope, element, attributes){
					element.timepicker({
						'minTime': scope.timeStart,
						'maxTime': '11:00pm',
						'showDuration': true
					})
				}
			}
		}
	]);
