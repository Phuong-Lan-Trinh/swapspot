'use strict';

angular.module('Courses.Service', [])
	.factory('CoursesServ', [
		'$resource',
		function($resource){
		
			return $resource(
				'api/courses/:id',
				{},
				{
					update: {
						method: 'PUT', //THIS METHOD DOESN'T EXIST BY DEFAULT
					}
				}
			);
	
		}
	]);