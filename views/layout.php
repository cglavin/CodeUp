<?php

   //print_r($_COOKIE);
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>
        <link rel="stylesheet" href="/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="/css/main.css">

        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Vote Decay Test</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <?php if($_COOKIE['user_id'] > 0){?>
            <div class="navbar-right">
            <span>Welcome <?php echo $_COOKIE['user_name']; ?> </span>  <a class="btn btn-success" href='/home/add'>Add a link</a> <button id="logout" type="submit" class="btn btn-danger">Logout</button>
          </div>
          <?php }else{?>
          <form class="navbar-form navbar-right" role="form" id="login">
            <div class="form-group">
              <input id="email_input" type="text" placeholder="Email" class="form-control"><div id="emailAlert" class="alert alert-danger" role="alert"><span class="sr-only">Error:</span>Enter a valid email <br>address</div>
            </div>
            <div class="form-group">
              <input id="pass_input" type="password" placeholder="Password" class="form-control"><div id="passAlert" class="alert alert-danger" role="alert"><span class="sr-only">Error:</span>Enter a password with<br> at least 8 characters</div>
            </div>
            <button id="submit_input" type="submit" class="btn btn-success">Sign in</button>
          </form>
          <?php } ?>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <!--
    <div class="jumbotron">
      <div class="container">
        <h1>Hello, world!</h1>
        <p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
        <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p>
      </div>
    </div>
  -->
    <div class="container">
      <?php require_once('routes.php'); ?>


      <!-- Example row of columns -->
      <!--
      <div class="row">
        <div class="col-md-4">
          <h2>Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <h2>Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
       </div>
        <div class="col-md-4">
          <h2>Heading</h2>
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div>
      </div>
    -->
      <hr>

      <footer>
        <p>&copy; Company 2015</p>
      </footer>
    </div> <!-- /container -->        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
        <?php if($_COOKIE['user_id'] > 0){?>
          <script type="text/javascript">
             jQuery(document).ready(function() {

               var logout = jQuery('#logout');
               logout.click(function(event){

                 event.preventDefault();
                 jQuery.ajax({
                   url:'/ajax/logout.php',
                   success: function(result){
                       if(result) {
                         if(result == 'success'){
                           window.location.href = '/home';
                         }else{
                           alert(result);
                         }
                       }else{
                          alert('send fail');
                       }
                     }
                 });

               });

            });
          </script>
        <?php }else{?>
        <script type="text/javascript">
           jQuery(document).ready(function() {
              var email = jQuery('#email_input');
              var pass = jQuery('#pass_input');
              var emailval, passval;
              var submit = jQuery('#submit_input');
              var emailError = jQuery('#emailAlert');
              var passError = jQuery('#passAlert');
              var errorCount;
              var goodToGo = false;
              emailError.hide();
              passError.hide();
              submit.click(function(event){
             	       event.preventDefault();
                     errorCount = 0;
                     emailval = email.val();
                     passval = pass.val();
                     if(emailval.length > 1){
              		        var mailvalid = validateEmail(emailval);
              		   }
              		   if((mailvalid == false && emailval.length > 1) || emailval.length < 1) {
              				   emailError.show('slow');
              					 goodToGo = false;
              					 errorCount ++;
              			 }else if(mailvalid == true){
              				  emailError.hide('slow');
              					goodToGo = true;
              			 } //end validate email
                     //check password

                     if(passval.length <= 7) {//at least 8 chars
             					passError.show('slow');
             					goodToGo = false;
             					errorCount ++;
                    }else if(passval.length >= 8){
             					passError.hide('slow');
             					goodToGo = true;
                    }//end check password
                    if(errorCount == 0){//submit for if there aren't any errors
                    jQuery.ajax({
                      type: 'POST',
                      url:'/ajax/login.php',
                      data: {email: emailval, pass: passval} ,
                      success: function(result){
                          if(result) {
                            if(result == 'success'){
                              window.location.href = '/home';
                            }else{
                              alert(result);
                            }
                          }else{
                             alert('send fail');
                          }
                        }
                    });
                    }

              });//end submit click event
           });
           function validateEmail(email) {
                var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          		return reg.test(email);
           }
        </script>
        <?php } ?>
        <?php if(isset($includeJS)){print $includeJS;}?>
    </body>
</html>
