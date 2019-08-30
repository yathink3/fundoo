<html lang="en">

<head>
    <title>Codeigniter 3</title>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular-route.min.js"></script>
    <script src="public/app.js"></script>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <script src="public/services/loginService.js"></script>
    <script src="public/controller/loginController.js"></script>
    <script src="public/services/registerService.js"></script>
    <script src="public/controller/registerController.js"></script>
    <script src="public/services/forgotService.js"></script>
    <script src="public/controller/forgotController.js"></script>
    <script src="public/services/resetService.js"></script>
    <script src="public/controller/resetController.js"></script>
</head>

<body ng-app="myApp">
    <h1>HOME PAGE</h1>
    <ng-view></ng-view>
</body>

</html>