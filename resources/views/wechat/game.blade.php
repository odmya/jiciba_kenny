<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
         <meta charset="UTF-8" />
         <title>jciba.com</title>
    <script src="js/phaser.min.js"></script>
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>


	<script>

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
        name: 'a(an)',
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
        name: 'be(am,is,are)',
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
var score=0;
var crash; // 爆炸音效
var explain1;
var explain2;
var explain3;

var animate;
var current_word;

var explain_arr = [];
var fall =1;
var falltime =6000;
var degree ={{$option}}
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
	score=0;

	falltime =6000;

	 this.textStyle = {
      font: "24px Arial",
      fill: '#000000',
      wordWrap: true,
      wordWrapWidth: game.width - 80
    };

	var game_start = game.add.text(50, game.height/2, "相鲁班三年级英语第一学期 单词速降(点击开始)", this.textStyle);
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
	if(words.length ==0){
	 fall = 0;

	 game.state.start('over')
	}

	if((top_start.y + sprite.height + 600)> ground.y){
	 fall = 0;

	 game.state.start('over')
	}

	txt_score.setText("Sore: " + score);
	txt_wrong.setText("Error: " + miss_words);
var floor_height = sprite.y + 30 ;

	if(floor_height >= ground.y &&words.length>0){
	top_start.y +=20;
		miss_words +=1;
		miss_array.push(current_word);
		falltime -=200;
		sprite.y = top_start.y  + top_start.height;
		current_word =words.shift();
    if(degree ==0){
      test_name.setText(current_word.name);
    }else{
      test_name.setText("隐藏");
    }

		test_name.word = current_word.name;
		//var mp3 = document.getElementById('video1');
		//var video_source = document.getElementById('video_source');
		//mp3.src = tmp_txt.voice;
		//mp3.play();
		//console.log(mp3);
		audio.src = current_word.voice;
		audio.play();
		audioAutoPlay();
		fall = 1;

		explain_arr.sort(randomSort);
		//console.log(explain_arr);

		//var item1 = words_array[Math.floor(Math.random()*words_array.length)];

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


		//explain_arr[2].getChildAt(0).clear();
	//explain_arr[2].getChildAt(0).beginFill(0xa0e75a);
	//
		//explain_arr[2].getChildAt(0).drawRoundedRect(0, 0, explain_arr[2].getChildAt(0).width, explain_arr[2].getChildAt(0). height+7, 4);

   // explain_arr[2].getChildAt(0).endFill();

	}else{
		fall = 0;
		//game.add.tween(sprite).to({y: ground.y }, 1000, Phaser.Easing.Linear.None, true);
	}

	if(fall ==1){
		animate = game.add.tween(sprite).to({y: ground.y }, falltime, Phaser.Easing.Linear.None, true);
	}

	//console.log(ground.y);
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
	txt_score = game.add.text(0, 20, "Score: 0", this.textStyle);

	txt_wrong = game.add.text(0, 50, "Wrong: 0", this.textStyle);


	current_word =words.shift();
  if(degree ==0){
    //test_name.setText(current_word.name);
    test_name = game.add.text(50, 65, current_word.name, this.textStyle);
  }else{
    //test_name.setText("隐藏");
    test_name = game.add.text(50, 65, "隐藏", this.textStyle);
  }
	//test_name = game.add.text(50, 65, current_word.name, this.textStyle);


	sprite = game.add.sprite(game.width/2 -80, top_start.y  + top_start.height , "ballsky");

	rounded = game.make.graphics(0, 0);

	rounded.beginFill(0xa0e75a);
    rounded.drawRoundedRect(0, 0, test_name.width +50, test_name. height+17, 4);

    rounded.endFill();

	game.physics.arcade.enable(sprite);

    //sprite.addChild(rounded);
	sprite.addChild(test_name);

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


	explain1 = game.add.text(10, 10, "explain1", this.textStyle);


	sprite1 = game.add.sprite(20, game.height  -50, "greenjian");

	rounded1 = game.make.graphics(0, 0);

	rounded1.beginFill(0xa0e75a);
    rounded1.drawRoundedRect(-5, -5, game.width*0.2, explain1. height+20, 4);

    rounded1.endFill();

	sprite1.addChild(rounded1);
	sprite1.addChild(explain1);


	explain2 = game.add.text(10, 10, "expl ain2546 56dfs dfa dsfas dfsdfsf", this.textStyle);

	sprite2 = game.add.sprite(20 + sprite1.x + rounded1.width, game.height  -50, "greenjian");

	rounded2 = game.make.graphics(0, 0);

	rounded2.beginFill(0xa0e75a);
    rounded2.drawRoundedRect(-5, -5, game.width*0.2, explain1. height+20, 4);

    rounded2.endFill();

	sprite2.addChild(rounded2);
	sprite2.addChild(explain2);



	explain3 = game.add.text(10, 10, "explain3", this.textStyle);

	sprite3 = game.add.sprite(20 + sprite2.x + rounded2.width, game.height -50, "greenjian");

	rounded3 = game.make.graphics(0, 0);

	rounded3.beginFill(0xa0e75a);
    rounded3.drawRoundedRect(-5, -5, game.width*0.2, explain1. height+20, 4);

    rounded3.endFill();

	sprite3.addChild(rounded3);
	sprite3.addChild(explain3);

	explain_arr =[sprite1,sprite2, sprite3];

	explain_arr.sort(randomSort);
		//console.log(explain_arr);

		//var item1 = words_array[Math.floor(Math.random()*words_array.length)];

		explain_arr[0].getChildAt(1).setText(current_word.explain);
		explain_arr[0].word = current_word.name;

		//rounded2 = game.make.graphics(0, 0);
	//explain_arr[0].getChildAt(0).clear();
	//explain_arr[0].getChildAt(0).beginFill(0xa0e75a);
   // explain_arr[0].getChildAt(0).drawRoundedRect(0, 0, explain_arr[0].getChildAt(1).width, explain_arr[0].getChildAt(1).height +7, 4);

   // explain_arr[0].getChildAt(0).endFill();

		//console.log(explain_arr[0].getChildAt(1).width);

		var item2 = words_array[Math.floor(Math.random()*words_array.length)];

		explain_arr[1].getChildAt(1).setText(item2.explain);
		explain_arr[1].word = item2.name;

		 //explain_arr[1].getChildAt(0).drawRoundedRect(0, 0, explain_arr[1].getChildAt(1).width, explain_arr[1].getChildAt(1).height+7, 4);

    //explain_arr[1].getChildAt(0).endFill();



		var item3 = words_array[Math.floor(Math.random()*words_array.length)];

		explain_arr[2].getChildAt(1).setText(item3.explain);
		explain_arr[2].word = item3.name;

		//explain_arr[2].getChildAt(0).drawRoundedRect(0, 0, explain_arr[2].getChildAt(1).width, explain_arr[2].getChildAt(1).height+7, 4);

		//explain_arr[2].getChildAt(0).endFill();

		sprite1.inputEnabled = true;
   // sprite1.input.enableDrag();

		sprite1.events.onInputDown.add(oncheck, this);


		sprite2.inputEnabled = true;
   // sprite2.input.enableDrag();

		sprite2.events.onInputDown.add(oncheck, this);


		sprite3.inputEnabled = true;
  //  sprite3.input.enableDrag();

		sprite3.events.onInputDown.add(oncheck, this);

	animate = game.add.tween(sprite).to({y: ground.y }, falltime, Phaser.Easing.Linear.None, true);


	game.stage.backgroundColor = "#f6f6f6";
	//game.state.start('boot2');
	//alert("test2");
  };


};


game.together.over = function() {

this.preload = function() {


}

this.create = function() {


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

	var score_txt = game.add.text(20, 50, "答对单词： " + score, this.textStyle);
	var error_txt = game.add.text(20, 70, "答错单词： " + miss_words, this.textStyle);

	if(miss_array.length > 0){
		for (var i=0;i< miss_array.length;i++)
			{
				game.add.text(20, 90 + i*20, miss_array[i].name + ":" +miss_array[i].explain, this.errorStyle);
			}

	}

	var game_over = game.add.text(game.width/2- 20, game.height/2, "重新开始 ", this.textStyle);

  var share_wechat = game.add.text(game.width/2- 20, game.height/2 +50, "分享到朋友圈 ", this.textStyle);

  var share_friend = game.add.text(game.width/2- 20, game.height/2 +100, "分享给朋友 ", this.textStyle);

  share_wechat.inputEnabled = true;

	share_wechat.events.onInputDown.add(function(){


  },this);


  share_friend.inputEnabled = true;

	share_friend.events.onInputDown.add(function(){


  },this);

	game_over.inputEnabled = true;

	game_over.events.onInputDown.add(function(){game.state.start('main');}, this);

	game.stage.backgroundColor = "#FFFFFF";
	audio.pause();
	miss_words=0;
	score=0;
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

        if(degree ==0){
          test_name.setText(current_word.name);
        }else{
          test_name.setText("隐藏");
        }

			//	test_name.setText(current_word.name);
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
function oncheck(click_word) {
			 // do something wonderful here
			 //this.y=this.y-100;
			 //alert(this);
			 if(click_word.word == current_word.name){
			 score +=1;
			//alert("test");

			animate.stop();
		fall =1;
		 sprite.y = top_start.y  + top_start.height;
				current_word =words.shift();
        if(degree ==0){
          test_name.setText(current_word.name);
        }else{
          test_name.setText("隐藏");
        }

			//	test_name.setText(current_word.name);
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


			 }else{

			 top_start.y +=20;
			 miss_words +=1;
			 miss_array.push(current_word);
			 falltime -=200;
			 var myexplode = game.add.sprite(sprite.x , sprite.y, 'explosion');
			 myexplode.scale.set(2);
			 myexplode.smoothed = false;
			 crash.play();
			// myexplode.animations.add('explosion');
			var anim = myexplode.animations.add('explosion');
			 myexplode.animations.play('explosion', 10, false, true);
			 animate.stop();
			 anim.onComplete.add(gotoOver, this);

			 }
		//alert(current_word.name);


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
