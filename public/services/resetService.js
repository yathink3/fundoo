/**
 * @description:to call forgetpassword templates as on the request
 * @param:$http,$location
 */


app.service("resetPasswordService", function ($scope, $http, $location) {
	try {
		this.resetPassword = function (data, $scope) {
			console.log('http://localhost/fundoo/user/forgotPassword/' + $scope.token);
			$http({
				method: 'GET',
				url: `'http://localhost/fundoo/user/forgotPassword/' + $scope.token`,
				data: data
			}).then(function successCallBack(response) {
					// $scope.result="password changed";
					// $location.path('/login');
					console.log("update password", response);
				},
				function errorCallBack(response) {
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
