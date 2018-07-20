var app = angular.module('slb.controllers', []);

//首页
app.controller('IndexCtrl' , ['$rootScope','$scope', '$state','$ionicPopup','$ionicSlideBoxDelegate','$ionicActionSheet','IndexService','ActivityService',function($rootScope,$scope,$state,$ionicPopup,$ionicSlideBoxDelegate,$ionicActionSheet,IndexService,ActivityService){
	$scope.index = {};
    $scope.images = {}
    $scope.topics={};
    $scope.video = {};

     function loadData(){
     	$scope.items={};
     	
     	IndexService.getIndex().then(function(data){
     		$scope.images = data.data.NoticeList;
			$ionicSlideBoxDelegate.update();
			$scope.topics = data.data.TopicList;
			$scope.video = data.data.VideoList;
			$scope.activities = data.data.ActivityList;
			angular.forEach($scope.activities, function(list){
				
				list.start_time = list.start_time.substring(5);
				list.end_time = list.end_time.substring(5);
				list.deadline = list.deadline.substring(5);

				list.start_time = list.start_time.replace('-','/');
				list.end_time = list.end_time.replace('-','/');
				list.deadline = list.deadline.replace('-','/');
			});
     	})
     }

  //    $scope.chooseAdd = function(){
  //    	var hideSheet = $ionicActionSheet.show({
		// 	buttons: [
		// 		{ text: '<div class="positive">发布话题</div>' },
		// 		{ text: '<div class="positive">发布活动</div>' }
		// 	],
		// 	cancelText: '取消',
		// 	cancel: function(index) {
		// 		return true;
		// 	},
		// 	buttonClicked: function(index) {
		// 		 if(index === 0){ // Allgemein
		// 		 	  $state.go('createTopic');
		// 		 }
		// 		 else if(index === 1){
		// 			$state.go('addActivity');
		// 		 }
		// 		 return true;
		// 	}
		// });
  //    }

     $scope.getActivityUserAdd = function(id){
		ActivityService.getActivityUserAdd(id).then(function(data){
			if(data.status = 1){
				// console.log(data);
				angular.forEach($scope.activities, function(list){
				
					if(id == list.id){
						list.ActivityUserStatus = 2;
						showAlert('报名成功！');
					}	
			     });
			}
		})
	}

	function showAlert(info) {
       var alertPopup = $ionicPopup.alert({
       title: info
       });
       alertPopup.then(function(res) {
       });
     };

     loadData();

     
}])

//视频
app.controller('VideoCtrl' , ['$rootScope','$scope','$stateParams','$timeout','$state','VideoService',function($rootScope,$scope,$stateParams,$timeout,$state,VideoService){
	
    $scope.videos = [];
    var videoId = $stateParams.id;
    page = 1;
    pageSize = 6;
    $scope.hasDate = true;

    $scope.loadMore = function(){
		$timeout(function(){
			// console.log(page)
			VideoService.getVideo(page,pageSize).then(function(data){
				var res = data.data;
				// console.log(res);
				if(res.length == 0){
					
					$scope.hasDate = false;
				}else{
					
					$scope.videos = $scope.videos.concat(res);
				}

				page++;
				$scope.$broadcast("scroll.infiniteScrollComplete");
			})
		},300)
	}


}])

//视频内页
app.controller('VideoInsideCtrl' , ['$rootScope','$scope','$ionicPopup','$stateParams','$state','VideoService',function($rootScope,$scope,$ionicPopup,$stateParams,$state,VideoService){
	
    $scope.videos = {};
    $scope.zambias = null;
    $scope.noneZambias = null;
    $scope.collection = null;
    $scope.nonecollection = null;
    $scope.commentShow = true
    var videoId = $stateParams.id;

    function isZamOrCollection(){
    	alert($scope.videoDetailList.CollectionStatus)
    	
    }

    $scope.videoDetailList = {};
    $scope.commentDetailList = {};

     //alert
     function showAlert(info) {
       var alertPopup = $ionicPopup.alert({
       title: info
       });
       alertPopup.then(function(res) {
       
       });
     };

     function goVideoDetail(videoId){
   		VideoService.getVideoDetail(videoId).then(function(data){
   			$scope.videoDetailList = data.data.VideoList;
   			$scope.commentDetailList = data.data.CommentVideoList;
   			$scope.videoDetailList.pageviews = parseInt($scope.videoDetailList.pageviews)+1;
   			console.log($scope.videoDetailList)
   			if(data.data.CommentVideoList.length == 0){
   				$scope.commentShow = false;
   			}
   			console.log(data.data.VideoList);
   			if(parseInt($scope.videoDetailList.zambiaStatus) == 0 || $scope.videoDetailList.zambiaStatus == false ){
  	    		$scope.zambias = false;
  	    	}else{
  	    		$scope.zambias = true;
  	    	};
   		})
     }

     goVideoDetail(videoId);

     $scope.initVideoComment = function(){
     	 	var id = $scope.videoDetailList.id;
     	 	var comment = $scope.comment;
        if(comment == null || comment == ""){
       	 	showAlert("请输入评论内容");
        }else{
          VideoService.initVideoComment(id,comment).then(function(data){
            
              showAlert(data.data.info);
              $scope.comment = null;
              $scope.commentDetailList.unshift(data.data.CommentVideoInfo);
          })
        }
 	 }
    
 	 $scope.getVideoZamPeopleSave = function(id){
 	 	VideoService.getVideoZamPeopleSave(id).then(function(data){
 	 		// console.log(data);
 	 		if($scope.zambias == false){
 	 			$scope.videoDetailList.zambias=parseInt($scope.videoDetailList.zambias)+1;
 	 			$scope.zambias = !$scope.zambias;
 	 		}else{
 	 			// $scope.videoDetailList.zambias=parseInt($scope.videoDetailList.zambias)-1;
 	 			// $scope.zambias = !$scope.zambias;
 	 		}
 	 	})
 	 }

}])

//话题
app.controller('TopicCtrl' , ['$rootScope','$scope','$timeout','$stateParams','$state','TopicService',function($rootScope,$scope,$timeout,$stateParams,$state,TopicService){
	$scope.topics = [];
	page = 1;
    pageSize = 6;
    $scope.hasDate = true;

    $scope.loadMore = function(){
		$timeout(function(){
			// console.log(page)
			TopicService.getTopic(page,pageSize).then(function(data){
				var res = data.data;
				// console.log(res);
				if(res.length == 0){
					
					$scope.hasDate = false;
				}else{
					
					$scope.topics = $scope.topics.concat(res);
				}

				page++;
				$scope.$broadcast("scroll.infiniteScrollComplete");
			})
		},300)
	}

}])

//话题内页
app.controller('TopicInsideCtrl' , ['$rootScope','$scope','$stateParams','$ionicPopup','$state','TopicService','$ionicModal','$ionicSlideBoxDelegate',function($rootScope,$scope,$stateParams,$ionicPopup,$state,TopicService, $ionicModal, $ionicSlideBoxDelegate){
	
    var topicId = $stateParams.id;
    $scope.zambias = false;
    $scope.topicDetailList = {};
    $scope.commentDetailList = {};

     function getTopicDetail(topicId){
 		TopicService.getTopicDetail(topicId).then(function(data){
 			console.log(data);
 			$scope.topicDetailList = data.data.TopicList;
 			$scope.topicImages = data.data.TopicList.images;
 			$scope.commentDetailList = data.data.CommentTopicList;
 			$scope.zambiaStatus = parseInt(data.data.TopicList.zambiaStatus);
 			var collectionStatus = parseInt(data.data.TopicList.collections);
 			if($scope.zambiaStatus ==0 || data.data.TopicList.zambiaStatus == false){
 				$scope.zambias = false;
 			}else{
 				$scope.zambias = true;
 			}
 			
 			console.log(data);
 		})
     }

     getTopicDetail(topicId);

 	 $scope.initTopicComment = function(){
 	 	var id = $scope.topicDetailList.id;
 	 	var comment = $scope.comment;

      if(comment == null || comment == ""){
       	 showAlert("请输入评论内容");
      }else{
            TopicService.initTopicComment(id,comment).then(function(data){
            
              showAlert(data.data.info);
              $scope.commentDetailList.push(data.data.CommentTopicInfo);
            
          })
      }
 	 }
     //alert
     function showAlert(info) {
       var alertPopup = $ionicPopup.alert({
       title: info
       });
       alertPopup.then(function(res) {
       
       });
     };

 	$scope.getTopicZamPeopleSave = function(id){
 	 	TopicService.getTopicZamPeopleSave(id).then(function(data){
 	 		console.log(data);
 	 		if($scope.zambias == false){
 	 			$scope.topicDetailList.zambias=parseInt($scope.topicDetailList.zambias)+1;
 	 			$scope.zambias = !$scope.zambias;
 	 		}else{
 	 			// $scope.topicDetailList.zambias=parseInt($scope.topicDetailList.zambias)-1;
 	 			// $scope.zambias = !$scope.zambias;
 	 		}
 	 	})
 	 }


 	 $ionicModal.fromTemplateUrl('../tpls/image-modal.html', {
      scope: $scope,
      animation: 'slide-in-up'
    }).then(function(modal) {
      $scope.modal = modal;
    });

    $scope.openModal = function() {
      $ionicSlideBoxDelegate.slide(0);
      $scope.modal.show();
    };

    $scope.closeModal = function() {
      $scope.modal.hide();
    };

    // Cleanup the modal when we're done with it!
    $scope.$on('$destroy', function() {
      $scope.modal.remove();
    });
    
   	$scope.next = function() {
      $ionicSlideBoxDelegate.next();
    };
  
    $scope.previous = function() {
      $ionicSlideBoxDelegate.previous();
    };
  
  	$scope.goToSlide = function(index) {
      $scope.modal.show();
      $ionicSlideBoxDelegate.slide(index);
    }
  
    $scope.slideChanged = function(index) {
      $scope.slideIndex = index;
    };
 	 
}])