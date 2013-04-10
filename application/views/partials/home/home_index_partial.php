<script type="text/ng-template" id="home_index.html">
   <div class="main">
            <div class="span8 offset2">
            <h2 style="text-align:center">Find your parking partner!</h2>
            <h2 style="text-align:center">SWAP your SPOT</h2>
            </div>
            <div class="span3 offset3">
               

                    <form class="form-horizontal">
                    
                        <div class="control-group">
                            <label  class="control-label" for="username_registration">User name</label>
                            <div class="controls">
                                <input name="username" type="text" id="username_registration">
                            </div>
                        </div>
                        <div class="control-group">
                            <label  class="control-label" for="email_registration">Email</label>
                            <div class="controls">
                                <input name="email" type="text" id="email_registration" placeholder="Email">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="password_registration">Password</label>
                            <div class="controls">
                                <input name="password" type="password" id="password_registration" placeholder="Password">
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <button type="submit" class="btn">Sign up</button>
                             </div>
                        </div>
                    </form>

            </div>
            <div class="span6 offset3">
                <form accept-charset="utf-8" method="post">
                    <div class="control-group">  
                        <label class="for_location"> 
                            <p>I am parking at</p>
                        </label>
                            <input name="location" class="Location span6" type="text" placeholder="Car park location">
                    </div>
                    
                    
                    <div class="controls controls-row">
                        <div class="span3" style="margin-left:0px">
                            <label class="for_Time">I want to swap at</label>
                            <input name="timestart" class="Time span3" type="time" placeholder="Time start">
                        </div>
                    
                        <div class="span3 inline">
                            <label class="for_TimeEnd">for</label>
                            <input name="timeEnd" class="Timelength span3" type="text" placeholder="Time length">
                        </div>
                    </div>
                    <button class="btn btn-primary pull-right">Search to SWAP</button>
                </form>
            </div>
    </div>
</script>