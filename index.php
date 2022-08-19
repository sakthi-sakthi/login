<!DOCTYPE html>
<html>
<head>
	<title>Complete user registration system in php and MySQL using Ajax</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>	
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
	<style type="text/css">
		body {
			font-family: 'Verdana';
			font-size: 16px;
			font-weight: bold;
		}
		.panel {
			border: 0;
		}
		form {
			padding: 0 10px;
		}
		.addon-diff-color {
	      background-color: #f0ad4e;
	      color: white;
	    }
	   .panel-title {
	   		color: #f0ad4e;
	   		font-weight: bolder;
	    }
	    .sign-up, .forgot-pass{
			display: none;
		}
	    .alert, #loader {
	    	display: none;
	    }
	    .error{
	    	color: red;
	    	font-size: 12px	;
	    }
	</style>
	
</head>

<body>

	<div class="container">
		<h3 class="text-center">Registration</h3>
				<div id="result"></div>
		<hr>
		<div class="card"> 
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">x</button>
			
				</div>
				<center><img src="img/loader.gif" id="loader"></center>
			</div>
		    <div class="col-md-6 col-md-offset-3 sign-up">
				<div class="panel">
					<div class="panel-heading">
					    <h3 class="panel-title text-center">SIGN UP FORM</h3>

					</div>
		  			<div class="panel-body">
		  				  <p style="color:red; font-size:10px">Note : All the fields are mandatory (*)</p>
						<form id="sign-up-frm" name="registration" role="form" method="post" action="" class="form-horizontal">
							<div class="form-group">
                              	<div class="input-group">
	                                <div class="input-group-addon addon-diff-color">
	                                    <span class="glyphicon glyphicon-user"></span>
	                                </div>
	                                <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name">
                              	</div>
                            </div>
                            <div class="form-group">
                              	<div class="input-group">
	                                <div class="input-group-addon addon-diff-color">
	                                    <span class="glyphicon glyphicon-user"></span>
	                                </div>
	                                <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name">
                              	</div>
                            </div>
                              <div class="form-group">
			                	<div class="input-group">
	                                <div class="input-group-addon addon-diff-color">
	                                    <span class="glyphicon glyphicon-envelope"></span>
	                                </div>
			                    	<input type="email" class="form-control" id="uemail" name="uemail" placeholder="Email Address">
			                	</div>
			                </div>
			                <div class="form-group">
			                	<div class="input-group">
			                		<div class="input-group-addon addon-diff-color">
	                                    <span class="glyphicon glyphicon-earphone"></span>
	                                </div>
				                    <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number">

				                </div>
			                </div>
			          

			                 <div class="form-group">
			                	<div class="input-group">
			                		<div class="input-group-addon addon-diff-color">
	                                    <span class="glyphicon glyphicon-globe"></span>
	                                </div>
				                    <textarea class="form-control" id="address" name="address" placeholder="address"></textarea> 

				                </div>
			                </div>

			                <div class="form-group">
			                	<div class="input-group">
			                		<div class="input-group-addon addon-diff-color">
	                                    <span class="glyphicon glyphicon-globe"></span>
	                                </div>
				                    <input type="text" class="form-control" id="city" name="city" placeholder="City">

				                </div>
			                </div>
			                <div class="form-group">
			                	<div class="input-group">
			                		<div class="input-group-addon addon-diff-color">
	                                   <span class="glyphicon glyphicon-globe"></span>
	                                </div>
				                    <input type="text" class="form-control" id="country" name="country" placeholder="Country">

				                </div>
			                </div>

			                <div class="form-group">
			                	<div class="input-group">
	                                <div class="input-group-addon addon-diff-color">
	                                    <span class="glyphicon glyphicon-lock"></span>
	                                </div>
			                    	<input type="password" class="form-control" id="pass" name="pass" placeholder="Password">
			                    </div>
			                </div>
			                <div class="form-group">
			                    <div class="input-group">
	                                <div class="input-group-addon addon-diff-color">
	                                    <span class="glyphicon glyphicon-lock"></span>
	                                </div>
			                    	<input type="password" class="form-control" id="cfm_pass" name="cfm_pass" placeholder="Confirm Password">
			                    </div>
			                </div>

			                <div class="form-group">
			                    <input type="submit" value="REGISTER" class="btn btn-warning btn-block" id="register" name="register"/>
			                </div>
			                <div class="form-group">
                                <div class="col-md-12 control">
                                    <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                        Already have an account! 
                                    <a href="#" onClick="$('.sign-up').hide(); $('.sign-in').show()">
                                        Sign in Here
                                    </a>
                                    </div>
                                </div>
                            </div>    
				        </form>
		    		</div>
				</div>
		  	</div>
		  	<div class="col-md-6 col-md-offset-3 sign-in">
				<div class="panel">
			 		<div class="panel-heading">
					    <h3 class="panel-title text-center">SIGN IN FORM</h3>
					    
					</div>
		  			<div class="panel-body">
						<form id="sign-in-frm" name ="sign-in-frm" role="form" method="post" action="" class="form-horizontal">
			                <div class="form-group">
			                	<div class="input-group">
	                                <div class="input-group-addon addon-diff-color">
	                                    <span class="glyphicon glyphicon-envelope"></span>
	                                </div>
			                    	<input type="email" class="form-control" id="email" name="email" placeholder="Email Address">
			                	</div>
			                </div>
			                <div class="form-group">
			                	<div class="input-group">
	                                <div class="input-group-addon addon-diff-color">
	                                    <span class="glyphicon glyphicon-lock"></span>
	                                </div>
			                    	<input type="password" class="form-control" id="pwd" name="pwd" placeholder="Password">
			                    </div>
			                </div>
			                <div class="form-group">
			                   <input type="checkbox" class="form-control" id="remember-me" name="remember-me" style="width: 30px;"><div style="position: relative; top: -30px; left: 40px;"> Remember Me </div>
			                </div>
			                <div class="form-group">
			                    <input type="submit" value="Login" class="btn btn-warning btn-block" id="login" name="login"/>
			                </div>

			                <div class="form-group">
                                <div class="col-md-12 control">
                                    <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                        Don't have an account! 
                                    <a href="#" onClick="$('.sign-in').hide(); $('.sign-up').show()">
                                        Sign Up Here
                                    </a>
                                    </div>
                                </div>
                            </div>    
				        </form>
		    		</div>
				</div>
		  	</div>
		  
		</div>
		</div>
	</div>
</body>
<script type="text/javascript">
		$(document).ready(function(){

			$.ajax({
				url: 'action.php',
				method: 'post',
				data: 'action=checkCookie'
			}).done(function(result){
				if(result) {
					console.log(result)
					var data = JSON.parse(result);
					$('#email').val(data.email);
					$('#pwd').val(data.pass);
				}
			})

	$("form[name='registration']").validate({
    // Specify validation rules
    rules: {
      // The key name on the left side is the name attribute
      // of an input field. Validation rules are defined
      // on the right side
      fname: "required",
      lname: "required",
      mobile: {
        required: true,
        minlength: 5
      },
      address: "required",
      city: "required",
      country: "required",
      uemail: {
        required: true,
        // Specify that email should be validated
        // by the built-in "email" rule
        email: true
      },
      pass: {
        required: true,
        minlength: 5
      },
       cfm_pass: {
        required: true,
        minlength: 5,
        equalTo: "#pass"
      },

    },

    // Specify validation error messages
    messages: {
      fname: "Please enter your first name",
      lname: "Please enter your last name",
      mobile: {
        required: "Please enter your mobile number",
        minlength: "Please enter ten digit for the mobile number"
      },
      address: "Please enter your address",
      city: "Please enter your city",
      country: "Please enter your country",
      pass: {
        required: "Please provide a password",
        minlength: "Your password must be at least 5 characters long"
      },
       cfm_pass: {
        required: "Please provide a password",
        minlength: "Your password must be at least 5 characters long",
        equalTo:   "Password is mismatched, confirm password must be same	"
      },


      uemail: "Please enter a valid email address",

    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
     	event.preventDefault();
				var formData = $('#sign-up-frm').serialize();
				console.log(formData);
				$.ajax({
					url: 'action.php',
					method: 'post',
					data: formData + '&action=register'
				}).done(function(result){
					alert('User registered successfully');
					$('.sign-up').hide();
					 $('.sign-in').show()
				});
    }
  });

// $('#register').click(function(event){
			
// 			})

$("form[name='sign-in-frm']").validate({
    // Specify validation rules
    rules: {
      // The key name on the left side is the name attribute
      // of an input field. Validation rules are defined
      email: {
        required: true,
        // Specify that email should be validated
        // by the built-in "email" rule
        email: true
      },
      pwd: {
        required: true,
        minlength: 5
      }
      

    },

    // Specify validation error messages
    messages: {
     
      pwd: {
        required: "Please provide a password",
        minlength: "Your password must be at least 5 characters long"
      },
      email: "Please enter a valid email address",

    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
     			var formData = $('#sign-in-frm').serialize();
				console.log(formData);
				$.ajax({
					url: 'action.php',
					method: 'post',
					data: formData + '&action=login'
				}).done(function(result){
					console.log(result);
					var data = JSON.parse(result);
					if(data.status == 0) {
						$('#result').html(data.msg);
					} else {
						alert("You are logged in");
						$('#result').html(data.msg);
					//	document.location = 'welcome.php';
					}
					
				})
    }
  });
			



		})

	</script>
</html>