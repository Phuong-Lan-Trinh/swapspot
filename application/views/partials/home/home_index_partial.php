<script type="text/ng-template" id="home_index.html">
	<div class="main">
		<div class="span8 offset2">
			<h2 style="text-align:center">Find your parking partner!</h2>
			<h2 style="text-align:center">SWAP your SPOT</h2>
		</div>
		<div class="span6 offset3">
			<form name="scheduleForm" ng-submit="scheduleSubmit()">
				<div class="control-group">  
					<label for="scheduleLocation" style="margin-left:0px"> 
						<p>I am parking at</p>
					</label>
					<input class="span6" id="scheduleLocation" name="scheduleLocation" ng-model="scheduleForm.location" type="text" placeholder="Car park location">
				</div>
				<div class="controls controls-row">
					<div class="span3" style="margin-left:0px">
						<label for="scheduleTimestart">I want to swap at</label>
						<input class="span3 timePicker" id="scheduleTimestart" name="scheduleTimestart" ng-model="scheduleForm.timestart" type="time" placeholder="Time start">
					</div>
					<div class="span3 inline">
						<label for="scheduleTimeend">for</label>
						<input class="span3" id="scheduleTimeend" name="scheduleTimeend" ng-model="scheduleForm.timeEnd" type="text" placeholder="Time length">
					</div>
				</div>
				<button class="btn btn-primary pull-right" type="submit" name="submit" value="true" >Search to SWAP</button>
			</form>
		</div>
	</div>
</script>