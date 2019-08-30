/**
 * @description:to call login templates as on the request
 * @param:$http,$location
 */

app.service("loginService", function ($http, $location) {
	try {
		this.login = function (data, $scope) {

			$http({
				method: 'POST',
				url: 'user/login',
				data: data
			}).then(function successCallBack(response) {
					console.log("Login successfull", response);
					$scope.message = response.data.message;
					$location.path('#/success')

				},
				function errorCallBack(error) {
					console.log("Login failed", error);
					$scope.message = error.data.message;
				}
			)
			console.log('in service ', data);
		}
	} catch (e) {
		console.log(e);
	}
})
