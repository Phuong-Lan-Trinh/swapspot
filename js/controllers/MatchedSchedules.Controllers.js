'use strict';
angular.module('Controllers')
	.controller('MatchedScheduleIndexCtrl',[
		'$scope',
		'MatchedSchedulesServ',
		function($scope, MatchedSchedulesServ){

			$scope.address = 'Hello world';

			$scope.mapOptions = {
				center: new google.maps.LatLng(35.784, -78.670),
				zoom: 15,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			MatchedSchedulesServ.get(
				[],
				function (response){
					console.log(response);
				}
			
			);
		}
		
	]);