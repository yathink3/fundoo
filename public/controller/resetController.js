/**
 * @description:to validate and the pass the controller to service
 * @param:$scope,registerpasswordService,location
 */

app.controller('controllerReset', function ($scope, $location, resetPasswordService) {
	try {
		if ($location.url().indexOf('token') !== -1) {
			$scope.token = $location.url().split('=')[1];
			console.log($scope.token);
		}
		$scope.resetPassword = () => {
			if ($scope.password != $scope.cpassword) {
				$scope.data.message = "confirmPassword is not matching";
			} else {
				var data = {
					"password": $scope.password,
					"cpassword": $scope.cpassword
				}
				resetPasswordService.resetPassword(data, $scope);
			}
		}
	} catch (e) {
		console.log(e);
	}
});
