'use strict';

angular.module('Blog.Controllers', ['Blog.Controllers.Index']);

angular.module('Blog.Controllers.Index', [])
	.controller('BlogIndexCtrl', [
		'$scope',
		function($scope){
			
			/*
			BlogDataServ.get({id: 'one-specific'},
				function(response){
					//success callback
					$scope.singlephone = response;
				},
				function(response){
					//error callback
					if(typeof response.data.error !== 'undefined'){
						$scope.singlephone.error = response.data.error;
					}else{
						$scope.singlephone.error = 'Uh oh something did not work!';
					}
				}
			);
			
			$scope.phones = BlogDataServ.query();
			
			$scope.addSomeData = function(){
			
				// var newPhone = new BlogDataServ();
				// newPhone.phoneAge = '5';
				// newPhone.phoneId = 'some random';
				// newPhone.phoneName = 'Some awesome phone';
				// newPhone.phoneDesc = 'Yippee!';
				// newPhone.$save();
				
				BlogDataServ.save(
					{},
					{
						phoneAge: '5',
						phoneId: 'some random',
						phoneName: 'Awesome Phone',
						phoneDesc: 'Yippee!'
					},
					function(response){
						//success
						console.log(response.status);
						
					}
				);
				
				// BlogDataServ.update(
					// {id: 'one-specific'},
					// {
						// phoneAge: '4',
					// },
					// function(response){
						// console.dir(response, 'delete');
					// }
				// );
				
				// BlogDataServ.remove(
					// {id: 'one-specific'},
					// {},
					// function(response){
						// console.dir(response, 'delete');
					// }
				// );
			
			};
			
			$scope.submitForm = function(){
				//console.log(this.phoneForm);
				
				for(var key in this.phoneForm){
					if(!this.phoneForm.hasOwnProperty(key)) continue; //check if the key is part of the object directly, not prototype
					console.log(key);
					console.log(this.phoneForm[key]);
				}
				
				// BlogDataServ.save(
					// {},
					// {
						// phoneAge: this.phoneForm.age, //these are from the phoneForm.age model!
						// phoneId: this.phoneForm.id,
						// phoneName: this.phoneForm.name,
						// phoneDesc: this.phoneForm.desc
					// },
					// function(response){
						// console.dir(response);
					// }
				// );
			};
			*/
			
		}
	]);