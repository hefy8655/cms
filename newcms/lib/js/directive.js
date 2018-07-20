angular.module('slb.directives', [])
.directive('fileModel', ['$parse', function ($parse) {
  return {
    restrict: 'A',
	// scope:{
	// 	abc: '@'
	// },
    link: function(scope, element, attrs, ngModel) {
      var model = $parse(attrs.fileModel);
      var modelSetter = model.assign;
      element.bind('change', function(event){
        scope.$apply(function(){
          modelSetter(scope, element[0].files[0]);
        });
        //附件预览
        scope.file = (event.srcElement || event.target).files[0];
		console.log(scope.file)

		scope.abc = "abc"
		console.log(scope)
        scope.vm.getFile(scope);
      });
    }
  };
}])
.directive('sameWidthAndHeight' ,['$parse',function($parse){
	return {
		restrict:'A',
		link:function(scope,element,attrs,ngModel){
			var width = element[0].clientWidth;
			element.css('height', width);
		}
	}
}])
