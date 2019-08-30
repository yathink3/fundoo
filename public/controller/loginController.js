/**
 * @description:to validate and the pass the controller to service
 * @param:$scope,loginService
 */
app.controller('controllerLogin', function ($scope, loginService) {
    try {
        $scope.login = () => {
            var data = {
                "email": $scope.email,
                "password": $scope.password
            }
            loginService.login(data, $scope);
        }
    } catch (e) {
        console.log(e);
    }

});