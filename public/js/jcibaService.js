angular.module('querywordService', [])
  
  .factory('Queryword', function($rootScope, $location,$http, CSRF_TOKEN, QUERY_WORD) {
  
  var url = $location.url(); 
	var sValue=$location.absUrl().match(new RegExp("^(.*)/query/([a-z0-9\-\s]+)/?$"));

    return {
      // get all the comments
	  /*
      get : function() {
        return $http.get('/api/query/', {  
			params: {  
				query: sValue[2],  
			}  
		}); 
		
      }
	  */
	   post : function($id) {

		return $http({
          method: 'POST',
          url: '/api/word/',
         // headers: { 'X-CSRF-TOKEN' : CSRF_TOKEN },  //需要传入X-CSRF-TOKEN 才可以post 数据
          data: {  
				word: QUERY_WORD,
				include: 'explain, voice,tip,level,root',
			},
        });
		
		
      }
	  
    }
  
  }).factory('Queryroot', function($rootScope, $location,$http, CSRF_TOKEN) {
  
 // console.log(CSRF_TOKEN);
  
  var url = $location.url(); 
	var sValue=$location.absUrl().match(new RegExp("^(.*)/query/([a-z0-9\-]+)/?$"));
	
    return {
      // get all the comments
      post : function($id) {

		return $http({
          method: 'POST',
          url: '/api/praise/',
          headers: { 'X-CSRF-TOKEN' : CSRF_TOKEN },  //需要传入X-CSRF-TOKEN 才可以post 数据
          data: {  
				id:$id,
			},
        });
		
		
      }
    }
  
  }).factory('rootQueryword', function($rootScope, $location,$http) {
  
  var url = $location.url(); 
	var sValue=$location.absUrl().match(new RegExp("^(.*)/cigen/([a-z0-9\-]+)/?$"));
	
    return {
      // get all the comments
      get : function() {
        return $http.get('/api/root/', {  
			params: {  
				query: sValue[2],  
			}  
		}); 
		
      }
    }
  
  }).factory('QuerySentence', function($rootScope, $location,$http, QUERY_WORD) {
  
	
    return {
      // get all the comments
      post : function($id) {

		return $http({
          method: 'POST',
          url: '/api/sentence/',
          data: {  
				query:QUERY_WORD,
			},
        });
		
		
      }
    }
  
  }).factory('QueryStarWords', function($rootScope, $location,$http, WORD_STAR) {
  
	
    return {
      // get all the comments
      post : function($id) {

		return $http({
          method: 'POST',
          url: '/api/star/',
          data: {  
				star:WORD_STAR,
				include: 'explain, voice,tip,level,root',
			},
        });
		
		
      }
    }
  
  });
  
