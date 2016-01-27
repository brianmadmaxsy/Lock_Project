@extends('layout.master')

@section('load') 
<link rel="stylesheet" type="text/css" href="css/general.css" />

<link rel="stylesheet" type="text/css" media="only screen and (min-width:901px)" href="css/lock_large.css" />
<link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width: 400px)" href="css/lock_small.css" />
<link rel="stylesheet" type="text/css" media="only screen and (min-width:401px) and (max-width: 900px)" href="css/lock_medium.css" />

<script type="text/javascript" src="javascript/jquery/jquery.js"></script>
<script type="text/javascript" src="javascript/jquery/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery/jquerycss.css" />


<script>
  $(function() {
    $( "#profile_accordion" ).accordion({
    	//active:true,
    	collapsible: true
    });

  });
</script>
@endsection

@section('content')
<body>
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
					   <li><a href='http://localhost:8000/dashboard'><span>Dashboard</span></a></li>
					   <?php
						}
					   ?>
					   <li><a href='#'><span>Services</span></a></li>
					   <li><a href='#'><span>Support</span></a></li>
					</ul>
				</div><!--End of cssmenu-->
			</div><!--End of nav-->
		
		<div id="content">
				<div class="child_profile_content">
					<div id="child_pp_div"><img src="images/user.png" /></div>
					<div id="child_profile_info">
						<a href="#" title="Edit Profile"><div id="child_edit_icon_div"><img src="images/edit2.png" /></div></a>
						<a href="#" title="Delete Profile"><div id="child_delete_icon_div"><img src="images/delete.png" /></div></a>
						<table>
							<tr>
								<td colspan="2"><h3>Lauren Brian Sy</h3></td>
							</tr>
							<tr>
								<td class="field_names">Account Type</td>
								<td>Child</td>
							</tr>
							<tr>
								<td class="field_names">Occupation</td>
								<td>Student</td>
							</tr>
							<tr>
								<td class="field_names">Gender</td>
								<td>Male</td>
							</tr>
							<tr>
								<td class="field_names">Birthday</td>
								<td>05/27/1994</td>
							</tr>
							<tr>
								<td class="field_names">Email</td>
								<td>brianmadmaxsy@gmail.com</td>
							</tr>
							<tr>
								<td class="field_names">Contact</td>
								<td>09228813555</td>
							</tr>
							
							<tr>
								<td class="field_names">Current City</td>
								<td>Cebu City</td>
							</tr>
							<tr>
								<td class="field_names">Home Town</td>
								<td>Cebu City, Philippines</td>
							</tr>
							
							
						</table>
						
					</div><!--End of profile_info-->
				</div><!--End of profile content-->
				
				<div id="profile_accordion">
					<h1>Work and Education</h1>
					<div class="section one" >
					    <div class="education_detail"> 
					    	<div id="education_icon"><img src="images/education.png" /></div>
					    	<div id="education_content">
					    		<div class="school_name"><a href="#">University of San Jose Recoletos</a></div>
					    		<div class="school_attended">Class of 2010-2015</div>
					    	</div>
					    </div>
					    <div class="work_detail"> 
					    	<div id="work_icon"><img src="images/work.png" /></div>
					    	<div id="work_content">
					    		<div class="work_name"><a href="#">Taking You Forward Inc</a></div>
					    		<div class="work_attended">Employed 2014</div>
					    	</div>
					    </div>
					</div>
				</div>
		</div><!--End of content-->
		
		<div class="partner">
			
			<div class="partner_img_div"><img src="images/usjr2.jpg" /></div>
		</div>
		
		<div id="footer">
			<div class="label_div"><label>All Rights Reserved WADDC</label></div>
		</div>
	</div><!--End of container-->
</body>
@endsection