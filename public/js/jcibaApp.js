'use strict';



var app = angular.module('myApp', ['ngSanitize', 'mainCtrl', 'querywordService','ui.bootstrap','mgcrea.bootstrap.affix','ngAnimate','ngTouch']);



//自定义过滤器，前台输出HTML
app.filter('trust2Html', ['$sce',function($sce) {  
        return function(val) {  
            return $sce.trustAsHtml(val);   
        };  
    }])  


//自定义过滤器，高亮 关键字 前台输出HTML	
app.filter('highlight',['$sce',function($sce){
     return function(content,match) {
		 
             var regex = new RegExp(match,"g");
            var heightlight = content.replace(match,'<b style="color:red">'+match+'</b>');
            return $sce.trustAsHtml(heightlight);
      }
}])        





// Please note that $modalInstance represents a modal window (instance)   dependency.
// It is not the same as the $uibModal service used above.

app.controller('ModalInstanceCtrl', function ($scope, $uibModalInstance, items, $http) {

  $scope.word = items;
$http({
          method: 'POST',
         url: '/api/word/',
         // headers: { 'X-CSRF-TOKEN' : CSRF_TOKEN },  //需要传入X-CSRF-TOKEN 才可以post 数据
          data: {  
				word: items,
				include: 'explain, voice,tip,level,root',
			},
        }).then(function (result) {  //正确请求成功时处理  

			if(result.data.data==undefined ){
				$http({
				  method: 'POST',
				 url: '/api/sentenceSearch/',
				 // headers: { 'X-CSRF-TOKEN' : CSRF_TOKEN },  //需要传入X-CSRF-TOKEN 才可以post 数据
				  data: {  
						query: items,
					},
				}).then(function (result) {  //正确请求成功时处理  
		
					$scope.sentences = result.data;
					//console.info(result.data);  
					
					 var tmp_array=new Array();
					for(var $i=1;$i<result.data.meta.pagination.total_pages;$i++){
						tmp_array.push($i);
					}
							
					

				}).catch(function (result) { //捕捉错误处理  
					console.info(result);  

				}); 
			}else{
				
				$scope.words = result.data.data;
			
				var tmp_star=new Array();
				for(var $i=1;$i<=result.data.data.level_star;$i++){
					tmp_star.push($i);
				}
				$scope.level_star = tmp_star;
				console.info($scope.words.root);  
			}
			
			
			

		}).catch(function (result) { //捕捉错误处理  
			console.info(result);  

		}); 

$scope.playvoice = function($path){
		var audio = new Audio($path);
		audio.play();
	}
	
	
$scope.queryword =function(){
	
	$scope.sentences ="";
	$http({
          method: 'POST',
         url: '/api/word/',
         // headers: { 'X-CSRF-TOKEN' : CSRF_TOKEN },  //需要传入X-CSRF-TOKEN 才可以post 数据
          data: {  
				word: $scope.query,
				include: 'explain, voice,tip,level,root',
			},
        }).then(function (result) {  //正确请求成功时处理  
//alert(result);
			
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
}		
  $scope.ok = function () {
    $uibModalInstance.close($scope.selected.item);
  };

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };
});