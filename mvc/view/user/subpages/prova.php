<html>
<head></head>
<body>
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
  FB.init({
    appId      : 281784095318774,
    status     : true, // check login status
    cookie     : true, // enable cookies to allow the server to access the session
    xfbml      : true,  // parse XFBML
    auth      : true
  });
  
 console.log("oloAAAAAAAAAAAAlo");
  
  
//  function FBLogin(){
//       console.log("ololo");
//	FB.login(function(response){
//		if(response.authResponse){
//			window.location.href = "index.php?page=guest&subpage=prova2";
//		}
//                else 
//                    window.location.href = "index.php?page=guest&subpage=prova2";
//	}, {scope: 'email,user_likes'});
//    }


  // Here we subscribe to the auth.authResponseChange JavaScript event. This event is fired
  // for any authentication related change, such as login, logout or session refresh. This means that
  // whenever someone who was previously logged out tries to log in again, the correct case below 
  // will be handled. 
  FB.Event.subscribe('auth.authResponseChange', function(response) {
    // Here we specify what we do with the response anytime this event occurs. 
    if (response.status === 'connected') {
      // The response object is returned with a status field that lets the app know the current
      // login status of the person. In this case, we're handling the situation where they 
      // have logged in to the app.
      testAPI();
      
      console.log("ololo");
      
        if(response.authResponse){
            console.log("i'm here");
            
            FB.api('/me', function(response) {
 
            console.log("response.name = " + response.name);
            console.log("response.username = " + response.username);
            console.log("response.id  = " + response.id );
            console.log("response.email  = " + response.email );     
            
            post_to_url('/mvc/index.php?page=guest&subpage=prova2', {name: response.name, username: response.username, id: response.id, email: response.email});

            });
            
//            post_to_url('/mvc/index.php?page=guest&subpage=prova2', {name: response.name; username: response.});
            
//            window.location.href = "index.php?page=guest&subpage=prova2";
        }
      
    } else if (response.status === 'not_authorized') {
      // In this case, the person is logged into Facebook, but not into the app, so we call
      // FB.login() to prompt them to do so. 
      // In real-life usage, you wouldn't want to immediately prompt someone to login 
      // like this, for two reasons:
      // (1) JavaScript created popup windows are blocked by most browsers unless they 
      // result from direct interaction from people using the app (such as a mouse click)
      // (2) it is a bad experience to be continually prompted to login upon page load.
      FB.login();
    } else {
      // In this case, the person is not logged into Facebook, so we call the login() 
      // function to prompt them to do so. Note that at this stage there is no indication
      // of whether they are logged into the app. If they aren't then they'll see the Login
      // dialog right after they log in to Facebook. 
      // The same caveats as above apply to the FB.login() call here.
      FB.login();
    }
  },{scope: 'email,user_photos,user_videos'});
  };
  
  function post_to_url(path, params, method) {
    method = method || "post"; // Set method to post by default if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
}

  // Load the SDK asynchronously
  (function(d){
   var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement('script'); js.id = id; js.async = true;
   js.src = "//connect.facebook.net/en_US/all.js";
   ref.parentNode.insertBefore(js, ref);
  }(document));

  // Here we run a very simple test of the Graph API after login is successful. 
  // This testAPI() function is only called in those cases. 
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Good to see you, ' + response.name + '.');
    });
  }
</script>

<!--
  Below we include the Login Button social plugin. This button uses the JavaScript SDK to
  present a graphical Login button that triggers the FB.login() function when clicked. -->


<fb:login-button show-faces="true" data-scope="email" width="200" max-rows="1" onclick="FBLogin();"></fb:login-button>
<!--<img src="../facebook-connect.png" alt="Fb Connect" title="Login with facebook" onclick="FBLogin();"/>-->
</body>
</html>