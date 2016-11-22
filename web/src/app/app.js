(function(){
  var fridgeApp = angular.module('fridge', ['ngRoute'])
    .config(function($routeProvider){
      $routeProvider.when('/items', {
        templateUrl: '../templates/index.html.twig'
      })
    });
})();
