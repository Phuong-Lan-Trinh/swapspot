'use strict';

angular.module('Controllers')
	.controller('AuthIndexCtrl', [
		'$scope',
		'UsersServ',
		function($scope, UsersServ){
		
			$scope.logout = function(){
				//both ways are possible
				//UsersServ.logoutSession(UsersServ.getUserData().id);
				$scope.$emit('authenticationDestroy', UsersServ.getUserData().id); //this does a redirect
			};
			
			$scope.$on('authenticationProvided', function(event,args) { //authenticationProvided is a global event that is being listen to
				$scope.state = true; //anything attached to $scope.state is a model
			});

			$scope.$on('authenticationLogout', function(event,args) {
				$scope.state = false;
			});

			$scope.login = function(){
			
				var payload = {
					email: $scope.loginForm.email,
					password: $scope.loginForm.password
				};
				
				//reset the submission errors!
				$scope.loginErrors = [];
				$scope.validationErrors = {};
				
				UsersServ.loginSession(
					payload,
					function(successResponse){
						console.log('We are logged in');
						
					},
					function(failResponse){
						console.log('Login failed, here\'s the errors.');
						if(failResponse.data.code === 'validation_error'){
						
							if(Array.isArray(failResponse.data.content)){
							
								//if it is an array of validation errors
								$scope.loginErrors = failResponse.data.content;
							
							}else{
							
								//else its an object of login errors
								$scope.validationErrors = {
									email: failResponse.data.content.email,
									password: failResponse.data.content.password
								};
							
							}
							
						}
					}
				);
				
				$scope.$on('authenticationProvided', function(event, args){
					var userData = UsersServ.getUserData();
					console.log(userData);
					$scope.state = true;
				});
			
			};
		
		}
	]);