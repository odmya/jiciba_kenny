<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
         <meta charset="UTF-8" />
         <title>jciba.com</title>
    <script src="js/phaser.min.js"></script>
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>


	<script>
var score=1;

wx.config({!! $app->jssdk->buildConfig(array('onMenuShareTimeline','onMenuShareAppMessage'), false) !!});

// 分享朋友圈
var share_config = {
     "share": {
        "imgUrl": 'https://www.jciba.cn/images/words.jpg', // 分享图标
        "desc": '不服来战', // 分享描述
        "title": '挑战三年级单词', // 分享标题
        "link": 'https://www.jciba.cn/game',
        "success":function(){//分享成功后的回调函数
        },
        'cancel': function () {
            // 用户取消分享后执行的回调函数
        }
    }
};
    wx.ready(function () {
    wx.onMenuShareAppMessage(share_config.share);//分享给好友
    wx.onMenuShareTimeline(share_config.share);//分享到朋友圈
});


var words_array = [
{
 name: 'door',
 explain: '门',
 voice: 'voice/word/door_1.mp3'
},
{
 name: 'window',
 explain: '窗户',
 voice: 'voice/word/window_1.mp3'
}
, {
 name: 'open',
 explain: '（打）开',
 voice: 'voice/word/open_0.mp3'
}

, {
 name: 'close',
 explain: '关',
 voice: 'voice/word/close_0.mp3'
}

, {
 name: 'pupil',
 explain: '学生',
 voice: 'voice/word/pupil_0.mp3'
}


, {
 name: 'mum',
 explain: '妈妈',
 voice: 'voice/word/mum_1.mp3'
}

, {
 name: 'dad',
 explain: '爸爸',
 voice: 'voice/word/dad_1.mp3'
}


, {
 name: 'friend',
 explain: '朋友',
 voice: 'voice/word/friend_1.mp3'
}
, {
 name: 'read',
 explain: '阅读',
 voice: 'voice/word/read_1.mp3'
}
, {
 name: 'write',
 explain: '写',
 voice: 'voice/word/write_1.mp3'
}
, {
 name: 'jump',
 explain: '跳',
 voice: 'voice/word/jump_1.mp3'
}
, {
 name: 'run',
 explain: '跑',
 voice: 'voice/word/run_1.mp3'
}
, {
 name: 'rice',
 explain: '大米',
 voice: 'voice/word/rice_1.mp3'
}, {
 name: 'bread',
 explain: '面包',
 voice: 'voice/word/bread_1.mp3'
}, {
 name: 'noodle',
 explain: '面条',
 voice: 'voice/word/noodle_1.mp3'
}
, {
 name: 'food',
 explain: '食物',
 voice: 'voice/word/food_1.mp3'
}

, {
 name: 'milk',
 explain: '牛奶',
 voice: 'voice/word/milk_1.mp3'
}
, {
 name: 'water',
 explain: '水',
 voice: 'voice/word/water_1.mp3'
}

, {
 name: 'box',
 explain: '盒子',
 voice: 'voice/word/box_1.mp3'
}


	  ];
	  var words;

	  //定义字母表

	  var alphabet = new Array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
	  var select_alphabet = new Array();

	</script>


	<script>

// 打乱数组
function randomSort(a, b) {
return Math.random() > 0.5 ? -1 : 1;
}


//words_array.sort(randomsort);


var game = new Phaser.Game(400, 600, Phaser.CANVAS, 'game');
var audio = document.createElement('audio');
var source = document.createElement('source');

document.addEventListener("WeixinJSBridgeReady", function () {
              audio.play();
      }, false);



source.type = "audio/mpeg";
source.type = "audio/mpeg";
source.src = "";
source.autoplay = "autoplay";
source.controls = "controls";
audio.appendChild(source);

var top;
var ground;
var test_name;
var top_start;
var rounded;
var sprite;
var miss_words=0;
var miss_array = new Array();
var crrent_arr = new Array();

var answer_arr = new Array();

var user_list = new Array();


var crash; // 爆炸音效
var explain1;
var explain2;
var explain3;

var animate;
var current_word;

var explain_arr = [];
var fall =1;
var falltime =6000;

var txt_score;
var txt_wrong;
var delete_sprite;
game.together  = {};

game.together.boot = function() {

  this.preload = function() {

     game.load.image('firstaid','assets/firstaid.png');

   game.load.image('ground','assets/platform.png');
   game.load.image('wall','assets/wall.jpg');
   game.load.image('grass','assets/grass.jpg');
   game.load.image('ballsky','assets/ballsky.jpg');

   game.load.spritesheet('explosion','assets/explosion.png',60, 52, 5);

   game.load.audio('crash', 'assets/BOMB.mp3');

   game.load.image('whitejian', 'assets/whitejian.png');
    game.load.image('greenjian', 'assets/greenjian.png');



    if(typeof(GAME) !== "undefined") {
      this.load.baseURL = GAME + "/";
    }
    if(!game.device.desktop){
      this.scale.scaleMode = Phaser.ScaleManager.EXACT_FIT;
      this.scale.forcePortrait = true;
      this.scale.refresh();

    }

	//alert("test1232");

    //game.load.image('loading', 'assets/preloader.gif');
  };
  this.create = function() {
    //game.state.start('preload');
    /*
var user_object = new object();
user_object.name = {{ session('wechat.oauth_user')->name}};

user_object.openid = {{ session('wechat.oauth_user')->id}};
user_object.avatar = {{ session('wechat.oauth_user')->avatar}};

*/


	words = words_array.concat();
	words.sort(randomSort);
	miss_words=0;
	score=1;

	falltime =6000;

	 this.textStyle = {
      font: "24px Arial",
      fill: '#000000',
      wordWrap: true,
      wordWrapWidth: game.width - 80
    };

	var game_start = game.add.text(50, game.height/2, "单词听写！点击开始", this.textStyle);
	audio.pause();




	game.physics.arcade.enable(game_start);

	game_start.inputEnabled = true;

	game_start.events.onInputDown.add(function(){game.state.start('main');}, this);

	game.stage.backgroundColor = "#FFFFFF";
	//game.state.start('boot2');
	//alert("test2");
  };


};



function shift_words(ground,sprite){

sprite.y = top_start.y  + top_start.height;
var tmp_txt =words.shift();
test_name.setText(tmp_txt.name);

	//source.src = tmp_txt.voice;

	audio.play();
	audioAutoPlay();


console.log(words);
//alert("test");

}

function delete_word(sprite){

  for (var i=0;i< answer_arr.length;i++){
    var alphabet = answer_arr[i].alphabet;
    var x = answer_arr[i].x;
    var y = answer_arr[i].y;

    var explain1 = game.add.text(10, 10, alphabet, this.textStyle);

  var sprite1 = game.add.sprite(x, y, "greenjian");


    var rounded1 = game.make.graphics(0, 0);

    rounded1.beginFill(0xa0e75a);
    rounded1.drawRoundedRect(-2, -2, 30, explain1. height+10, 4);

    rounded1.endFill();

    sprite1.addChild(rounded1);
    sprite1.addChild(explain1);
    sprite1.alphabet = alphabet;

    sprite1.inputEnabled = true;
   // sprite1.input.enableDrag();

    sprite1.events.onInputDown.add(oncheck, this);

  }

  for (var i=0;i< answer_arr.length;i++){
		crrent_arr[i].getChildAt(1).setText("");
	}

  answer_arr = new Array();


}
game.together.main = function() {

  this.preload = function() {



  };
  this.update = function() {
    //console.log(answer_arr);
	//game.physics.arcade.collide(ground, sprite, shift_words);
	//game.physics.arcade.collide(ground, rounded, shift_words);
  this.textStyle = {
     font: "14px Arial",
     fill: '#000000',
     wordWrap: true,
     wordWrapWidth: game.width - 80
   };


txt_score.setText("第: " + score + "关");
	for (var i=0;i< answer_arr.length;i++){
		crrent_arr[i].getChildAt(1).setText(answer_arr[i].alphabet);
	}
  if(answer_arr.length>0){

    if (typeof delete_sprite == "undefined"){

      delete_sprite = game.add.text(10 + crrent_arr.length *35, game.height/2, "修改", this.textStyle);
      delete_sprite.inputEnabled = true;
      delete_sprite.events.onInputDown.add(delete_word, this);

    }
  }else{
  //console.log(delete_sprite);
    if (typeof delete_sprite !== "undefined"){
      delete_sprite.destroy();
      delete_sprite = undefined;
    }
  }


	if(answer_arr.length == current_word.name.length){
    var correct_answer="";
    for (var i=0;i< answer_arr.length;i++){
      correct_answer +=answer_arr[i].alphabet;
    }


		if(correct_answer.toLowerCase() ==current_word.name.toLowerCase()){



			for (var i=0;i< crrent_arr.length;i++){
				crrent_arr[i].destroy();
			}

			for (var i=0;i< explain_arr.length;i++){
				explain_arr[i].destroy();
			}

			crrent_arr = new Array();
			select_alphabet  = new Array();
			explain_arr = new Array();
			answer_arr = new Array();


		}else{
			miss_array.push(current_word);
      for (var i=0;i< crrent_arr.length;i++){
				crrent_arr[i].destroy();
			}

			for (var i=0;i< explain_arr.length;i++){
				explain_arr[i].destroy();
			}

			crrent_arr = new Array();
			select_alphabet  = new Array();
			explain_arr = new Array();
			answer_arr = new Array();
			//game.state.start('over')

			}

      if(miss_array.length>=1){

        game.state.start('over')
      }else{

        if(words.length ==0){
      	// fall = 0;

      	 game.state.start('over')
      	}

        current_word =words.shift();
      tips_zh.setText("提示中文翻译");
			audio.src = current_word.voice;
		audio.play();
		audioAutoPlay();
		score +=1;
			for (var i=0;i< current_word.name.length;i++)
			{
				explain1 = game.add.text(10, 10, "", this.textStyle);

				sprite1 = game.add.sprite(10 + i*35, game.height/2, "greenjian");

				rounded1 = game.make.graphics(0, 0);

				rounded1.beginFill(0xa0e75a);
				rounded1.drawRoundedRect(-2, -2, 30, explain1. height+10, 4);

				rounded1.endFill();

				sprite1.addChild(rounded1);
				sprite1.addChild(explain1);
				sprite1.alphabet ="";


				crrent_arr.push(sprite1);
			}

			for (var i=0;i< current_word.name.length;i++)
			{
				select_alphabet.push(current_word.name[i]);
			}

			alphabet.sort(randomSort);

			for (var i=0;i< (16-current_word.name.length);i++)
					{
						select_alphabet.push(alphabet[i]);
					}

			//console.log(select_alphabet);
			//console.log(current_word);

			select_alphabet.sort(randomSort);
			for (var i=0;i< select_alphabet.length;i++)
					{
						explain1 = game.add.text(10, 10, select_alphabet[i], this.textStyle);

						if(i>=8){
							sprite1 = game.add.sprite(10 + (i-8)*50, game.height  -90, "greenjian");
						}else{
							sprite1 = game.add.sprite(10 + i*50, game.height  -50, "greenjian");
						}


						rounded1 = game.make.graphics(0, 0);

						rounded1.beginFill(0xa0e75a);
						rounded1.drawRoundedRect(-2, -2, 30, explain1. height+10, 4);

						rounded1.endFill();

						sprite1.addChild(rounded1);
						sprite1.addChild(explain1);
						sprite1.alphabet = select_alphabet[i];

						sprite1.inputEnabled = true;
				   // sprite1.input.enableDrag();

						sprite1.events.onInputDown.add(oncheck, this);


						explain_arr.push(sprite1);
					}


      }



	}

	//console.log(answer_arr.length);
	//console.log(current_word.length);
	};
  this.create = function() {
  //console.log(video_source);
    //game.state.start('preload');
	ground = game.add.sprite(0, game.world.height - 224, 'grass');

	crash = game.add.audio('crash', 10, false);

	game.physics.startSystem(Phaser.Physics.ARCADE);
	game.physics.arcade.enable(ground);

	top_start = game.add.sprite(0, -400, 'wall');
	//top_start.scale.setTo(2,10);
	 this.textStyle = {
      font: "14px Arial",
      fill: '#000000',
      wordWrap: true,
      wordWrapWidth: game.width - 80
    };

	//var game_start = game.add.text(game.width/2 -20, game.height/2, "游戏大餐开始", this.textStyle);
	txt_score = game.add.text(0, 20, "关卡: " + score);

	//txt_wrong = game.add.text(0, 50, "Wrong: 0", this.textStyle);


	current_word =words.shift();



	for (var i=0;i< current_word.name.length;i++)
			{
				explain1 = game.add.text(10, 10, "", this.textStyle);

				sprite1 = game.add.sprite(10 + i*35, game.height/2, "greenjian");

				rounded1 = game.make.graphics(0, 0);

				rounded1.beginFill(0xa0e75a);
				rounded1.drawRoundedRect(-2, -2, 30, explain1. height+10, 4);

				rounded1.endFill();

				sprite1.addChild(rounded1);
				sprite1.addChild(explain1);
				sprite1.alphabet ="";


				crrent_arr.push(sprite1);
			}

			tips = game.add.text(50, game.height/2 +50, "点击重新播放", this.textStyle);

			tips.inputEnabled = true;
		   // sprite1.input.enableDrag();

				tips.events.onInputDown.add(playagain, this);

        tips_zh = game.add.text(50, game.height/2 -20, "提示中文翻译", this.textStyle);
        tips_zh.inputEnabled = true;
  		   // sprite1.input.enableDrag();

  				tips_zh.events.onInputDown.add(transzh, this);
			//console.log(current_word);

			//console.log(crrent_arr);



	//document.getElementById('idmp3').src = tmp_txt.voice;
	//var mp3 = document.getElementById('video1');
	//var video_source = document.getElementById('video_source');

	//mp3.src = tmp_txt.voice;

	//mp3.play();
	//console.log(video_source);
	audio.src = current_word.voice;
audioAutoPlay();
	audio.play();
	//alert("test");


	//var words_explain = game.add.group();


	for (var i=0;i< current_word.name.length;i++)
			{
				select_alphabet.push(current_word.name[i]);
			}

	alphabet.sort(randomSort);

	for (var i=0;i< (16-current_word.name.length);i++)
			{
				select_alphabet.push(alphabet[i]);
			}

	//console.log(select_alphabet);
	//console.log(current_word);

	select_alphabet.sort(randomSort);
	for (var i=0;i< select_alphabet.length;i++)
			{
				explain1 = game.add.text(10, 10, select_alphabet[i], this.textStyle);

				if(i>=8){
					sprite1 = game.add.sprite(10 + (i-8)*50, game.height  -90, "greenjian");
				}else{
					sprite1 = game.add.sprite(10 + i*50, game.height  -50, "greenjian");
				}


				rounded1 = game.make.graphics(0, 0);

				rounded1.beginFill(0xa0e75a);
				rounded1.drawRoundedRect(-2, -2, 30, explain1. height+10, 4);

				rounded1.endFill();

				sprite1.addChild(rounded1);
				sprite1.addChild(explain1);
				sprite1.alphabet = select_alphabet[i];

				sprite1.inputEnabled = true;
		   // sprite1.input.enableDrag();

				sprite1.events.onInputDown.add(oncheck, this);


				explain_arr.push(sprite1);
			}



	explain_arr.sort(randomSort);
		//console.log(explain_arr);

		//var item1 = words_array[Math.floor(Math.random()*words_array.length)];


	//animate = game.add.tween(sprite).to({y: ground.y }, falltime, Phaser.Easing.Linear.None, true);


	game.stage.backgroundColor = "#f6f6f6";
	//game.state.start('boot2');
	//alert("test2");
  };


};


game.together.over = function() {

this.preload = function() {


}

this.create = function() {


	crrent_arr = new Array();
			select_alphabet  = new Array();
			explain_arr = new Array();
			current_word =words.shift();

this.textStyle = {
      font: "16px Arial",
      fill: '#000000',
      wordWrap: true,
      wordWrapWidth: game.width - 80
    };
this.errorStyle = {
      font: "14px Arial",
      fill: '#FF3030',
      wordWrap: true,
      wordWrapWidth: game.width - 80
    };

	var score_txt = game.add.text(20, 150, "关卡： 第" + score + " 关（点击右上角分享）", this.textStyle);
	var error_txt = game.add.text(20, 170, "答错单词如下： ", this.textStyle);

	if(miss_array.length > 0){
		for (var i=0;i< miss_array.length;i++)
			{
				game.add.text(20, 190 + i*20, miss_array[i].name + ":" +miss_array[i].explain, this.errorStyle);
			}


	}


	miss_array = new Array();
	var game_over = game.add.text(game.width/2- 20, game.height/2, "重新开始 ", this.textStyle);
	game_over.inputEnabled = true;

	game_over.events.onInputDown.add(function(){game.state.start('main');}, this);

	game.stage.backgroundColor = "#FFFFFF";
	audio.pause();
	miss_words=0;
	score=1;
	falltime =6000;
	miss_array = new Array();


}

}
game.state.add('boot', game.together.boot);

game.state.add('main', game.together.main);

game.state.add('over', game.together.over);

game.state.start('boot');

  function audioAutoPlay(){
      //var audio = document.getElementById(id);
      audio.play();
      document.addEventListener("WeixinJSBridgeReady", function () {
              audio.play();
      }, false);



  }

function gotoOver(){

fall =1;
		 sprite.y = top_start.y  + top_start.height;
				current_word =words.shift();
				test_name.setText(current_word.name);
				test_name.word = current_word.name;

				audio.src = current_word.voice;
				audio.play();
				audioAutoPlay();
				fall = 1;

				explain_arr.sort(randomSort);

				explain_arr[0].getChildAt(1).setText(current_word.explain);
				explain_arr[0].word = current_word.name;
				//explain_arr[0].events.onInputDown.add(oncheck, explain_arr[0]);


				var item2 = words_array[Math.floor(Math.random()*words_array.length)];
				explain_arr[1].getChildAt(1).setText(item2.explain);
				explain_arr[1].word = item2.name;
				//explain_arr[1].events.onInputDown.add(oncheck, explain_arr[1]);


				var item3 = words_array[Math.floor(Math.random()*words_array.length)];
				explain_arr[2].getChildAt(1).setText(item3.explain);
				explain_arr[2].word = item3.name;
				//explain_arr[2].events.onInputDown.add(oncheck, explain_arr[2]);

				animate = game.add.tween(sprite).to({y: ground.y }, falltime, Phaser.Easing.Linear.None, true);

}

function playagain(sprite){

audio.src = current_word.voice;
		audio.play();
		audioAutoPlay();

}

function transzh(sprite){


sprite.setText(current_word.explain);


}


function oncheck(click_word) {
			 // do something wonderful here
			 //this.y=this.y-100;
			 //alert(this);
       tmp_object= new Object();
       tmp_object.alphabet = click_word.alphabet;
       tmp_object.x = click_word.x;
       tmp_object.y = click_word.y;

			 answer_arr.push(tmp_object);
			 click_word.inputEnabled =false;
			 click_word.destroy();

			 //alert(click_word.alphabet);
			}

function onDown(sprite) {
			 // do something wonderful here
			 //this.y=this.y-100;
			 //alert(this);
			game.state.start('main');

			}


</script>
</head>
<body>



</body>

</html>
