var newGoodsModule = angular.module('newGoodsModule', []);
newGoodsModule.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('<{');
    $interpolateProvider.endSymbol('}>');
  });
newGoodsModule.controller('formController', ['$scope', 
	function($scope) {
		$scope.goods_dealplace = "哈尔滨理工大学";
	}
]);

