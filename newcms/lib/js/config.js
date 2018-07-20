var app=angular.module('slb.config', []);

app.run(['$rootScope','$state','$http','$state','$stateParams', '$ionicModal', '$ionicPlatform', function($rootScope,$state,$http,$state,$stateParams,$ionicModal,$ionicPlatform){
	$ionicPlatform.ready(function() {
    // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
    // for form inputs)
    if (window.cordova && window.cordova.plugins && window.cordova.plugins.Keyboard) {
      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
      cordova.plugins.Keyboard.disableScroll(true);
    }
    if (window.StatusBar) {
      // org.apache.cordova.statusbar required
      StatusBar.styleDefault();
    }

  });

  
}])

app.config(function($httpProvider){
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
    $httpProvider.defaults.headers.common['X-Requested-With'] = 'xmlhttprequest';

      var param = function(obj) {
          var query = '',
              name, value, fullSubName, subName, subValue, innerObj, i;

          for (name in obj) {
              value = obj[name];

              if (value instanceof Array) {
                  for (i = 0; i < value.length; ++i) {
                      subValue = value[i];
                      fullSubName = name + '[' + i + ']';
                      innerObj = {};
                      innerObj[fullSubName] = subValue;
                      query += param(innerObj) + '&';
                  }
              }
              else if (value instanceof Object) {
                  for (subName in value) {
                      subValue = value[subName];
                      fullSubName = name + '[' + subName + ']';
                      innerObj = {};
                      innerObj[fullSubName] = subValue;
                      query += param(innerObj) + '&';
                  }
              }
              else if (value !== undefined && value !== null) query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
          }

          return query.length ? query.substr(0, query.length - 1) : query;
      };

      $httpProvider.defaults.transformRequest = [function(data) {
          return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
      }];
  })