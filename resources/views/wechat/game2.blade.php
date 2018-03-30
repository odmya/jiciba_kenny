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
          "title": '不服来战！默写三年级单词！', // 分享标题
          "link": 'https://www.jciba.cn/game?degree=3',
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
        name: 'cool',
        explain: '酷',
        voice: 'voice/word/cool_1.mp3'
      },
	  {
        name: 'cat',
        explain: '猫',
        voice: 'voice/word/cat_1.mp3'
      }
	  ,
	  {
        name: 'cute',
        explain: '漂亮的',
        voice: 'voice/word/cute_1.mp3'
      }
	  ,

	  {
        name: 'chair',
        explain: '椅子',
        voice: 'voice/word/chair_1.mp3'
      }
	  ,
	  {
        name: 'Chinese',
        explain: '中文（课）',
        voice: 'voice/word/chinese_1.mp3'
      }
	  ,
	  {
        name: 'colour',
        explain: '颜色',
        voice: 'voice/word/colour_1.mp3'
      }
	  ,

	   {
        name: 'dad',
        explain: '(口语)爸爸',
        voice: 'voice/word/dad_1.mp3'
      }
	  ,

	  {
        name: 'dog',
        explain: '狗',
        voice: 'voice/word/dog_0.mp3'
      }

	   ,

	  {
        name: 'draw',
        explain: '画',
        voice: 'voice/word/draw_1.mp3'
      }

	  ,

	  {
        name: 'ear',
        explain: '耳朵',
        voice: 'voice/word/ear_1.mp3'
      }

	  ,

	  {
        name: 'egg',
        explain: '蛋',
        voice: 'voice/word/egg_1.mp3'
      }

	  ,

	  {
        name: 'English',
        explain: '英语(课)',
        voice: 'voice/word/english_1.mp3'
      }

	   ,

	  {
        name: 'eraser',
        explain: '橡皮',
        voice: 'voice/word/eraser_1.mp3'
      }

	  ,

	  {
        name: 'eye',
        explain: '眼睛',
        voice: 'voice/word/eye_1.mp3'
      }
	  ,

	  {
        name: 'fish',
        explain: '鱼',
        voice: 'voice/word/fish_1.mp3'
      }

	  ,
	  {
        name: 'for',
        explain: '为; 给',
        voice: 'voice/word/for_1.mp3'
      }

	  ,
	  {
        name: 'gift',
        explain: '礼物',
        voice: 'voice/word/gift_1.mp3'
      }

	  ,
	  {
        name: 'goal',
        explain: '得分',
        voice: 'voice/word/goal_1.mp3'
      }

	  ,
	  {
        name: 'goodbye',
        explain: '再见',
        voice: 'voice/word/goodbye_1.mp3'
      }

	  ,
	  {
        name: 'green',
        explain: '绿色的',
        voice: 'voice/word/green_1.mp3'
      }

	  ,
	  {
        name: 'guess',
        explain: '猜',
        voice: 'voice/word/guess_1.mp3'
      }

	   ,
	  {
        name: 'please',
        explain: '请',
        voice: 'voice/word/please_1.mp3'
      }

	   ,
	  {
        name: 'pupil',
        explain: '学生',
        voice: 'voice/word/pupil_1.mp3'
      }

	   ,
	  {
        name: 'red',
        explain: '红色的',
        voice: 'voice/word/red_1.mp3'
      }
	  ,
	  {
        name: 'ruler',
        explain: '尺',
        voice: 'voice/word/ruler_1.mp3'
      }
	  ,
	  {
        name: 'she',
        explain: '她',
        voice: 'voice/word/she_1.mp3'
      }
	   ,
	  {
        name: 'shoot',
        explain: '射门',
        voice: 'voice/word/shoot_1.mp3'
      }
	  ,
	  {
        name: 'small',
        explain: '小的',
        voice: 'voice/word/small_1.mp3'
      }

	  ,
	  {
        name: 'table',
        explain: '桌子',
        voice: 'voice/word/table_1.mp3'
      }
	  ,
	  {
        name: 'teacher',
        explain: '老师',
        voice: 'voice/word/teacher_1.mp3'
      }
	  ,
	  {
        name: 'that',
        explain: '那，那个',
        voice: 'voice/word/that_1.mp3'
      }
	  ,
	  {
        name: 'they',
        explain: '他/她/它们',
        voice: 'voice/word/they_1.mp3'
      }
	  ,
	  {
        name: 'too',
        explain: '也',
        voice: 'voice/word/too_1.mp3'
      }
	  ,
	  {
        name: 'touch',
        explain: '触摸',
        voice: 'voice/word/touch_1.mp3'
      }

	  ,
	  {
        name: 'turtle',
        explain: '乌龟',
        voice: 'voice/word/turtle_1.mp3'
      }
	  ,
	  {
        name: 'ugly',
        explain: '丑的',
        voice: 'voice/word/ugly_1.mp3'
      }
	   ,
	  {
        name: 'who',
        explain: '谁',
        voice: 'voice/word/who_1.mp3'
      }

	   ,
	  {
        name: 'yellow',
        explain: '黄色',
        voice: 'voice/word/yellow_1.mp3'
      },
	  {
        name: 'yes',
        explain: '是的',
        voice: 'voice/word/yes_1.mp3'
      }
	   ,
	   {
        name: 'one',
        explain: '一',
        voice: 'voice/word/one_1.mp3'
      }
	  ,
	   {
        name: 'two',
        explain: '二',
        voice: 'voice/word/two_1.mp3'
      }

	  ,
	   {
        name: 'three',
        explain: '三',
        voice: 'voice/word/three_1.mp3'
      } ,
	   {
        name: 'four',
        explain: '四',
        voice: 'voice/word/four_1.mp3'
      } ,
	   {
        name: 'five',
        explain: '五',
        voice: 'voice/word/five_1.mp3'
      },
	   {
        name: 'six',
        explain: '六',
        voice: 'voice/word/six_1.mp3'
      }
	  ,
	   {
        name: 'seven',
        explain: '七',
        voice: 'voice/word/seven_1.mp3'
      },
	   {
        name: 'eight',
        explain: '八',
        voice: 'voice/word/eight_1.mp3'
      },
	   {
        name: 'eight',
        explain: '八',
        voice: 'voice/word/eight_1.mp3'
      }
	  ,
	   {
        name: 'nine',
        explain: '九',
        voice: 'voice/word/nine_1.mp3'
      },
	   {
        name: 'ten',
        explain: '十',
        voice: 'voice/word/ten_1.mp3'
      },
	   {
        name: 'eleven',
        explain: '十一',
        voice: 'voice/word/eleven_1.mp3'
      },
	   {
        name: 'twelve',
        explain: '十二',
        voice: 'voice/word/twelve_1.mp3'
      }
	  ,
	   {
        name: 'thirteen',
        explain: '十三',
        voice: 'voice/word/thirteen_1.mp3'
      },
	   {
        name: 'fourteen',
        explain: '十四',
        voice: 'voice/word/fourteen_1.mp3'
      },
	   {
        name: 'fifteen',
        explain: '十五',
        voice: 'voice/word/fifteen_1.mp3'
      },
	   {
        name: 'sixteen',
        explain: '十六',
        voice: 'voice/word/sixteen_1.mp3'
      },
	   {
        name: 'seventeen',
        explain: '十七',
        voice: 'voice/word/seventeen_1.mp3'
      },
	   {
        name: 'eighteen',
        explain: '十八',
        voice: 'voice/word/eighteen_1.mp3'
      },
	   {
        name: 'nineteen',
        explain: '十九',
        voice: 'voice/word/nineteen_1.mp3'
      }
	  ,
	   {
        name: 'twenty',
        explain: '二十',
        voice: 'voice/word/twenty_1.mp3'
      }
	   ,

	  {
        name: 'where',
        explain: '在哪里',
        voice: 'voice/word/where_1.mp3'
      }
	   ,
	  {
        name: 'toy',
        explain: '玩具',
        voice: 'voice/word/toy_1.mp3'
      }

	  ,
	  {
        name: 'the',
        explain: '用于特定的人或物之前',
        voice: 'voice/word/the_1.mp3'
      }
	  ,
	  {
        name: 'a',
        explain: '一（本，个...）',
        voice: 'voice/word/a_1.mp3'
      }
	  ,

	  {
        name: 'and',
        explain: '和，与',
        voice: 'voice/word/and_1.mp3'
      }
	  ,

	  {
        name: 'apple',
        explain: '苹果',
        voice: 'voice/word/apple_1.mp3'
      }
	  ,

	  {
        name: 'arm',
        explain: '臂',
        voice: 'voice/word/arm_1.mp3'
      }
	  ,

	  {
        name: 'bag',
        explain: '书包',
        voice: 'voice/word/bag_1.mp3'
      }
	  ,

	  {
        name: 'basketball',
        explain: '篮球',
        voice: 'voice/word/basketball_1.mp3'
      }

	  , {
        name: 'be',
        explain: '是',
        voice: 'voice/word/be_1.mp3'
      }

	  ,

	  {
        name: 'beautiful',
        explain: '美丽的',
        voice: 'voice/word/beautiful_1.mp3'
      }

	  ,

	  {
        name: 'big',
        explain: '大的',
        voice: 'voice/word/big_1.mp3'
      }

	  ,

	  {
        name: 'blue',
        explain: '蓝色',
        voice: 'voice/word/blue_1.mp3'
      }

	  ,

	  {
        name: 'book',
        explain: '书',
        voice: 'voice/word/book_1.mp3'
      }
	  ,

	  {
        name: 'cake',
        explain: '蛋糕',
        voice: 'voice/word/cake_1.mp3'
      }

	  ,

	  {
        name: 'card',
        explain: '卡片',
        voice: 'voice/word/card_1.mp3'
      }

	  , {
        name: 'desk',
        explain: '书桌',
        voice: 'voice/word/desk_1.mp3'
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

	var game_start = game.add.text(50, game.height/2, "相鲁班三年级英语第下学期 单词练习(点击开始)", this.textStyle);
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

game.together.main = function() {

  this.preload = function() {



  };
  this.update = function() {
	//game.physics.arcade.collide(ground, sprite, shift_words);
	//game.physics.arcade.collide(ground, rounded, shift_words);
txt_score.setText("第: " + score + "关");
	for (var i=0;i< answer_arr.length;i++){
		crrent_arr[i].getChildAt(1).setText(answer_arr[i]);
	}
	if(answer_arr.length == current_word.name.length){
		if(answer_arr.join("") ==current_word.name){



			for (var i=0;i< crrent_arr.length;i++){
				crrent_arr[i].destroy();;
			}

			for (var i=0;i< explain_arr.length;i++){
				explain_arr[i].destroy();;
			}

			crrent_arr = new Array();
			select_alphabet  = new Array();
			explain_arr = new Array();
			answer_arr = new Array();
			current_word =words.shift();
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


		}else{
			miss_array.push(current_word);
			crrent_arr = new Array();
			select_alphabet  = new Array();
			explain_arr = new Array();
			answer_arr = new Array();
			game.state.start('over')

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
function oncheck(click_word) {
			 // do something wonderful here
			 //this.y=this.y-100;
			 //alert(this);
			 answer_arr.push(click_word.alphabet);
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
