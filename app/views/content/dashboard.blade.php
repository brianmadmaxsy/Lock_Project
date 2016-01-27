@extends('layout.master')

@section('load') 
<link rel="stylesheet" type="text/css" href="css/general.css" />

<link rel="stylesheet" type="text/css" media="only screen and (min-width:901px)" href="css/lock_large.css" />
<link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width: 400px)" href="css/lock_small.css" />
<link rel="stylesheet" type="text/css" media="only screen and (min-width:401px) and (max-width: 900px)" href="css/lock_medium.css" />

<!--Jquery Files-->
<script type="text/javascript" src="javascript/jquery/jquery.js"></script>
<script type="text/javascript" src="javascript/jquery/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery/jquerycss.css" />

<script type="text/javascript" src="javascript/tab.js"></script>

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
			<div id="dashboard_tab">
				<ul>
				<?php
				$counter=0;
				foreach($children as $child)
				{
				  	$counter+=1;
				?>
				    <li><a href="{{ '#tabs-'.$counter }}" >{{ $child->firstname }}</a></li>
				<?php
				}
				?>
				</ul>

				<?php
				$count=0;
				foreach($children as $child)
				{
				  	$count+=1;
				?>
				<div id="{{ 'tabs-'.$count }}">
					<div class="child_profile_content">
					<div id="child_pp_div"><img src="{{'profilepics/'.$child->picture}}" /></div>
					<div id="child_profile_info">
						<a href="#" title="Edit Profile"><div id="child_edit_icon_div"><img src="images/edit2.png" /></div></a>
						<a href="#" title="Delete Profile"><div id="child_delete_icon_div"><img src="images/delete.png" /></div></a>
						<table>
							<tr>
								<td colspan="2"><h3>{{ $child->firstname." ".$child->lastname }}</h3></td>
							</tr>
							<tr>
								<td class="field_names">Account Type</td>
								<td>{{ $child->accttype }}</td>
							</tr>
							<tr>
								<td class="field_names">Occupation</td>
								<td>{{ $child->occupation }}</td>
							</tr>
							<tr>
								<td class="field_names">Gender</td>
								<td>{{ $child->gender }}</td>
							</tr>
							<tr>
								<td class="field_names">Birthday</td>
								<td>{{ $child->birthday }}</td>
							</tr>
							<tr>
								<td class="field_names">Email</td>
								<td>{{ $child->email }}</td>
							</tr>
							<tr>
								<td class="field_names">Contact</td>
								<td>{{ $child->contact }}</td>
							</tr>
							
							<tr>
								<td class="field_names">Current City</td>
								<td>{{ $child->city }}</td>
							</tr>
							<tr>
								<td class="field_names">Home Town</td>
								<td>{{ $child->home }}</td>
							</tr>
							
							
						</table>
						
					</div><!--End of child_profile_info-->
					
					</div><!--End of child_profile_content-->

					<div id="child_blacklist_div">
						<div class="header">
							<div class="header_title"><b>Blocklist</b></div>
						</div>
						<div class="sitelist">
							
							<table class="site_div">
							<?php
							foreach($blocklist as $block)
							{
								if($block->childid==$child->childid)
								{
							?>
								{{ Form::open(array('url' => '/deletesite')) }}
								<!--<div class="site_div">-->
								<tr>
									<td style="width:200px"><label>{{ $block->website }}</label></td>
									<td>
										<input name="get_blockid" type="hidden" value="{{ $block->blockid }}">
										<input name="delete" type="submit" value="Remove" onclick="return confirm('Delete website from blocklist?')" />
									</td>
								</tr>	
								<!--</div>-->
								{{ Form::close() }}
							<?php
								}
							}
							?>
							</table>
							
						</div>
						
						<div class="function">
							<form action="/addsite" method="post">
							<label>Add Website</label>
							<input name="website" type="text" value="" />
							<input name="get_childid" type="hidden" value="{{ $child->childid }}" /> 
							<input name="get_parent" type="hidden" value="{{ $child->parentusername }}">
							<input name="addsite" type="submit" value="Add">
							</form>
						</div>
					</div>

				</div><!--End of tabs-->
				<?php
				  }
				?>
			</div><!--End of <div id="dashboard_tab>-->
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