

var app = angular.module('myApp', ['ngMaterial', 'ngMessages','ngTouch']);

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
app.config(function($mdIconProvider) {
    $mdIconProvider
      .iconSet("call", '/img/icons/sets/communication-icons.svg', 24)
      .iconSet("social", '/img/icons/sets/social-icons.svg', 24);
  })
  
app.controller('quciController', function($scope,$rootScope, $location, $http, $log, $mdDialog) {
	  

// 划词开始
$scope.mouseUpEvent = function(ev) {

	if($scope.ismousedown){
		
		$scope.selectedText =  $scope.getSelectionText(ev);
		$scope.ismousedown = false;
	}
}; 
$scope.mousedownEvent = function(ev) {
	//alert("aa");
    $scope.ismousedown = true;
   // do i do the function here to replace

}; 

$scope.getSelectionText = function(ev){
$scope.ismousedown = false;
// Predefine select and range
var sel = (document.selection && document.selection.createRange().text) ||
             (window.getSelection && window.getSelection().toString());
  if(sel){
	  $rootScope.selectword =sel;
$scope.frameShow=true;
$scope.showTabDialog(ev);
//alert(sel);
  //$scope.open("lg",sel);
  }else{
	  $scope.selectword ="";
  }

}


 $scope.showTabDialog = function(ev) {
    $mdDialog.show({
      controller: DialogController,
      templateUrl: 'tabDialog.tmpl.html',
      parent: angular.element(document.body),
	  targetEvent: ev,
      clickOutsideToClose:true
    })
        .then(function(answer) {
          $scope.status = 'You said the information was "' + answer + '".';
        }, function() {
          $scope.status = 'You cancelled the dialog.';
        });
  };
  
  
 function DialogController($scope, $mdDialog) {
	
var items = $rootScope.selectword;

$http({
          method: 'POST',
         url: '/api/word/',
         // headers: { 'X-CSRF-TOKEN' : CSRF_TOKEN },  //需要传入X-CSRF-TOKEN 才可以post 数据
          data: {  
				word: items,
				include: 'explain, voice,tip,level,root',
			},
        }).then(function (result) {  //正确请求成功时处理  
			console.info(result.data);  
			
			
			$scope.words = result.data.data;
			
			var tmp_star=new Array();
			for(var $i=1;$i<=result.data.data.level_star;$i++){
					tmp_star.push($i);
			}
			$scope.level_star = tmp_star;
			//console.info($scope.words.root);  

		}).catch(function (result) { //捕捉错误处理  

			console.info(result);  

		}); 

$scope.playvoice = function($path){
		var audio = new Audio($path);
		audio.play();
	}
	
    $scope.hide = function() {
      $mdDialog.hide();
    };

    $scope.cancel = function() {
      $mdDialog.cancel();
    };

    $scope.answer = function(answer) {
      $mdDialog.hide(answer);
    };
  } 
// 划词结束

  
  }).controller('BasicDemoCtrl', function DemoCtrl($mdDialog) {
    var originatorEv;

    this.openMenu = function($mdMenu, ev) {
      originatorEv = ev;
      $mdMenu.open(ev);
    };

    this.notificationsEnabled = true;
    this.toggleNotifications = function() {
      this.notificationsEnabled = !this.notificationsEnabled;
    };

    this.redial = function() {
      $mdDialog.show(
        $mdDialog.alert()
          .targetEvent(originatorEv)
          .clickOutsideToClose(true)
          .parent('body')
          .title('Suddenly, a redial')
          .textContent('You just called a friend; who told you the most amazing story. Have a cookie!')
          .ok('That was easy')
      );

      originatorEv = null;
    };

    this.checkVoicemail = function() {
      // This never happens.
    };
  });