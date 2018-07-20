angular.module('slb.filter', [])

.filter('trusted', function($sce){
	return function(url) {
	    return $sce.trustAsResourceUrl(url);
	};
})