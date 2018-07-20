angular.module('slb.services', []);


angular.module('slb.services').factory('UserService',['$http','$q','$location',function($http,$q,$location){
	var service={};
		service.currentUser = user;
		service.loginModal = {};
    	service.checkWeChatAuth = checkWeChatAuth;
    	service.setCurrentUser = setCurrentUser;
    	return service;

    function checkWeChatAuth(){
    	return $http({
    		method:'POST',
    		url:'/index.php/Home/Index/checkWeChatAuth',
    		data:{
    			redirectUrl : $location.absUrl()
    		}
    	}).then(function(data){
    		return data;
    	})
    }

    function setCurrentUser(user){
    	var d = $q.defer();

    	if(user){
    		service.currentUser = user;
    		d.resolve(user);
    	}else{
    		d.reject('user not definded');
    	}
    }

}])
//首页
angular.module('slb.services').factory('IndexService',['$http',function($http){
	var service={};
    
        service.getIndex = getIndex;

    return service;

    function getIndex(){
    	return $http({
    		method: 'POST',
    		url: '/index.php/Home/Index/getIndex',

    	}).then(function(data){
    		return data;
    	})
    }

}])

//视频
angular.module('slb.services').factory('VideoService',['$http',function($http){
	var service = {};

	    service.getVideo = getVideo;
	    service.getVideoDetail = getVideoDetail;
	    service.initVideoComment = initVideoComment;
	    service.getVideoCollectionPeopleSave = getVideoCollectionPeopleSave;
	    service.getVideoZamPeopleSave = getVideoZamPeopleSave;
    
     return service;

	    function getVideo(page,pageSize){
	    	return $http({
	    		method: 'POST',
	    		url: '/index.php/Home/Video/getVideoList',
	    		data:{
	    			page:page,
	    			pageSize:pageSize
	    		}
	    	}).then(function(data){
	    		return data;
	    	})
	    }

	    function getVideoDetail(id){
	    	return $http({
	    		method:'POST',
	    		url: '/index.php/Home/Video/getVideoDetails',
	    		data:{
	    			'videoID' : id
	    		}
	    	}).then(function(data){
	    		return data;
	    	})
	    }

	    function initVideoComment(id,comment){
	    	return $http({
	    		method: 'POST',
	    		url: '/index.php/Home/Video/getVideoCommentAdd',
	    		data:{
	    			video_id : id,
	    			content  : comment
	    		}
	    	}).then(function(data){
	    		return data;
	    	})
	    }

	    function getVideoZamPeopleSave(id){
	    	return $http({
	    		method: 'POST',
	    		url:'/index.php/Home/Video/getVideoZamPeopleSave',
	    		data:{
	    			videoID : id
	    		}
	    	}).then(function(data){
	    		return data;
	    	})
	    }

	    function getVideoCollectionPeopleSave(id){
	    	return $http({
	    		method: 'POST',
	    		url:'/index.php/Home/Video/getVideoCollectionPeopleSave',
	    		data:{
	    			videoID : id
	    		}
	    	}).then(function(data){
	    		return data;
	    	})
	    }
}])

//上传图片
angular.module('slb.services').factory('fileReader', ["$q", "$log", function($q, $log){
  var onLoad = function(reader, deferred, scope) {
    return function () {
      scope.$apply(function () {
        deferred.resolve(reader.result);
      });
    };
  };
  var onError = function (reader, deferred, scope) {
    return function () {
      scope.$apply(function () {
        deferred.reject(reader.result);
      });
    };
  };
  var getReader = function(deferred, scope) {
    var reader = new FileReader();
    reader.onload = onLoad(reader, deferred, scope);
    reader.onerror = onError(reader, deferred, scope);
    return reader;
  };
  var readAsDataURL = function (file, scope) {
    var deferred = $q.defer();
    var reader = getReader(deferred, scope);        
    reader.readAsDataURL(file);
    return deferred.promise;
  };
  return {
    readAsDataUrl: readAsDataURL 
  };
}])


//话题
angular.module('slb.services').factory('TopicService',['$http',function($http){
	var service = {};

	    service.getTopic = getTopic;
	    service.getTopicDetail = getTopicDetail;
	    service.initTopicComment = initTopicComment;
	    service.getTopicZamPeopleSave = getTopicZamPeopleSave;
	    service.getTopicCollectionPeopleSave = getTopicCollectionPeopleSave;
    
     return service;

	    function getTopic(page,pageSize){
	    	return $http({
	    		method: 'POST',
	    		url: '/index.php/Home/Topic/getTopicList',
	    		data:{
	    			page:page,
	    			pageSize:pageSize
	    		}
	    	}).then(function(data){
	    		return data;
	    	})
	    }

	    function getTopicDetail(id){
	    	return $http({
    		method: 'POST',
    		url: '/index.php/Home/Topic/getTopicDetails',
    		data:{
    			topicID : id
    		}

	    	}).then(function(data){
	    		return data;
	    	})
	    }

	    function initTopicComment(id,comment){
	    	return $http({
	    		method: 'POST',
	    		url: '/index.php/Home/Topic/getTopicCommentAdd',
	    		data:{
	    			topic_id : id,
	    			content  : comment
	    		}
	    	}).then(function(data){
	    		return data;
	    	})
	    }

	    function getTopicZamPeopleSave(id){
	    	return $http({
	    		method: 'POST',
	    		url: '/index.php/Home/Topic/getTopicZamPeopleSave',
	    		data:{
	    			topicID : id
	    		}
	    	}).then(function(data){
	    		return data;
	    	})
	    }

	    function getTopicCollectionPeopleSave(id){
	    	return $http({
	    		method: 'POST',
	    		url: '/index.php/Home/Topic/getTopicCollectionPeopleSave',
	    		data:{
	    			topicID : id
	    		}
	    	}).then(function(data){
	    		return data;
	    	})
	    }
}])

//我的
angular.module('slb.services').factory('MindService',['$http',function($http){
	var service = {};
		service.mindIndex = mindIndex;
		service.getMyWacthed = getMyWacthed;
		service.getMyCollection = getMyCollection;
		service.getMyTopic = getMyTopic;
		service.getDelete = getDelete;
		service.deleteWatchedActivity = deleteWatchedActivity;
		service.deleteCollectionActivity = deleteCollectionActivity;
		service.getDeleteVideoCollection = getDeleteVideoCollection;
		service.getDeleteTopicCollection = getDeleteTopicCollection;

	return service;	

		function mindIndex(){
			return $http({
				method:'POST',
				url:"/index.php/Home/User/getUserInfo",
			}).then(function(data){
				return data;
			})
		}

		function getMyWacthed(page,pageSize){
			return $http({
				method:'POST',
				url:"/index.php/Home/User/getUserFootprintList",
				data:{ 
					page : page,
					pageSize : pageSize
				}
			}).then(function(data){
				return data;
			})
		}

		function getMyCollection(page,pageSize){
			return $http({
				method:'POST',
				url:"/index.php/Home/User/getUserCollectionList",
				data:{
					page:page,
					pageSize:pageSize,
				}
			}).then(function(data){
				return data;
			})
		}

		function getMyTopic(apage,pageSize){
			return $http({
				method:'POST',
				url:"/index.php/Home/User/getUserTopicList",
				data:{
					page : apage,
					pageSize : pageSize,
				}
			}).then(function(data){
				return data;

			})
		}

		function getDelete(aId,aTableName){
	    	return $http({
	    		method: 'POST',
	    		url: '/index.php/Home/User/getUserDelete',
	    		data:{
	    			id : aId,
	    			tableName  : aTableName,
	    		}
	    	}).then(function(data){
	    		return data;
	    	})
	    }

	    function getDeleteVideoCollection(aId,aTableName,video_id){
	    	return $http({
	    		method: 'POST',
	    		url: '/index.php/Home/User/getUserDelete',
	    		data:{
	    			id : aId,
	    			tableName  : aTableName,
	    			video_id : video_id
	    		}
	    	}).then(function(data){
	    		return data;
	    	})
	    }

	    function getDeleteTopicCollection(aId,aTableName,topic_id){
	    	return $http({
	    		method: 'POST',
	    		url: '/index.php/Home/User/getUserDelete',
	    		data:{
	    			id : aId,
	    			tableName  : aTableName,
	    			topic_id : topic_id
	    		}
	    	}).then(function(data){
	    		return data;
	    	})
	    }

	    // //发布话题
	    // function createTopic(title,content){
	    // 	return $http({
	    // 		method: 'POST',
	    // 		url: '/index.php/Home/User/getUserTopicAdd',
	    // 		data:{
	    // 			title : title,
	    // 			content  : content
	    // 		}
	    // 	}).then(function(data){
	    // 		return data;
	    // 	})
	    // }

		function deleteWatchedActivity(activity_id,id){
			return $http({
				method:'POST',
				url:'/index.php/Home/User/getUserDelete',
				data:{
					activity_id : activity_id,
					id : id,
					tableName : 'FootprintActivity'

				}
			}).then(function(data){
				return data;
			})
		}

		function deleteCollectionActivity(activity_id,id){
			return $http({
				method:'POST',
				url:'/index.php/Home/User/getUserDelete',
				data:{
					activity_id : activity_id,
					id : id, 
					tableName : 'CollectionActivity'

				}
			}).then(function(data){
				return data;
			})
		}
}])

angular.module('slb.services').factory('CreateTopicService',["$q",'$http',function($q,$http){
	var service = {};
		service.createTopic = createTopic;
		// service.sendImg = sendImg
	return service;

		// function sendImg(files){
		// 	var d = $q.defer();
		// 	var totalCount = files.length;
		// 	var successCount = 0;
		// 	var processCount = 0;
		// 	angular.forEach(files, function(file){
		// 		$http({
		//     		method: 'POST',
		//     		url: '/index.php/Home/User/getUserTopicAdd',
		//     		data:{
		//     			images : file
		//     		}
		//     	}).then(function(data){
		//     		processCount++;
		//     		if(data.data.status == 1){
		//     			successCount++;
		//     		}
		//     		if(processCount == totalCount){
		// 				if(successCount == totalCount){
		// 					d.resolve(files);
		// 				}else{
		// 					d.reject("files uploaded unsuccessfully");
		// 				}
		// 				return d.promise;
						
		// 			}
		//     	})
		// 	})

		// }	

	    //发布话题
	    function createTopic(images,title,content){
	    	return $http({
	    		method: 'POST',
	    		url: '/index.php/Home/User/getUserTopicAdd',
	    		data:{
	    			images :images,
	    			title : title,
	    			content  : content
	    		}
	    	}).then(function(data){
	    		return data;
	    	})
	    }

}])

//活动
angular.module('slb.services').factory('ActivityService',['$http',function($http){
	var service = {};
		service.LoadActicityList = LoadActicityList,
		service.loadActicityinsideData = loadActicityinsideData
		service.getActivityUserAdd = getActivityUserAdd
		service.getActivityZamPeopleSave = getActivityZamPeopleSave
		service.getActiviryCollectionPeopleSave = getActiviryCollectionPeopleSave
		service.addActivity = addActivity
	return service;

	function LoadActicityList(page,pageSize){
		return $http({
	    		method: 'POST',
				url: '/index.php/Home/Activity/getActivityList',
				data:{
					page:page,
					pageSize:pageSize
				}
	    	}).then(function(data){
	    		return data;
	    	})
	}

	function loadActicityinsideData(id){
		return $http({
			method:'POST',
			url: '/index.php/Home/Activity/getActivityDetails',
			data:{
				activityID:id
			}
		}).then(function(data){
			return data;
		})
	}

	function getActivityUserAdd(id){
		return $http({
			method:'POST',
			url:'/index.php/Home/Activity/getActivityUserAdd',
			data:{
				activityID:id
			}
		}).then(function(data){
			return data;
		})
	}

	function getActivityZamPeopleSave(id){
		return $http({
			method:'POST',
			url:'/index.php/Home/Activity/getActivityZamPeopleSave',
			data:{
				activityID:id
			}
		}).then(function(data){
			return data;
		})
	}

	function getActiviryCollectionPeopleSave(id){
		return $http({
			method:'POST',
			url:'/index.php/Home/Activity/getActivityCollectionPeopleSave',
			data:{
				activityID:id
			}
		}).then(function(data){
			return data;
		})
	}

	function addActivity(title,start_time,end_time,deadline,place,total_enrollment,material,process,content){
		return $http({
			method:'POST',
			url:'/index.php/Home/User/getUserActivityAdd',
			data:{
				title :title,
				start_time:start_time,
				end_time:end_time,
				deadline:deadline,
				place :place,
				total_enrollment:total_enrollment,
				material:material,
				process:process,
				content:content
			}
		}).then(function(data){
			return data;
		})
	}
}])

//我发布活动
angular.module('slb.services').factory('mindPostActivityService',['$http',function($http){
	var service = {};
		service.loadData = loadData
	return service;

	function loadData(page,pageSize){
		return $http({
	    		method: 'POST',
				url: '/index.php/Home/User/getActivityUserList',
				data:{
					page : page,
					pageSize : pageSize
				}
	    	}).then(function(data){
	    		return data;
	    	})
	}
}])

//我参与/发起活动
angular.module('slb.services').factory('MindJoinAndPostActivityService',['$http',function($http){
	var service = {};
		service.loadJoinData = loadJoinData
		service.loadPostData = loadPostData
	return service;

	function loadJoinData(page,pageSize){
		return $http({
    		method: 'POST',
			url: '/index.php/Home/User/getUserActivityList',
			data:{
				page : page,
				pageSize : pageSize
			}
	    	}).then(function(data){
	    		return data;
	    	})
	}

	function loadPostData(page,pageSize){
		return $http({
    		method: 'POST',
			url: '/index.php/Home/User/getActivityUserList',
			data:{
				pageSize:pageSize,
				page:page
			}
	    	}).then(function(data){
	    		return data;
	    	})
	}

}])
//登录
angular.module('slb.services').factory('UserService',['$http',function($http){
	var service = {};
		service.currentUser = {};
		service.login = login
		service.checkAuth = checkAuth
		service.setCurrentUser = setCurrentUser
	return service;

	function login(userName,psw){
		return $http({
    		method: 'POST',
			url: '/index.php/Home/User/getUserActivityList',
			data:{
				userName : userName,
				psw : psw
			}
	    	}).then(function(data){
	    		return data;
	    	})
	}

	function checkAuth(){
		return $http({
			url:'',
		}).then(function(data){
			return data.data;
		})
	}

	function setCurrentUser(user, broadcast){
		var d = $q.defer();
		console.log(user)
		if(user){
			service.currentUser = user;
			updateLocalResume(user.resume);
			if(broadcast)
				$rootScope.$broadcast('USER_SIGNED_IN', {user : user, toState : service.loginModal.toState });
			d.resolve(user);
		}else{
			d.reject('user not defined');
		}

		return d.promise;
	}

	function getCurrentUser(){
		return service.currentUser
	}
}])