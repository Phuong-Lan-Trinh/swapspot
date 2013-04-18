<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js ng-app='App' lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js ng-app='App' lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js ng-app='App' lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" ng-app='App'> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?=$sitename?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <link rel="shortcut icon" href="favicon.ico">
    	<link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <base href="<?= base_url() ?>" />
        <!--[if lte IE 8]>
            <script>
                // The ieshiv takes care of our ui.directives, bootstrap module directives and
                // AngularJS's ng-view, ng-include, ng-pluralize and ng-switch directives.
                // However, IF you have custom directives (yours or someone else's) then
                // enumerate the list of tags in window.myCustomTags
                //window.myCustomTags = [ 'yourDirective' ];
            </script>
            <script src="js/vendor/angular-ui-ieshiv.min.js"></script>
        <![endif]-->        
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
        
        <header class="navbar navbar-static-top" ng-controller="AuthIndexCtrl">
            <div class="container">
				<div class="navbar-inner">
                    <a class="logo" href="#"><img src="" /></a>
					
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<div class="nav-collapse collapse">
                        <a class="brand" href="#" style="padding-top:7px"><img src="http://i400.photobucket.com/albums/pp81/ngua_con_cao_co/Newlogodesigncopy1.png"/></a>
						<ul class="nav">
                            <li><a href="#">Home</a></li>
                            <li><a href="#">About</a></li>
                            <li><a href="#">Contact</a></li>
						</ul>
                        <div>
                            <form name="loginForm" ng-hide="state" ng-submit="login()" class="navbar-form pull-right">
                                <input id="email" ng-model="loginForm.email" class="span2" type="text" placeholder="Email">
                                <input id="password" ng-model="loginForm.password" class="span2" type="password" placeholder="Password">
                                <label class="checkbox inline" for="form_remember">
                                    <input id="for_remember" type="checkbox" checked="checked">
                                     <small><small>Remember</small></small>&nbsp;
                                </label>
                                <button name="submit" class="btn pull-right" type="submit" style="inline" value="true">Sign in</button>
                           </form>
                        </div>


                        <div ng-show="state" class="nav-collapse collapse">
                            <ul class="nav pull-right">
                                <li style="padding:10px 15px">Welcome to SWAPSPOT</li>
                                <li><a href="" ng-click="logout()">Logout</a></li>
                            </ul>
                        </div>

					</div>
				</div>                
            </div>
        </header>
        </script>