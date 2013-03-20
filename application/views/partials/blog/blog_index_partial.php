<script type="text/ng-template" id="blog_index.html">
	<div class="item" ng-repeat="phone in phones">
		{{phone.age}}
		{{phone.name}}
	</div>
	<div>
		<h1>ONE ITEM</h1>
		{{singlephone.error}}
		{{singlephone.name}}
	</div>
	<button ng-click="addSomeData()">Add some Data to the phones array</button>
	<form name="phoneForm" ng-submit="submitForm()">
		<input name="phoneAge" ng-model="phoneForm.age" required />
		<span class="error" ng-show="phoneForm.phoneAge.$error.required">Required!</span>
		<br />

		<input name="phoneName" ng-model="phoneForm.name" required />
		<input name="phoneId" ng-model="phoneForm.id" required />
		<input name="phoneDesc" ng-model="phoneForm.desc" required />
		<br />

		<tt>DATA = {{phoneForm.age}}</tt><br>
		<tt>phoneForm.phoneAge.$valid = {{phoneForm.phoneAge.$valid}}</tt><br>
		<tt>phoneForm.phoneAge.$error = {{phoneForm.phoneAge.$error}}</tt><br>
		<tt>phoneForm.$valid = {{phoneForm.$valid}}</tt><br>
		<tt>phoneForm.$error.required = {{!!phoneForm.$error.required}}</tt><br>
		
		<button type="submit" name="submit" value="true">Submit!</button>
	</form>
</script>