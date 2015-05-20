var newGoodsModule = angular.module('newGoodsModule', []);
newGoodsModule.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('<{');
    $interpolateProvider.endSymbol('}>');
  });
newGoodsModule.controller('formController', ['$scope', 
	function($scope) {
		$scope.goods = {goods_title: '', goods_type: '', goods_price:'', goods_content:''};
	}
]);

