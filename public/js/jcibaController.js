

angular.module('mainCtrl', [])
  
 //弹出窗口
  .controller('mainController', function($scope,$rootScope, $location, $http, Queryword, Queryroot,QuerySentence, CSRF_TOKEN, QUERY_WORD, $anchorScroll, $uibModal, $log) {
	  
	  
	$scope.items = ['item1', 'item2', 'item3'];

$scope.animationsEnabled = true;

$scope.open = function (size,word) {

    var modalInstance = $uibModal.open({
        animation: $scope.animationsEnabled,
        templateUrl: 'myModalContent.html',
        controller: 'ModalInstanceCtrl',
        size: size,
        resolve: {
            items: function () {
                return word;
            }
        }
    });

    modalInstance.result.then(function (selectedItem) {
        $scope.selected = selectedItem;
    }, function () {
        $log.info('Modal dismissed at: ' + new Date());
    });
};

  $scope.toggleAnimation = function () {
    $scope.animationsEnabled = !$scope.animationsEnabled;
  };
  
  
   //弹出窗口
   
	  
	  //a 标签跳转
	     $scope.scrollTo = function(id) {
      $location.hash(id);
      $anchorScroll();
   }
  
$scope.search = QUERY_WORD; //定义搜索高亮关键字
$scope.dbclickEvent = function() {

    $scope.selectedText =  $scope.getSelectionText();
   // do i do the function here to replace

}; 
  

$scope.mouseUpEvent = function() {

	if($scope.ismousedown){
		
		$scope.selectedText =  $scope.getSelectionText();
		$scope.ismousedown = false;
	}
}; 
$scope.mousedownEvent = function() {
	
    $scope.ismousedown = true;
   // do i do the function here to replace

}; 

    
   // do i do the function here to replace





$scope.getSelectionText = function(){
$scope.ismousedown = false;
// Predefine select and range
var sel = (document.selection && document.selection.createRange().text) ||
             (window.getSelection && window.getSelection().toString());
  if(sel){
$scope.frameShow=true;

  $scope.open("lg",sel);
  }

}

$scope.mouseleaveEvent = function(){
	$scope.frameShow=false;
}
   
	  
    // 持有新评论所有表单数据的对象
    $scope.commentData = {};

    // 调用显示加载图标的变量
	//播放单词
	$scope.playvoice = function($path){
		var audio = new Audio($path);
		audio.play();
	}

	var tippraise;
	$scope.tippraise =tippraise;
	
	// tips 点赞功能
	$scope.like =function($id){
		//alert($id);
		//console.info($scope.tipsid); 
		Queryroot.post($id).then(function (result) {  //正确请求成功时处理  

			//console.info(result); 
			$scope.tippraise =  result.data.data.praise;
		
			//console.info($scope.tippraise);
			

		}).catch(function (result) { //捕捉错误处理  
			console.info(result);  

		});  
	}
    $scope.loading = true;
//request word information
	var url = $location.url(); 
	var sValue=$location.absUrl().match(new RegExp("^(.*)/query/([a-z0-9\-]+)/?$"));
		 
	Queryword.post().then(function (result) {  //正确请求成功时处理  

			
			$scope.words = result.data.data;
			
			var tmp_star=new Array();
			for(var $i=1;$i<=result.data.data.level_star;$i++){
				tmp_star.push($i);
			}
			$scope.level_star = tmp_star;
			console.info($scope.words.root);  

		}).catch(function (result) { //捕捉错误处理  
			console.info(result);  

		});  

		
		//例句
		
		$scope.sentencespage=function(){

	
			$http({
          method: 'POST',
          url: '/api/sentence/',
          data: {  
				query:QUERY_WORD,
				page: $scope.currentPage
			},
        }).then(function (result) {  //正确请求成功时处理  

			
			$scope.sentences = result.data;
			//console.info(result.data);  
			
			 var tmp_array=new Array();
			for(var $i=1;$i<result.data.meta.pagination.total_pages;$i++){
				tmp_array.push($i);
			}
			
			
			//console.info(tmp_array);  
			$scope.sentencepages = tmp_array;
			

		}).catch(function (result) { //捕捉错误处理  
			console.info(result);  

		}); 
			
		}
		
		QuerySentence.post().then(function (result) {  //正确请求成功时处理  

			
			$scope.sentences = result.data;
			//console.info(result.data);  
			
			 var tmp_array=new Array();
			for(var $i=1;$i<result.data.meta.pagination.total_pages;$i++){
				tmp_array.push($i);
			}
			
			$scope.maxSize = result.data.meta.pagination.count;
			$scope.totalItems = result.data.meta.pagination.total;
            $scope.currentPage = result.data.meta.pagination.current_page;

			
			//console.info(tmp_array);  
			$scope.sentencepages = tmp_array;
			
			

		}).catch(function (result) { //捕捉错误处理  
			console.info(result);  

		}); 
		
  
  }).controller('cigenController', function($scope,$rootScope, $location, $http, rootQueryword) {
    // 持有新评论所有表单数据的对象
    $scope.commentData = {};
  
    // 调用显示加载图标的变量
    $scope.loading = true;
  
    // 先获取所有的评论，然后绑定它们到$scope.comments对象     // 使用服务中定义的函数
    // GET ALL COMMENTS ====================================================
	var url = $location.url(); 
	var sValue=$location.absUrl().match(new RegExp("^(.*)/query/([a-z0-9\-]+)/?$"));
		 
	
	

	rootQueryword.get().then(function (result) {  //正确请求成功时处理  

			
			$scope.roots = result.data.data;
			

		}).catch(function (result) { //捕捉错误处理  
			console.info(result);  

		});  

  
  }).controller('rootController', function($scope,$rootScope, $location, $http, QueryStarWords, WORD_STAR) {
    // 持有新评论所有表单数据的对象
    $scope.commentData = {};
  
    // 调用显示加载图标的变量
    $scope.loading = true;
  
    // 先获取所有的评论，然后绑定它们到$scope.comments对象     // 使用服务中定义的函数
    // GET ALL COMMENTS ====================================================
	var url = $location.url(); 
	var sValue=$location.absUrl().match(new RegExp("^(.*)/query/([a-z0-9\-]+)/?$"));
		 
	$scope.playvoice = function($path){
		var audio = new Audio($path);
		audio.play();
	}
	
$scope.starpages=function(){

	
			$http({
          method: 'POST',
          url: '/api/star/',
          data: {  
				star:WORD_STAR,
				page: $scope.currentPage,
				include: 'explain, voice,tip,level,root',
			},
        }).then(function (result) {  //正确请求成功时处理  

			
			$scope.words = result.data.data;
			$scope.pagination = result.data.meta.pagination;
			
			$scope.maxSize = $scope.pagination.count;
            $scope.totalItems = $scope.pagination.total;
            $scope.currentPage = $scope.pagination.current_page;
			
			

		}).catch(function (result) { //捕捉错误处理  
			console.info(result);  

		}); 
			
		}
		
	QueryStarWords.post().then(function (result) {  //正确请求成功时处理  

			
			 
			$scope.words = result.data.data;
			$scope.pagination = result.data.meta.pagination;
			
			$scope.maxSize = $scope.pagination.count;
            $scope.totalItems = $scope.pagination.total;
            $scope.currentPage = $scope.pagination.current_page;

			
			

		}).catch(function (result) { //捕捉错误处理  
			console.info(result);  

		});  

  
  }).controller('quciController', function($scope,$rootScope, $location, $http, $uibModal, $log) {
	  
	
$scope.mouseUpEvent = function() {


$scope.touchEvent =function(){
	
	alert("test");
}
	if($scope.ismousedown){
		
		$scope.selectedText =  $scope.getSelectionText();
		$scope.ismousedown = false;
	}
}; 
$scope.mousedownEvent = function() {
	//alert("aa");
    $scope.ismousedown = true;
   // do i do the function here to replace

}; 




$scope.getSelectionText = function(){
$scope.ismousedown = false;
// Predefine select and range
var sel = (document.selection && document.selection.createRange().text) ||
             (window.getSelection && window.getSelection().toString());
  if(sel){
$scope.frameShow=true;

  $scope.open("lg",sel);
  }

}

    //弹出窗口
 
	$scope.items = ['item1', 'item2', 'item3'];

$scope.animationsEnabled = true;

$scope.open = function (size,word) {

    var modalInstance = $uibModal.open({
        animation: $scope.animationsEnabled,
        templateUrl: 'myModalContent.html',
        controller: 'ModalInstanceCtrl',
		backdrop: 'false',
        size: size,
        resolve: {
            items: function () {
                return word;
            }
        }
    });

    modalInstance.result.then(function (selectedItem) {
        $scope.selected = selectedItem;
    }, function () {
        $log.info('Modal dismissed at: ' + new Date());
    });
};

  $scope.toggleAnimation = function () {
    $scope.animationsEnabled = !$scope.animationsEnabled;
  };
  
  
   //弹出窗口
   
  
  });
  
  