'use strict';

angular.module('Services')
	.factory('HomeServ', [
			'$resource',
			function($resource){
				return $resource(
					'api/home/:homeId',
					{}
				);
			}
		]);