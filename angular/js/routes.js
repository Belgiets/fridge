angular.module("Fridge")
  .config(function($routeProvider) {
    $routeProvider.when('/shelfs', {
      templateUrl: '/templates/shelfs/index.html',
      controller: 'shelfIndexController',
      controllerAs: 'indexController'
    })
    .when('/shelfs/:id', {
      templateUrl: '/templates/shelfs/show.html',
      controller: 'shelfShowController',
      controllerAs: 'showController'
    })
    .when('/', {
      templateUrl: '/templates/admin/index.html'
    })
    .otherwise({
      redirectTo: '/'
    });
  });
