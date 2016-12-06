angular.module("Fridge")
  .controller('shelfIndexController', function($http) {
    var host = 'http://api.fridge.dima.ekreative.com';
    var controller = this;

    $http.defaults.useXDomain = true;

    $http({method: 'GET', url: host + '/shelfs'})
      .success(function(data) {
        console.log(data);
        controller.shelfs = data;
      });
  });
