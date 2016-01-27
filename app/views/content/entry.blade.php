@extends('layout.master')

@section('load') 
	
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  -->
    <title>Login and Registration Form with HTML5 and CSS3</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="shortcut icon" href="../favicon.ico"> 
    <link rel="stylesheet" type="text/css" href="css/LoginRegisterMaster.css" /> <!--body, container, table-->
    <link rel="stylesheet" type="text/css" href="css/LoginRegisterContent.css" /> <!--Content designs-->
	<link rel="stylesheet" type="text/css" href="css/animation.css" /> <!--For the animation-->
	<script type="text/javascript" src="javascript/jquerymin.js"></script>
	<script type="text/javascript">
	    $(document).ready(function(){
	        $("select").change(function(){
	            $( "select option:selected").each(function(){
	                
	                if($(this).attr("value")=="Child"){
	                    $(".box").hide();
	                    $(".child").show();
	                }
	                else{
	                	$(".box").hide();
	                }
	            });
	        }).change();
	    });
	</script>

    <script language='javascript' type='text/javascript'>
        function check(input) {
            if (input.value != document.getElementById('passwordsignup').value) {
                input.setCustomValidity('Password Must be Matching.');
            } else {
                // input is valid -- reset the error message
                input.setCustomValidity('');
            }
        }
    </script>
    <style type="text/css">
    #account{
        color:#585858;
        height:30px; 
        width:100px; 
        background:#FAFAFA; 
        border-radius:3px; 
        -webkit-box-shadow: 0px 1px 4px 0px rgba(168, 168, 168, 0.6) inset; 
        -moz-box-shadow: 0px 1px 4px 0px rgba(168, 168, 168, 0.6) inset; 
        box-shadow: 0px 1px 4px 0px rgba(168, 168, 168, 0.6) inset;
    }
    </style>
@endsection

@section('content')
	<body>
        <div class="container">
            
            <section>				
                <div id="container_demo" >
                    <!-- hidden anchor to stop jump http://www.css3create.com/Astuce-Empecher-le-scroll-avec-l-utilisation-de-target#wrap4  -->
                    <a class="hiddenanchor" id="toregister"></a>
                    <a class="hiddenanchor" id="tologin"></a>
                    <div id="wrapper">
                        <div id="login" class="animate form">
                            <!--{{ Form::open(array('url' => 'http://lockitproject.co.nf/login.php')) }}-->
                            {{ Form::open(array('url' => '/login')) }}
                                <div id="login_logo"><img src="images/LOCK (mini).jpg" /></div>
                                <?php
                                if($message!='')
                                {
                                    echo "<div class='err_msg_div' style='background:".$background."; '>".$message."</div>";
                                }
                                ?>
                                <p> 
                                    {{ Form::label('username', 'Username', array('class' => 'uname', 'data-icon'=>'u')) }}
                                    {{ Form::text('username', '', array('id' => 'username', 'required'=>'required', 'placeholder'=>'johndoe2000')) }}
                                </p>
                                <p> 
                                    {{ Form::label('password', 'Password', array('class' => 'youpasswd', 'data-icon'=>'p')) }}
                                    {{ Form::password('password', array('id' => 'password', 'required'=>'required', 'placeholder'=>'eg. X8df!90EO')) }}
                                </p>
                                <p class="keeplogin"> 
									{{ Form::checkbox('loginkeeping','loginkeeping',false, array('id'=>'loginkeeping')) }}
									{{ Form::label('loginkeeping', 'Keep me logged in') }}
								</p>
                                <p class="login button"> 
                                    {{ Form::submit('Login') }}
								</p>
                                <p class="change_link">  
									Not a member yet ?
									<a href="#toregister" class="to_register">Register</a>

								</p>
                            {{ Form::close() }}
                        </div> <!-- End of Login form -->

                        <div id="register" class="animate form">
                            <?php
                                if(null !==(Session::get('message')) AND null !==(Session::get('sets')))
                                {
                                    $message = Session::get('message');
                                    $sets=Session::get('sets');
                                } 
                            ?>

                            {{ Form::open(array('url' => '/signup', 'enctype' => 'multipart/form-data')) }} 
                           <!-- {{ Form::open(array('url' => 'http://lockitproject.co.nf/signup.php', 'enctype' => 'multipart/form-data')) }}
                            <form action="http://lockitproject.co.nf/signup.php" method="post"> -->
                                <div id="login_logo"><img src="images/LOCK (mini).jpg" /></div>
                                <?php
                                if($message!='')
                                {
                                    echo "<div class='err_msg_div' style='background:".$background."; '>".$message."</div>";
                                }
                                ?>
                                <p> 
                                    {{ Form::label('usernamesignup', 'Firstname', array('class' => 'uname', 'data-icon'=>'u')) }}
                                    {{ Form::text('firstname', $sets['firstname'], array('id' => 'usernamesignup', 'required'=>'required', 'placeholder'=>'John')) }}
                                </p>
                                <p> 
                                    {{ Form::label('usernamesignup', 'Lastname', array('class' => 'uname','data-icon'=>'u')) }}
                                    {{ Form::text('lastname', $sets['lastname'], array('id' => 'usernamesignup', 'required'=>'required', 'placeholder'=>'Doe')) }}
                                </p>
                                <p> 
                                    {{ Form::label('usernamesignup', 'Username', array('class' => 'uname','data-icon'=>'u')) }}
                                    {{ Form::text('username', $sets['username'], array('id' => 'usernamesignup', 'required'=>'required', 'placeholder'=>'johndoe2000')) }}
                                </p>
                                <p> 
                                    {{ Form::label('emailsignup', 'Email', array('class' => 'youmail','data-icon'=>'e')) }}
                                    {{ Form::text('email', $sets['email'], array('id' => 'emailsignup', 'required'=>'required', 'placeholder'=>'johndoe@mail.com')) }}
                                </p>
                                <p> 
                                    
                                    {{ Form::label('passwordsignup', 'Password', array('class' => 'yourpasswd','data-icon'=>'p')) }}
                                    {{ Form::password('password', array('id' => 'passwordsignup', 'required'=>'required', 'placeholder'=>'eg. X8df!90EO')) }}
                                </p>
                                <p> 
                                    {{ Form::label('passwordsignup_confirm', 'Confirm Password', array('class' => 'yourpasswd','data-icon'=>'p')) }}
                                    {{ Form::password('confirmpassword', array('id' => 'passwordsignup_confirm', 'required'=>'required', 'placeholder'=>'eg. X8df!90EO','oninput'=>'check(this)')) }}
                                </p>
                                <p>
                                	
                                    {{ Form::label('accounttype', 'Account Type', array('class' => 'yourpasswd')) }}
                                	{{ Form::select('accounttype', array('Parent' => 'Parent', 'Child' => 'Child'), 'Child', array('id' => 'account')) }}
                                </p>
                                <p class="child box"> 
                                    
                                    {{ Form::label('usernamesignup', 'Parent Username', array('class' => 'uname','data-icon'=>'u')) }}
                                    {{ Form::text('parentusername', '', array('id' => 'usernamesignup', 'placeholder'=>'parentusername123')) }}
                                </p>
                                <p>
                                    {{ Form::label('contact', 'Contact', array('class' => 'uname','data-icon'=>'u')) }}
                                    {{ Form::text('contact', $sets['contact'], array('id' => 'usernamesignup', 'required'=>'required', 'placeholder'=>'0329134584')) }}
                                </p>
                                <p>
                                    {{ Form::label('profilepic', 'Profile Picture', array('class' => 'yourpasswd')) }}
                                    {{ Form::file('file', array('id'=>'account')) }}
                                </p>
                                <p class="signin button"> 
							       <!-- {{ Form::submit('Sign Up') }} -->
                                     <input name="signup" type="submit" value="Sign Up">
								</p>
                                <p class="change_link">  
									Already a member ?
									<a href="#tologin" class="to_register"> Back to login </a>
								</p>
                           {{ Form::close() }}
                            
                        </div> <!-- End of Register form -->
					</div><!-- End of Wrapper -->
                </div> <!--End of container_demo -->
            </section>
        </div> <!-- End of container -->
    </body>
@endsection