angular.module("Fridge")
  .config(function($routeProvider) {
    $routeProvider.when('/shelfs', {
      templateUrl: '/templates/shelfs/index.html'
    })
    .when('/', {
      templateUrl: '/templates/admin/index.html'
    });
  });
