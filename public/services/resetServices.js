/**
 * @description:to call forgetpassword templates as on the request
 * @param:$http,$location
 */


app.service("resetPasswordService", function ($http, $location) {
	try {
		this.resetPassword = function (data, $scope) {
			$http({
				method: 'POST',
				url: 'user/forgotPassword/' + $scope.token,
				data: data
			}).then(function successCallBack(response) {
					$scope.message = response.data.message;
					// $location.path('/login');
					console.log("update password", response);
				},
				function errorCallBack(response) {
					$scope.message = response.data.message;
					// $scope.result="password mismatched";
					console.log("Password is not update", response);
				}
			)
			console.log('in service ', data);
		}
	} catch (e) {
		console.log(e);
	}
})
