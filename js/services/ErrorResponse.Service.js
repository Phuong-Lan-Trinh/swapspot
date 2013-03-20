'use strict';

/**
 * Response Handler for Error Codes across all HTTP requests to show an alert box!
 */
angular.module('ErrorResponse.Service', [])
	.config(
		[
			'$provide',
			'$httpProvider',
			function($provide, $httpProvider){
				
				//model variable...
				var httpMessages = [];
				
				//bind the httpMessages array to the httpMessages key so it can be dependency injected
				$provide.value('httpMessages', httpMessages);
				
				$httpProvider.responseInterceptors.push(['$q', function($q) {
				
					return function(promise) {
						
						return promise.then(
							function(successResponse) {
								
								//we only want to show anything that wasn't a GET based request
								//these allow you show messages, you don't have to show these types though (because usually not required)
								
								switch(successResponse.config.method.toUpperCase()){
									// case 'GET':
										// httpMessages.push({
											// message: 'Successfully Received',
											// type: 'success'
										// });
										// break;
									case 'POST':
										httpMessages.push({
											message: 'Successfully Posted',
											type: 'success'
										});
										break;
									case 'PUT':
										httpMessages.push({
											message: 'Successfully Updated',
											type: 'success'
										});
										break;
									case 'DELETE':
										httpMessages.push({
											message: 'Sucessfully Deleted',
											type: 'success'
										});
										break;
								}
								
								
								return successResponse;

							},
							function(failureResponse) {
								
								switch(failureResponse.status){
									case 400: //show validation error messages then!
										httpMessages.push({
											message: 'Validation failed, try tweaking your submission.',
											type: 'failure'
										});
										break;
									case 401: //for ionauth authentication, will need to redirect to login screen, or modal box
										httpMessages.push({
											message: 'Unauthorised request, try logging in.',
											type: 'failure'
										});
										break;
									case 403: //returned by server for resources the user should not be able to access directly
										httpMessages.push({
											message: 'You can\'t access this.',
											type: 'failure'
										});
										break;
									case 404:
										httpMessages.push({
											message: '404, sorry could not find what you were looking for.',
											type: 'failure'
										});
										break;
									case 405:
										httpMessages.push({
											message: 'The requested method was incompatible with the requested resource.',
											type: 'failure'
										});
										break;
									case 500:
										httpMessages.push({
											message: 'There was a server error, try again later, or contact the owners.',
											type: 'failure'
										});
										break;
									default:
										httpMessages.push({
											message: failureResponse.status + ' General error processing the request',
											type: 'failure'
										});
								}
								
								return $q.reject(failureResponse);
								
							}
						);
						
					};
					
				}]);
				
			}
		]
	);