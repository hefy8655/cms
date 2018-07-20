angular.module('slb.routes', [])

.config(function($stateProvider, $urlRouterProvider, $ionicConfigProvider){
	$ionicConfigProvider.tabs.position('bottom');
    $ionicConfigProvider.navBar.alignTitle('center');

    $stateProvider
    //tab
    .state("tab",{
        abstract: true,
        templateUrl:'tpls/tab.html'
    })

    // .state('tab.auth',{
    //     abstract: true,

    //     views:{
    //         'login':{
    //             templateUrl:'tpls/signInview.html'　
    //         }
    //     }
    //     ,
    //     resolve:{
    //         user:['UserService','$q','$window',function(UserService,$q,$window){
    //             var d = $q.defer();

    //             return UserService.checkWeChatAuth().then(function(data){
    //                 if(data.status){
    //                     UserService.setCurrentUser(data.data).then(function(){
    //                         d.resolve(data.data)
    //                     })
    //                 }else{
    //                     $window.location.href = data.url;
    //                 }
    //                 return d.promise;
    //             })
    //         }]
    //     }
    // })

    //首页
    .state('tab.index',{
        url:'/index',
        cache:false,
        views:{
            'tab-index@tab':{
                templateUrl:'tpls/index.html',
                controller:"IndexCtrl"    
            }
        }
	})

   //视频
    .state('tab.video',{
        url:'/video',
        cache:false,
        views:{
            'tab-video@tab':{
                templateUrl:'tpls/video.html',
                controller:'VideoCtrl',
            }
        }
    })

    //视频内页
    .state('videoInside',{
        url:'/videoInside/:id',
        cache:false,
        templateUrl:'tpls/videoInside.html',
        controller: 'VideoInsideCtrl',
    })

    //话题页
    .state('tab.topic',{
        url:'/topic',
        cache:false,
        views:{
            'tab-topic@tab':{
                templateUrl:'tpls/topic.html',
                url: 'TopicCtrl',
                controller: 'TopicCtrl',
            }
        }
    })

    //话题内页
    .state('topicInside',{
        url:'/topicInside/:id',
        cache:false,
        templateUrl:'tpls/topicInside.html',
        controller: 'TopicInsideCtrl',
    })


    $urlRouterProvider.otherwise('/index');
})