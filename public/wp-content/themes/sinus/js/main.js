'use strict';

var app = angular.module('sinus', ['ui.router', 'ngSanitize']);

app.config(['$stateProvider', '$locationProvider', '$urlRouterProvider', function ($stateProvider, $locationProvider, $urlRouterProvider) {

  $locationProvider.html5Mode({
    enabled: true
  });

  $urlRouterProvider.when('', '/');

  $stateProvider.state('/', {
    url: '/',
    views: {
      'header': {
        templateUrl: 'partials/header.html',
        controller: 'HeaderController'
      },
      'filters': {
        templateUrl: 'partials/filters.html',
        controller: 'FilterController'
      },
      'banner': {
        templateUrl: 'partials/banner.html',
        controller: 'BannerController'
      }
    }
  }).state('/brands/:brand', {
    url: '/brands/:brand',
    views: {
      'header': {
        templateUrl: 'partials/header.html',
        controller: 'HeaderController'
      },
      'filters': {
        templateUrl: 'partials/filters.html',
        controller: 'FilterController'
      },
      'brandproducts': {
        templateUrl: 'partials/brand.html',
        controller: 'BrandController'
      }
    }
  }).state('/brands/:brand/:model', {
    url: '/brands/:brand/:model',
    views: {
      'header': {
        templateUrl: 'partials/header.html',
        controller: 'HeaderController'
      },
      'filters': {
        templateUrl: 'partials/filters.html',
        controller: 'FilterController'
      },
      'productpage': {
        templateUrl: 'partials/productpage.html',
        controller: 'SingleProductController'
      }
    }
  }).state('/:category', {
    url: '/:category',
    views: {
      'header': {
        templateUrl: 'partials/header.html',
        controller: 'HeaderController'
      },
      'filters': {
        templateUrl: 'partials/filters.html',
        controller: 'FilterController'
      },
      'products': {
        templateUrl: 'partials/products.html',
        controller: 'ProductsController'
      }
    }
  }).state('/:category/:brand/:model', {
    url: '/:category/:brand/:model',
    views: {
      'header': {
        templateUrl: 'partials/header.html',
        controller: 'HeaderController'
      },
      'filters': {
        templateUrl: 'partials/filters.html',
        controller: 'FilterController'
      },
      'products': {
        templateUrl: 'partials/productpage.html',
        controller: 'SingleProductController'
      }
    }
  });
}]);
'use strict';

app.controller('ProductsController', ['$rootScope', '$scope', '$q', 'ProductsService', function ($rootScope, $scope, $q, ProductsService) {

	$rootScope.rawData = [];

	var dataPromise = {
		getProducts: ProductsService.getAllProducts()
	};

	// function sortProducts() {

	// };

	var sortProducts = function sortProducts() {
		return console.log($rootScope.rawData);
	};

	$q.all(dataPromise).then(sortProducts);
}]);
'use strict';

app.factory('ProductsService', ['$rootScope', '$http', '$q', function ($rootScope, $http, $q) {

	return {
		getAllProducts: function getAllProducts() {
			return $http({ method: 'GET', url: '/wp-json/posts?type=product' }).then(function (data) {
				$rootScope.rawData.push(data.data);
			});
		}
	};
}]);