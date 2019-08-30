/**
 * @description:to validate the pass the controller to service
 * @param:$scope,regsterService
 */
app.controller('controllerRegister', function ($scope, registerService, loginService) {
	try {
		//console.log("inControler.......");
		$scope.register = () => {
			var data = {
				"firstname": $scope.firstname,
				"lastname": $scope.lastname,
				"email": $scope.email,
				"password": $scope.password
			}
			registerService.register(data, $scope);
		}
	} catch (e) {
		console.log(e);
	}

});
