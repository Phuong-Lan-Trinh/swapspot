'use strict';

angular.module('Services')
	.factory('MatchedSchedulesServ', [
		'$resource',
		function($resource){
			return $resource(
				'api/matchedschedules/:id',
				{},
				{
					update: {
						method: 'PUT'
					}
				}
			);
		}
	]);
