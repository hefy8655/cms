(function(){
	'use strict';

    var slb = angular.module("slb", ['ionic','ion-datetime-picker','slb.routes', 'slb.services', 'slb.controllers' ,'slb.directives' ,'slb.filter','ngFileUpload', 'slb.config']);

	getWXAuthStatus().then(function(data){

        if(data.status){
            slb.constant("USER_INFO", data.data);
            bootstrapApplication();
        }else{
            location.href = data.url;
        }
	});	

    function getWXAuthStatus(){

        var initInjector = angular.injector(["ng"]);
        var $http = initInjector.get("$http");

        return $http({
            url: '/Home/Auth/checkAuthStatus',
            params: {
                redirect_url : location.href
            }
        }).then(function(response){

            return response.data;

        }, function(errorResponse){

            return errorResponse;

        })

    }

    function bootstrapApplication() {
        angular.element(document).ready(function() {
            angular.bootstrap(document, ["slb"]);
        });
    }

	function getQueryParams( name, url ) {
	  if (!url) url = location.href;
	  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	  var regexS = "[\\?&]"+name+"=([^&#]*)";
	  var regex = new RegExp( regexS );
	  var results = regex.exec( url );
	  return results == null ? null : results[1];
	}


})()