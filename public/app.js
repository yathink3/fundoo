var app = angular.module("myApp", ["ngRoute"]);
/**
 * @description:to call templateurl and controller
 */
app.config(function ($routeProvider) {
	$routeProvider
		.when('/', {
			templateUrl: 'templates/login.html',
			controller: "controllerLogin"
		}).when('/register', {
			templateUrl: "templates/register.html",
			controller: "controllerRegister"
		}).when('/forgot', {
			templateUrl: "templates/forgot.html",
			controller: "controllerForgot"
		})
		.when('/success', {
			templateUrl: "templates/success.html",
		})

		.otherwise({
			redirectTo: "/"
		})

});
