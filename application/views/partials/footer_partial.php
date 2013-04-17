        <!-- Client Side Templates -->
        <? Template::asset('application/views/partials', 'php', array('footer_partial.php', 'header_partial.php')) ?>
        
        <!-- Pass in PHP variables to Javascript -->
        <script>
            var serverVars = {
                baseUrl: '<?= base_url() ?>',
                csrfCookieName: '<?= $this->config->item('cookie_prefix') . $this->config->item('csrf_cookie_name') ?>'
            };
        </script>

        <!-- vendor javascript -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.0.min.js"><\/script>')</script>
        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.0.5/angular.min.js"></script>
        <script src="js/vendor/jquery.timepicker.min.js"></script>
        <script>window.angular || document.write('<script src="js/vendor/angular.min.js"><\/script>')</script>
        <script src="js/vendor/angular-cookies.min.js"></script>
        <script src="js/vendor/angular-resource.min.js"></script>
        <script src="js/vendor/angular-ui.min.js"></script> 
        <script src="js/vendor/ui-bootstrap-tpls-0.2.0.min.js"></script> 

        <!-- Shims and Shivs and Other Useful Things -->
        <!--[if lt IE 9]><script src="js/vendor/es5-shim.min.js"></script><![endif]-->
        <script src="js/vendor/es6-shim.min.js"></script>
        <!--[if lt IE 9]><script src="js/vendor/json3.min.js"></script><![endif]-->
        
        <? Template::asset('js', 'js', array('js/vendor')) ?>
                
        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>

        <? if(ENVIRONMENT == 'development'){ ?>
            <?
                Template::asset('js', 'js', array(
                    'js/main.min.js',
                    'js/vendor',
                    'js/vendor/codemirror',
                    'js/vendor/codemirror/mode'
                ));
            ?>
        <? }elseif(ENVIRONMENT == 'production'){ ?>
            <script src="js/main.min.js"></script>
            <script>
                var _gaq=[['_setAccount','<?= $google_analytics_key ?>'],['_trackPageview']];
                (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
                g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
                s.parentNode.insertBefore(g,s)}(document,'script'));
            </script>
        <? } ?>
    </body>
</html>