@extends('layout.master')

@section('load') 
<link rel="stylesheet" type="text/css" href="css/general.css" />

<link rel="stylesheet" type="text/css" media="only screen and (min-width:901px)" href="css/lock_large.css" />
<link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width: 400px)" href="css/lock_small.css" />
<link rel="stylesheet" type="text/css" media="only screen and (min-width:401px) and (max-width: 900px)" href="css/lock_medium.css" />

<script type="text/javascript" src="javascript/jquery/jquery.js"></script>
<script type="text/javascript" src="javascript/jquery/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery/jquerycss.css" />
<link rel="stylesheet" href="/resources/demos/style.css">

<script>//Profile Accordion
  $(function() {
    $( "#profile_accordion" ).accordion({
    	//active:true,
    	collapsible: true
    });

  });
</script>
<script>//Edit Profile Dialog
  $(function() {
    $( "#edit_profile_dialog" ).dialog({
      modal:true,
      resizable: false,
      height:500,
      width:400,
      autoOpen: false,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });
 
    $( "#editprofile" ).click(function() {
      $( "#edit_profile_dialog" ).dialog( "open" );
    });
  });
</script>
<script>//Edit picture Dialog
  $(function() {
    $( "#edit_picture_dialog" ).dialog({
      modal:true,
      resizable: false,
      height:180,
      width:500,
      autoOpen: false,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });
 
    $( "#edit_pic" ).click(function() {
      $( "#edit_picture_dialog" ).dialog( "open" );
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
		
		<div id="content">
				<div id="edit_profile_dialog" title="Edit Profile">
					{{ Form::open(array('url' => '/editprofile')) }}
					<table style="width: 100%">
						<tr>
							<td colspan="2"><h3>{{ $user['firstname']." ".$user['lastname'] }}</h3></td>
						</tr>
						<tr>
							<td class="field_names"><label>Account Type</label></td>
							<td>{{ Form::text('edit_at', $user['accttype'], array('readonly'=>'')) }}</td>
						</tr>
						<tr>
							<td class="field_names"><label>Occupation</label></td>
							<td>{{ Form::text('edit_occupation', $user['occupation']) }}</td>
						</tr>
						<tr>
							<td class="field_names"><label>Gender</label></td>
							<td>{{ Form::text('edit_gender', $user['gender']) }}</td>
						</tr>
						<tr>
							<td class="field_names"><label>Birthday</label></td>
							<td>{{ Form::text('edit_birthday', $user['birthday']) }}</td>
						</tr>
						<tr>
							<td class="field_names"><label>Email</label></td>
							<td>{{ Form::text('edit_email', $user['email']) }}</td>
						</tr>
						<tr>
							<td class="field_names"><label>Contact</label></td>
							<td>{{ Form::text('edit_contact', $user['contact']) }}</td>
						</tr>
						<tr>
							<td class="field_names"><label>Current City</label></td>
							<td>{{ Form::text('edit_city', $user['city']) }}</td>
						</tr>
						<tr>
							<td class="field_names"><label>Home Town</label></td>
							<td>{{ Form::text('edit_home', $user['home']) }}</td>
						</tr>
						
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>

						<tr>
							<td colspan="2" class="edit_buttons">
							<input name="modify" type="submit" value="Modify" style="width: 80px">&nbsp;&nbsp;
							<input name="cancel" type="submit" value="Cancel"></td>
						</tr>
					</table>
					{{ Form::close() }} 
				</div>

				<div id="edit_picture_dialog" title="Profile Picture">
					<div>
					{{ Form::open(array('url' => '/editpp', 'enctype' => 'multipart/form-data')) }}
                    	<p>
                        {{ Form::label('profilepic', 'Change Picture') }}
                        {{ Form::file('file') }}
                        </p>
                        {{ Form::submit('Edit')."  ".Form::submit('Cancel') }}
                        
                    {{ Form::close() }}
                    </div>
				</div>

				<div class="profile_content">

					<div id="pp_div"><a href="#" id="edit_pic" title="Profile Pic"><img src="{{ 'profilepics/'.$user['picture'] }}" /></a></div>
					<div id="profile_info">
						<a href="#" id="editprofile" title="Edit Profile"><div id="edit_icon_div"><img src="images/edit2.png" /></div></a>
						<table>
							<tr>
								<td colspan="2" style="color:#086A87;"><h3>{{ $user['firstname']." ".$user['lastname'] }}</h3></td>

							</tr>
							<tr>
								<td class="field_names">Account Type</td>
								<td>{{ $user['accttype'] }}</td>
							</tr>
							<tr>
								<td class="field_names">Occupation</td>
								<td>{{ $user['occupation'] }}</td>
							</tr>
							<tr>
								<td class="field_names">Gender</td>
								<td>{{ $user['gender'] }}</td>
							</tr>
							<tr>
								<td class="field_names">Birthday</td>
								<td>{{ $user['birthday'] }}</td>
							</tr>
							<tr>
								<td class="field_names">Email</td>
								<td>{{ $user['email'] }}</td>
							</tr>

							<tr>
								<td class="field_names">Contact</td>
								<td>{{ $user['contact'] }}</td>
							</tr>
														
							<tr>
								<td class="field_names">Current City</td>
								<td>{{ $user['city'] }}</td>
							</tr>
							<tr>
								<td class="field_names">Home Town</td>
								<td>{{ $user['home'] }}</td>
							</tr>
							
							
						</table>
						
					</div><!--End of profile_info-->
				</div><!--End of profile content-->

				<div id="profile_accordion">
					<h1>Work and Education</h1>
					<div class="section one">
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
					<?php 
					   if($user['accttype']=="Parent")
					   {
					?>
					<h1>Related Accounts</h1>
					<div class="section two">
						<div class="option_child_acct_div"><div class="add_icon_div"><a href="#" title="Add Child"><img src="images/adduser.png"></a></div></div>
					    <?php
					    foreach($children as $child)
					    {

					    ?>
					    <div class="child_acct_div">
					    	<a href="#"><div><img src="{{ 'profilepics/'.$child->picture }}" height="70" width="70" /></div></a>
					    	<div class="child_acct_name"><label><font size="2">{{ $child->firstname." ".$child->lastname }}</font></label></div>
					    	<div class="child_acct_relationship"><label><font size="1">{{ $child->accttype }}</font></label></div>
					    </div>
					    <?php
						}
					    ?>
					</div><!--End of Section two-->
					<?php
						} //if(user is parent)
					?>
				</div><!--End of accordion-->
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