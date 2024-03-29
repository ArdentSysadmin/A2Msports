<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ------>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <style>

/* sign in FORM */
#logreg-forms{
    width:412px;
    margin:10vh auto;
    background-color:#f3f3f3;
    box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
  transition: all 0.3s cubic-bezier(.25,.8,.25,1);
}
#logreg-forms form {
    width: 100%;
    max-width: 410px;
    padding: 15px;
    margin: auto;
}
#logreg-forms .form-control {
    position: relative;
    box-sizing: border-box;
    height: auto;
    padding: 10px;
    font-size: 16px;
}
#logreg-forms .form-control:focus { z-index: 2; }
#logreg-forms .form-signin input[type="email"] {
    margin-bottom: -1px;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
}
#logreg-forms .form-signin input[type="password"] {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}

#logreg-forms .social-login{
    width:390px;
    margin:0 auto;
    margin-bottom: 14px;
}
#logreg-forms .social-btn{
    font-weight: 100;
    color:white;
    width:190px;
    font-size: 0.9rem;
}

#logreg-forms a{
    display: block;
    padding-top:10px;
    color:lightseagreen;
}

#logreg-form .lines{
    width:200px;
    border:1px solid red;
}

#logreg-forms button[type="submit"]{ margin-top:10px; }
#logreg-forms .facebook-btn{  background-color:#3C589C; }
#logreg-forms .google-btn{ background-color: #DF4B3B; }
#logreg-forms .form-reset, #logreg-forms .form-signup{ display: none; }
#logreg-forms .form-signup .social-btn{ width:210px; }
#logreg-forms .form-signup input { margin-bottom: 2px;}

.form-signup .social-login{
    width:210px !important;
    margin: 0 auto;
}

/* Mobile */

@media screen and (max-width:500px){
    #logreg-forms{
        width:300px;
    }
    
    #logreg-forms  .social-login{
        width:200px;
        margin:0 auto;
        margin-bottom: 10px;
    }
    #logreg-forms  .social-btn{
        font-size: 1.3rem;
        font-weight: 100;
        color:white;
        width:200px;
        height: 56px;
    }
    #logreg-forms .social-btn:nth-child(1){
        margin-bottom: 5px;
    }
    #logreg-forms .social-btn span{
        display: none;
    }
    #logreg-forms  .facebook-btn:after{
        content:'Facebook';
    }
    #logreg-forms  .google-btn:after{
        content:'Google+';
    }
    
}
    </style>
    <title></title>
</head>
<body>
    <div id="logreg-forms">
        <form class="form-signin" accept="#">
            <h1 class="h3 mb-3 font-weight-normal" style="text-align: center"> Sign in</h1>
			
			<div id='phone-input'>
            <input type="text" id="inputPhone" class="form-control" placeholder="PHONE" required="" autofocus="">
            <div id="recaptcha-container"></div>
            <button class="btn btn-success btn-block" type="button" id="phoneloginbtn"><i class="fas fa-sign-in-alt"></i> SEND OTP</button>
			</div>
			<div id='otp-input' style="display:none;">
            <input type="otp" id="inputOtp" class="form-control" placeholder="OTP" required="">
            <button class="btn btn-success btn-block" type="button" id="verifyotp"><i class="fas fa-sign-in-alt"></i> VERIFY OTP</button>
			</div>
        </form>

            
    </div>

    
    </p>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 <!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<!-- <script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-analytics.js"></script> -->
<script defer src="https://www.gstatic.com/firebasejs/7.19.0/firebase-auth.js"></script>


<script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
  apiKey: "AIzaSyCmVrLhO1Wo69C-GjfNEGAL-taGq__TrDU",
  authDomain: "a2msports-1536907453916.firebaseapp.com",
  databaseURL: "https://a2msports-1536907453916.firebaseio.com",
  projectId: "a2msports-1536907453916",
  storageBucket: "a2msports-1536907453916.appspot.com",
  messagingSenderId: "1070980649409",
  appId: "1:1070980649409:web:ebd5383a8d975c16335f40"
};
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  //firebase.analytics();

   //===================Saving Login Details in My Server Using AJAX================
   function sendDatatoServerPhp(email,provider,token,username){
       
        var xhr = new XMLHttpRequest();
        //xhr.withCredentials = true;

        xhr.addEventListener("readystatechange", function() {
        if(this.readyState === 4) {
            console.log(this.responseText);
            if(this.responseText=="Login Successfull" || this.responseText=="User Created"){
                alert("Login Successfull");
                location='home.php';
            }
            else if(this.responseText=="Please Verify Your Email to Get Login"){
                alert("Please Verify Your Email to Login")
            }
            else{
                alert("Error in Login");
            }
        }
        });

        xhr.open("POST", "https://a2msports.com/test/check_phone?email="+email+"&provider="+provider+"&username="+username+"&token="+token);
        xhr.send();
   }

   //===========================End Saving Details in My Server=======================
   //=========================Login With Phone==========================
   var loginphone=document.getElementById("phoneloginbtn");
   var phoneinput=document.getElementById("inputPhone");
   var otpinput=document.getElementById("inputOtp");
   var verifyotp=document.getElementById("verifyotp");

   loginphone.onclick=function(){
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
        'size': 'normal',
        'callback': function(response) {
            // reCAPTCHA solved, allow signInWithPhoneNumber.

            // ...
        },
        'expired-callback': function() {
            // Response expired. Ask user to solve reCAPTCHA again.
            // ...
        }
        });

        var cverify=window.recaptchaVerifier;

        firebase.auth().signInWithPhoneNumber(phoneinput.value,cverify).then(function(response){
			alert("test");
			var x = document.getElementById("phone-input");
			var y = document.getElementById("otp-input");
  if (x.style.display === "none") {    x.style.display = "block";  } else {   x.style.display = "none";  }
  if (y.style.display === "none") {    y.style.display = "block";  } else {   y.style.display = "none";  }
            console.log(response);
            window.confirmationResult=response;
        }).catch(function(error){
            console.log(error);
        })
   }

   verifyotp.onclick=function(){
       confirmationResult.confirm(otpinput.value).then(function(response){
           console.log(response);
            var userobj=response.user;
            var token=userobj.xa;
            var provider="phone";
            var email=phoneinput.value;
            if(token!=null && token!=undefined && token!=""){
            sendDatatoServerPhp(email,provider,token,email);
            }
       })
       .catch(function(error){
           console.log(error);
       })
   }
   //=================End Login With Phone=========================

   ///=================Login With google===========================
  /* var googleLogin=document.getElementById("googleLogin");

   googleLogin.onclick=function(){
       var provider=new firebase.auth.GoogleAuthProvider();

       firebase.auth().signInWithPopup(provider).then(function(response){
           var userobj=response.user;
            var token=userobj.xa;
            var provider="google";
            var email=userobj.email;
            if(token!=null && token!=undefined && token!=""){
            sendDatatoServerPhp(email,provider,token,userobj.displayName);
            }

           console.log(response);
       })
       .catch(function(error){
           console.log(error);
       })


   }
   */
   //=======================End Login With Google==================
   //======================Login With Facebook==========================
  /* var facebooklogin=document.getElementById("facebooklogin");
   facebooklogin.onclick=function(){
    var provider=new firebase.auth.FacebookAuthProvider();

firebase.auth().signInWithPopup(provider).then(function(response){
    var userobj=response.user;
     var token=userobj.xa;
     var provider="facebook";
     var email=userobj.email;
     if(token!=null && token!=undefined && token!=""){
     sendDatatoServerPhp(email,provider,token,userobj.displayName);
     }

    console.log(response);
})
.catch(function(error){
    console.log(error);
})


   }
   */
   //======================End Login With Facebook==========================
</script>
</body>
</html>