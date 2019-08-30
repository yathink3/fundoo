/**
 * @description:to call login templates as on the request
 * @param:$http,$location
 */

app.service("forgotService", function ($http, $location) {
	try {
		this.forgot = function (data, $scope) {

			$http({
				method: 'POST',
				url: 'user/forgot',
				data: data
			}).then(function successCallBack(response) {
					console.log("token generated successfull", response);
					// $scope.message = response.data.message;
					$location.path('#/success');

				},
				function errorCallBack(error) {
					// console.log("forgot failed", error);
					// $scope.message = error.data.message;
				}
			)
			console.log('in service ', data);
		}
	} catch (e) {
		console.log(e);
	}
})
