/**
 * @description:to call register templates as on the request
 * @param:$http,$location
 */

app.service("registerService", function ($http, $location) {
    try {
        this.register = function (data, $scope) {
            $http({
                method: 'POST',
                url: 'user/registration',
                data: data
            }).then(function successCallBack(response) {
                    console.log("Registration successfull", response);
               $scope.message = response.data.message;

                },
                function errorCallBack(error) {
                    console.log("Registration Failed", error);
                   $scope.message = error.data.message;
                }
            )
            console.log('in service ', data);
        }
    } catch (e) {
        console.log(e);
    }
})