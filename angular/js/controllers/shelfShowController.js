angular.module("Fridge")
  .controller('shelfShowController', function($http, $routeParams) {
    var host = 'http://api.fridge.dima.ekreative.com';
    var controller = this;

    $http({method: 'GET', url: host + '/shelf/' + $routeParams.id})
      .success(function(data) {
        controller.shelfs = data;
      });
  });