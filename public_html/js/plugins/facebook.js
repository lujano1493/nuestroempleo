(function (w, $, undefined) {
  "use strict";
  $("html body").prepend('<div id="fb-root"></div>');
 window.fbAsyncInit = function() {
    FB.init({
      appId      : window.api_facebook_id, // App ID

      channelURL : '../../Vendor/channel.php', // Channel File
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      oauth      : true, // enable OAuth 2.0
      xfbml      : true  // parse XFBML
    });

    
    
    // Checks whether the user is logged in
    FB.getLoginStatus(function(response) {

      if (response.authResponse) {
        // logged in and connected user, someone you know
        // alert('You are connected');

         testAPI();
      } else {
        // no user session available, someone you dont know
        // alert('You are disconnected');
      }
    });

    FB.Event.subscribe('auth.statusChange', function(response) {
    
    });         
    FB.Event.subscribe('auth.authResponseChange', function(response) {
      if (response.authResponse) {      
        
      } else {
        // the user has just logged out
        // alert('You just logged out from faceboook');
      }
    });
    
    // Other javascript code goes here!


  FB.Event.subscribe('auth.login', function(response) {
          // top.window.location = "some other page";
    });


  };
  window.login_facebook= function(element){
    var $el=$(element),r=$el.data("redirect");
    redirect(r);

  }
  function redirect(url){
       if(url != null && url != ''){
                        top.location.href = url;

       }
  }
 



  // logs the user out of the application and facebook

  $(document).on("click",".logout-fb",function (event){
        event.preventDefault(); 
       var  redirection= $(this).data("redirect")||'';
      if (FB.getAuthResponse()) {
        FB.logout(function(response) {
              // user is logged out
              // redirection if any
             redirect(redirection);
          });} else {
                  redirect(redirection);
          };

  });


  // logs the user out of the application and facebook
  
  $(document).on("click",".login-fb",function (event){      
      event.preventDefault(); 
      var  redirection= $(this).data("redirect")||'';
      FB.login(function(response) {
        if (response.authResponse) {
            redirect(redirection);
        } 
     },{scope: 'email,user_likes'} );    
  });


//desvincular cuenta de nuestro empleo
  $(document).on("click",".revoke-fb",function(event){
         event.preventDefault(); 
        var  redirection= $(this).data("redirect")||'';
        FB.api({ method: 'Auth.revokeAuthorization' }, function(response) {              
              redirect(redirection);
          
        });
  });

  $(document).on("sincronizar-facebook",function (event){
       // Load the SDK asynchronously
      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/"+window.api_facebook_locate+"/all.js#xfbml=1&appId="+window.api_facebook_id;
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));


  });
  $(document).trigger("sincronizar-facebook");


  // Here we run a very simple test of the Graph API after login is successful. 
  // This testAPI() function is only called in those cases. 
  function testAPI() {   
    FB.api('/me', function(data) {
    });
  }  
})(window, jQuery);