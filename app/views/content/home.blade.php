@extends('layout.master')

@section('load') 
<link rel="stylesheet" type="text/css" href="css/general.css" />
<script type="text/javascript" src="javascript/home_slideshow.js"></script>

<link rel="stylesheet" type="text/css" media="only screen and (min-width:901px)" href="css/lock_large.css" />
<link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width: 400px)" href="css/lock_small.css" />
<link rel="stylesheet" type="text/css" media="only screen and (min-width:401px) and (max-width: 900px)" href="css/lock_medium.css" />

<script type="text/javascript" src="javascript/jquery/jquery.js"></script>
<script type="text/javascript" src="javascript/jquery/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery/jquerycss.css" />

<script>//#accordion

  $(function() {
    $( "#accordion" ).accordion({
    	active:false,
    	collapsible: true
    });

  });


</script>
@endsection

@section('content')
<body onload="javascript:swapImage();">
	<div id="container">
		
			<div id="header">
				<a href="http://localhost:8000"><img src="images/LOCK.jpg" /></a>
				<div id="header_user">
					<a href="#"><img src="{{ 'profilepics/'.$user['picture'] }}" /></a>
					<div class="header_user_div">
						<div class="username">{{ $user['firstname']." ".$user['lastname'] }}</div>
						<div class="header_menu">
							<a href="#">Settings</a>
							&nbsp;
							{{ HTML::linkRoute('logout', 'Logout') }}
						</div>
					</div>
				</div>

			</div><!--End of header-->

			<div class="nav">
				<div id='menu'>
					<ul>
					   <li><a href='http://localhost:8000/home'><span>Home</span></a></li>
					   <li><a href='http://localhost:8000/profile'><span>Profile</span></a></li>
					<?php 
					if($user['accttype']=="Parent")
					{
					?>
					   <li><a href='http://localhost:8000/dashboard'><span>Child Management</span></a></li>
					<?php
					}
					?>	
					<?php 
					if($user['accttype']=="Child")
					{
					?>
					   <li><a href='#'><span>Activity</span></a></li>
					<?php
					}
					?>
					   <li><a href='#'><span>Services</span></a></li>
					   <li><a href='#'><span>Support</span></a></li>
					</ul>
				</div><!--End of cssmenu-->
			</div><!--End of nav-->
		
		<div id="banner">
			<img name="slide" src="banner/large_banner.jpg" />
		</div><!--End of banner-->
		<div class="partner">
			
			<div class="partner_img_div"><img src="images/usjr2.jpg" /></div>
		</div>
		<div id="content">
			<div id="accordion">
				<h1>Basics</h1>
				<div class="section one">
				    <h2>What is LOCK?</h2>
				    <p>LOCK is a parental content control portal that controls the contents being accessed by a specific user through a proxy servlet application. The users of this system is consisting of two, the parent and the child. The parent account is in control of the child account(s), which also includes the specific net browsing limitations of every child user.
				    </p>
				    <h4>Features of this system includes:</h4>
				    <ul>
				    	<li><b>Social Monitoring</b>: social networking sites</li>
				    	<li><b>Safe-Search Technology</b>: Block harmful contents from search results.</li>
				    	<li><b>Browse Time Control</b>: Limit the browsing time of the user's devices.</li>
				    	<li><b>Web Filtering</b>: Avoid matured and adult sites, specifically for minor users</li>
				    	<li><b>Web-based dashboard</b>: View and manage their activities anywhere.</li>
				    </ul>
				   
				    <h2>How to use the portal?</h2>
				    <p>Let us first know how this system works. The LOCK portal consists of three systems, the desktop application, web system and the Android application. 
				    The desktop application, a backend system that serves as the LOCK server and proxy servlet. The web system, a web-based dashboard where the user can keep 
				    track of the summary, activity timeline, web activity of the monitored user. While the Android app also serves as a dashboard for mobile phones.   </p>
				
				    <h4>Steps for using the portal</h4>
				    <ul>
				    	<li>Download and Install the LOCK desktop application to the system unit the portal is used. (instructions are stated below)</li>
				    	<li>If you are still not registered, do it now! Make an account for parent and child. <a href="#" style="text-decoration: none"><font color="#0174DF" >click here</font></a></li>
				    	<li>Once the LOCK application is already installed, it will automatically redirect you to LOCK webpage during windows startup</li>
				    	<li>The web system and mobile application serves as your user's dashboard.</li>
				    </ul>
				</div>
				<h1>Installation</h1>
				<div class="section two">
				    
				</div>
				<h1>Manage</h1>
				<div class="section three">
				    
				</div>
				<h1>Protect</h1>
				<div class="section four">
				    
				</div>
			</div><!--End of accordion-->		

		</div><!--End of content-->
		<div id="footer">
			<div class="label_div"><label>All Rights Reserved WADDC</label></div>
		</div>
	</div><!--End of container-->
</body>
@endsection