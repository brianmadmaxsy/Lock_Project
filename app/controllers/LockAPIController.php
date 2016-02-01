<?php

class LockAPIController extends BaseController{

	public function user_api()
	{
		$users = DB::table('user')->get();
		print_r(json_encode($response['user']=$users));
		//return json_encode($response['user']=$users);
	}
	public function parent_api()
	{
		$parent = DB::table('user')
            ->leftJoin('parent', 'user.userid', '=', 'parent.userid')
            ->where('user.accttype','=','Parent')
            ->get();
        return json_encode($response['parent']=$parent);
	}
	public function child_api()
	{
		$child = DB::table('user')
            ->leftJoin('child', 'user.userid', '=', 'child.userid')
            ->where('user.accttype','=','Child')
            ->get();
        return json_encode($response['child']=$child);
	}
	public function login() //login function
	{
		try
		{
		   	$username=Input::get('username');
			$password=Input::get('password');
			$pword=md5($password);
			
			//Select statement if username matched with (convert to md5)password is in database. Then set session file
			$user = UserModel::where('username','=',$username)->where('password','=',$pword)->first();
			if($user!="")//if user exists
			{
				//session, get data using the inputed username and password
				$user = UserModel::where('username','=',$username)->first();
				Session::put('sess_api_user_arr',$user);
				$response['status']="success";
		    	$response['message']="Account found";
		    	$response['userid']=$user['userid'];
			    $response['firstname']=$user['firstname'];
			    $response['lastname']=$user['lastname'];
			    $response['username']=$user['username'];
			    $response['password']=$user['password'];
			    $response['email']=$user['email'];
			    $response['contact']=$user['contact'];
			    $response['accttype']=$user['accttype'];
			    $response['picture']=$user['picture'];
			    $response['occupation']=$user['occupation'];
			    $response['gender']=$user['gender'];
			    $response['birthday']=$user['birthday'];
			    $response['city']=$user['city'];
			    $response['home']=$user['home'];

			    echo json_encode($response);
			}
			else //If user did not exist
			{
				$response['status']="failed";
		    	$response['message']="Invalid Username and Password";

		    	echo json_encode($response);
			}
		}
		catch(Exception $e)
		{
			$response['status']="failed";
		    $response['message']=$e;
			echo json_encode($response);
		}
		
	}
	public function checklogin()
	{
		$user=Session::get('sess_api_user_arr');
		if($user!="")
		{
			$response['status']="success";
		    $response['message']="Account is logged in";
			echo json_encode($response);
		}
		else{
			$response['status']="failed";
			$response['message']="Account is not logged in";
			echo json_encode($response);
		}
	}
	//end of login function

	public function samplelogin()
	{
		$username=Input::get('username');
		$password=Input::get('password');

		$response['status']="success";
		$response['message']="You have sent a post data!";
		$response['username']=$username;
		$response['password']=$password;
		echo json_encode($response);
	}
	public function signup()
	{
		
		$firstname=Input::get('firstname');
		$lastname=Input::get('lastname');
		$username=Input::get('username');
		$email=Input::get('email');
		$password=Input::get('password');
		$cpassword=Input::get('confirmpassword');
		$at=Input::get('accounttype');
		$parentusername=Input::get('parentusername');
		$contact=Input::get('contact');
		$picture="";
		
		

		if($password==$cpassword)
		{
			$user_check = UserModel::where('username','=',$username)->first();
			if($user_check=="") //if username not in database
			{
				$userid=bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM))."=".$username."+".$at;
				if($at=="Parent")
				{
					if(Input::hasFile('file')) //If this is a file uploaded
					{
						//upload profile picture and set filename to a variale to save to db
						$file=Input::file('file');
						$filename=bin2hex(mcrypt_create_iv(10, MCRYPT_DEV_URANDOM))."".$username."-".$file->getClientOriginalName();
						$file->move('public/profilepics',$filename);

						$picture=$filename;
					}
					else
					{
						//set picture to null
						$picture="images/user.png";
					}
					//save as parent account
					//$pw=Hash::make($password);
					$pw=md5($password);
					
					$user=new UserModel;
					$user->userid=$userid;
					$user->firstname=$firstname;
					$user->lastname=$lastname;
					$user->username=$username;
					$user->password=$pw;
					$user->email=$email;
					$user->contact=$contact;
					$user->accttype=$at;
					$user->picture=$picture;
					$user->occupation='Please specify';
					$user->gender='Please specify';
					$user->birthday='Please specify';
					$user->city='Please specify';
					$user->home='Please specify';
					$user->save();

					$parentid=bin2hex(mcrypt_create_iv(10, MCRYPT_DEV_URANDOM))."+".$userid;
					$membership="";
					$membership_status="";

					$parent=new ParentModel;
					$parent->userid=$userid;
					$parent->parentid=$parentid;
					$parent->membership=$membership;
					$parent->membership_status=$membership_status;
					$parent->save();

					$message="Parent Registration Successful!";
					$response['status']="success";
				    $response['message']=$message;
					echo json_encode($response);
				}//end of if($at=="Parent")

				elseif($at=="Child")
				{
					$temp_at=""; //setting $temp_at as null in default.
					//check if parentusername in database
					$user = UserModel::where('username','=',$parentusername)->first();
					$temp_at=$user['accttype'];

					if($temp_at=="" OR $temp_at=="Child")
					{
						$return_sets=array(
						'firstname'=>$firstname,
						'lastname'=>$lastname,
						'username'=>$username,
						'email'=>$email,
						'contact'=>$contact
						);
						//return Redirect::intended('http://lock-lockitproject.rhcloud.com/#toregister')->with('message', 'Parent Username not found!')->with('sets', $return_sets);
						$message="Parent Username not found!";
						$response['status']="failed";
					    $response['message']=$message;
						echo json_encode($response);
					}
					else
					{
						if(Input::hasFile('file')) //If this is a file uploaded
						{
							//upload profile picture and set filename to a variale to save to db
							$file=Input::file('file');
							$filename=bin2hex(mcrypt_create_iv(10, MCRYPT_DEV_URANDOM))."".$username."-".$file->getClientOriginalName();
							$file->move('public/profilepics',$filename);

							$picture=$filename;
						}
						else
						{
							//set picture to null
							$picture="images/user.png";
						}
						$pw=md5($password);
					
						//For User Database
						$user=new UserModel;
						$user->userid=$userid;
						$user->firstname=$firstname;
						$user->lastname=$lastname;
						$user->username=$username;
						$user->password=$pw;
						$user->email=$email;
						$user->contact=$contact;
						$user->accttype=$at;
						$user->picture=$picture;
						$user->occupation='Please specify';
						$user->gender='Please specify';
						$user->birthday='Please specify';
						$user->city='Please specify';
						$user->home='Please specify';
						$user->save();

						$childid=bin2hex(mcrypt_create_iv(15, MCRYPT_DEV_URANDOM))."+".$userid;
						$computerid=bin2hex(mcrypt_create_iv(10, MCRYPT_DEV_URANDOM))."computer".bin2hex(mcrypt_create_iv(10, MCRYPT_DEV_URANDOM))."*".$username;
						$status="";
						
						//For Child database
						$child=new ChildModel;
						$child->userid=$userid;
						$child->childid=$childid;
						$child->computerid=$computerid;
						$child->parentusername=$parentusername;
						$child->status=$status;
						$child->save();
						//For Computer Database
						$os_username="";
						$domain_name="";
						$sid="";

						$computer=new ComputerModel;
						$computer->computerid=$computerid;
						$computer->username=$os_username;
						$computer->domainname=$domain_name;
						$computer->sid=$sid;
						$computer->save();

						
						//return View::make('content.entry')->with('message',$message)->with('background','#A9F5A9')->with('sets',$this->sets);
						$message="Child Registration Successful!";
						$response['status']="success";
					    $response['message']=$message;
						echo json_encode($response);
					}
				}//end of elseif($at=="Child")
			}
			elseif($user_check!="") //if username is already taken
			{
				$return_sets=array(
					'firstname'=>$firstname,
					'lastname'=>$lastname,
					'username'=>$username,
					'email'=>$email,
					'contact'=>$contact
				);
				//return Redirect::intended('http://localhost:8000/#toregister')->with('message', 'Username is already taken!')->with('sets', $return_sets);
				$message="Username already taken";
				$response['status']="failed";
				$response['message']=$message;
				echo json_encode($response);
			}
		} // end of if($password==$cpassword)
	}//end of signup

	public function editprofile()
	{
		
		$occupation=Input::get('edit_occupation');
		$gender=Input::get('edit_gender');
		$bday=Input::get('edit_birthday');
		$email=Input::get('edit_email');
		$contact=Input::get('edit_contact');
		$city=Input::get('edit_city');
		$home=Input::get('edit_home');

		$user=Session::get('sess_api_user_arr');
		$userid=$user['userid'];

		$user=UserModel::where('userid',$userid);
		$user->update(['email'=>$email,'contact'=>$contact,'occupation'=>$occupation,'gender'=>$gender,'birthday'=>$bday,'city'=>$city,'home'=>$home]);

		Session::forget('sess_api_user_arr'); //Trash the old session
		
		//Getting the newly updated UserModel row and save it to a new session
		$user = UserModel::where('userid','=',$userid)->first(); //Get updated row in database after upload picture
		Session::put('sess_api_user_arr',$user); //Save session similar to the session name of before's session.
		
		$response['status']="success";
		$response['message']="Account profile updated!";
		$response['userid']=$user['userid'];
		$response['firstname']=$user['firstname'];
		$response['lastname']=$user['lastname'];
		$response['username']=$user['username'];
		$response['password']=$user['password'];
		$response['email']=$user['email'];
		$response['contact']=$user['contact'];
		$response['accttype']=$user['accttype'];
		$response['picture']=$user['picture'];
		$response['occupation']=$user['occupation'];
		$response['gender']=$user['gender'];
		$response['birthday']=$user['birthday'];
		$response['city']=$user['city'];
		$response['home']=$user['home'];

		echo json_encode($response);
	}

	public function editpp()
	{
			if(Input::hasFile('file')) //If this is a file uploaded
			{
				//upload profile picture and set filename to a variale to save to db
				$user=Session::get('sess_api_user_arr');

				$get_userid=$user['userid'];
				
				$file=Input::file('file');
				$filename=bin2hex(mcrypt_create_iv(10, MCRYPT_DEV_URANDOM))."".$get_userid."-".$file->getClientOriginalName()."_".rand(1,100);
				$file->move('public/profilepics',$filename);

				$picture=$filename;


				$user=UserModel::where('userid',$get_userid);
				$user->update(['picture'=>$picture]);
				/*
				This part needs to trash the old session that holds the UserModel row being
				processed during login. 
				*/
				Session::forget('sess_api_user_arr'); //Trash the old session

				//Getting the newly updated UserModel row and save it to a new session
				$user = UserModel::where('userid','=',$get_userid)->first(); //Get updated row in database after upload picture
				Session::put('sess_api_user_arr',$user); //Save session similar to the session name of before's session.
				
				//return Redirect::intended('http://lock-lockitproject.rhcloud.com/profile');

				$response['status']="success";
				$response['message']="Profile picture updated!";
				$response['userid']=$user['userid'];
				$response['firstname']=$user['firstname'];
				$response['lastname']=$user['lastname'];
				$response['username']=$user['username'];
				$response['password']=$user['password'];
				$response['email']=$user['email'];
				$response['contact']=$user['contact'];
				$response['accttype']=$user['accttype'];
				$response['picture']=$user['picture'];
				$response['occupation']=$user['occupation'];
				$response['gender']=$user['gender'];
				$response['birthday']=$user['birthday'];
				$response['city']=$user['city'];
				$response['home']=$user['home'];

				echo json_encode($response);
			}
			else
			{
				$response['status']="failed";
				$response['message']="Profile picture not updated!";
				echo json_encode($response);
			}
	}

	public function view_home() //This is the very start
	{
		//if (Auth::check())
		$user=Session::get('sess_api_user_arr');
		if($user!="")
		{
			/*
			$children = DB::table('user')
            ->leftJoin('child', 'user.userid', '=', 'child.userid')
            ->where('child.parentusername','=',$user['username'])
            ->get();
			//return View::make('content.home')->with('user',$user)->with('children',$children);
			*/
			$response['status']="success";
				$response['message']="User is still online.";
				$response['userid']=$user['userid'];
				$response['firstname']=$user['firstname'];
				$response['lastname']=$user['lastname'];
				$response['username']=$user['username'];
				$response['password']=$user['password'];
				$response['email']=$user['email'];
				$response['contact']=$user['contact'];
				$response['accttype']=$user['accttype'];
				$response['picture']=$user['picture'];
				$response['occupation']=$user['occupation'];
				$response['gender']=$user['gender'];
				$response['birthday']=$user['birthday'];
				$response['city']=$user['city'];
				$response['home']=$user['home'];

				echo json_encode($response);
		}
		else{
			//return View::make('content.entry')->with('message','Oops, you are not logged in yet!')->with('background','#F6CECE')->with('sets',$this->sets);
			$response['status']="failed";
			$response['message']="User not found";
			echo json_encode($response);
		}
	}

	public function logout()
	{
		Session::flush();
		$response['status']="success";
		$response['message']="Userlogged out";
		echo json_encode($response);
	}
}

?>