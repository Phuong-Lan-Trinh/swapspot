'use strict';

angular.module('Fade.Directive', []);

/**
 * Fade in then out directive, use it on items.
 *
 * @param int Number of ms to delay the fade.
 */
angular.module('Fade.Directive')
	.directive('fadeInOutDir', [
		function(){
			return {
				scope:{
					httpMessage: '='
				},
				link: function(scope, element, attributes){
				
					//there's no isolate scope here because that would block the external binding, but also there's no possibility of scope conflict here since there's no scope work
					element.hide().fadeIn('fast').delay(attributes.fadeInOutDir).fadeOut('slow', function(){

					});
				}
			};
			
		}
	]);