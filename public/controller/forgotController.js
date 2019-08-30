/**
 * @description:to validate and the pass the controller to service
 * @param:$scope,forgotService
 */
app.controller('controllerForgot', function ($scope, forgotService) {
	try {
		$scope.forgot = () => {
			var data = {
				"email": $scope.email
			}
			forgotService.forgot(data, $scope);
		}
	} catch (e) {
		console.log(e);
	}

});
