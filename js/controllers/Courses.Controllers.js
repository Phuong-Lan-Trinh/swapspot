'use strict';

angular.module('Courses.Controllers', ['Courses.Controllers.Index']);

angular.module('Courses.Controllers.Index', [])
	.controller('CoursesIndexCtrl', [
		'$scope',
		'CoursesServ',
		function($scope, CoursesServ){
		
			//get all the courses
			CoursesServ.query(
				{},
				function(response){
					$scope.courses = response;
				},
				function(response){
					if(typeof response.data.error !== 'undefined'){
						$scope.coursesError = response.data.error.database;
					}else{
						$scope.coursesError = 'Uh oh something did not work!';
					}
				}
			);
			
			//get course 2
			CoursesServ.get(
				{ id: 2 },
				function(response){
					//all good
					$scope.specificCourse = response;
				},
				function(response){
					//oh no!
					if(typeof response.data.error !== 'undefined'){
						$scope.specificCourseError = response.data.error.database;
					}else{
						$scope.specificCourseError = 'Uh oh something did not work!';
					}
				}
			);
		}
	]);