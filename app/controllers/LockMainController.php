<?php

class LockMainController extends BaseController{

	public $sets=array( //This is to null the field variables in registration page
		'firstname'=>'',
		'lastname'=>'',
		'username'=>'',
		'email'=>'',
		'contact'=>''
		);

	//Login
	public function index()
	{

		
		$user=Session::get('sess_user_arr');
		if($user!="")
		{
			return View::make('content.home')->with('user',$user);
		}
		else{
			return View::make('content.entry')->with('message','')->with('background','#F6CECE')->with('sets',$this->sets);
		}
		
	}
	public function login()
	{
		try
		{
		   	$username=Input::get('username');
			$password=Input::get('password');
			/*
			$userdata=array(
				'username'=>$username,
				'password'=>$password
			);
			
			if(Auth::attempt($userdata,true))
			{
				//session, get data using the inputed username and password
				$user = UserModel::where('username','=',$username)->first();
				
				//echo $user['userid']."-".$user['firstname']." ".$user['lastname']."-".$user['username']."-".$user['password']."-".$user['email']."-".$user['contact']."-".$user['accttype']."-".'<img src="profilepics/'.$user['picture'].'" />.';
				Session::put('sess_user_arr',$user);
				return Redirect::intended('/home');
			}
			*/
			$pword=md5($password);
			
			//Select statement if username matched with (convert to md5)password is in database. Then set session file
			$user = UserModel::where('username','=',$username)->where('password','=',$pword)->first();
			if($user!="")//if sessionfile is not empty
			{
				//session, get data using the inputed username and password
				$user = UserModel::where('username','=',$username)->first();
				
				//echo $user['userid']."-".$user['firstname']." ".$user['lastname']."-".$user['username']."-".$user['password']."-".$user['email']."-".$user['contact']."-".$user['accttype']."-".'<img src="profilepics/'.$user['picture'].'" />.';
				Session::put('sess_user_arr',$user);
				return Redirect::intended('/home');
			}
			else{
				return View::make('content.entry')->with('message','Error: Invalid Username/Password!')->with('background','#F6CECE')->with('sets',$this->sets);
			}
		}
		catch(Exception $e)
		{
		   return View::make('content.entry')->with('message',$e)->with('background','#F6CECE')->with('sets',$this->sets);
		}
		
		
		
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
			//check if username is already in database
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
					return View::make('content.entry')->with('message',$message)->with('background','#A9F5A9')->with('sets',$this->sets);
				}//end of if(parent)
				elseif($at=="Child")
				{
					$temp_at=""; //setting $temp_at as null in default.
					//check if parentusername in database
					$user = UserModel::where('username','=',$parentusername)->first();
					$temp_at=$user['accttype'];

					if($temp_at=="" OR $temp_at=="Child")
					{
						//return Redirect::intended('http://localhost:8000/#toregister');
						$return_sets=array(
						'firstname'=>$firstname,
						'lastname'=>$lastname,
						'username'=>$username,
						'email'=>$email,
						'contact'=>$contact
						);
						//return Redirect::to('http://localhost:8000/#toregister')->with('message', 'Parent Username not found!')->with('sets', $return_sets);
						return Redirect::intended('http://localhost:8000/#toregister')->with('message', 'Parent Username not found!')->with('sets', $return_sets);
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

						$message="Parent Registration Successful!";
						return View::make('content.entry')->with('message',$message)->with('background','#A9F5A9')->with('sets',$this->sets);
					}
				}//end of elseif(child)
			} //end of if(username already in database)
			elseif($user_check!="") //if username is already taken
			{
				$return_sets=array(
					'firstname'=>$firstname,
					'lastname'=>$lastname,
					'username'=>$username,
					'email'=>$email,
					'contact'=>$contact
				);
				return Redirect::intended('http://localhost:8000/#toregister')->with('message', 'Username is already taken!')->with('sets', $return_sets);
			}
		}//end of if($password=$cpassword)
		
	}
	//End of Login

	//Home 
	public function view_home() //This is the very start
	{
		//if (Auth::check())
		$user=Session::get('sess_user_arr');
		if($user!="")
		{
			$children = DB::table('user')
            ->leftJoin('child', 'user.userid', '=', 'child.userid')
            ->where('child.parentusername','=',$user['username'])
            ->get();
			return View::make('content.home')->with('user',$user)->with('children',$children);
		}
		else{
			return View::make('content.entry')->with('message','Oops, you are not logged in yet!')->with('background','#F6CECE')->with('sets',$this->sets);
		}
	}

	//End of Home

	//Profile
	public function view_profile()//get
	{
		/*
		if (Auth::check())
		{
			$user=Session::get('sess_user_arr');
			$parent=ParentModel::where('userid','=',$user['userid'])->first();
			return View::make('content.profile')->with('user',$user)->with('parent',$parent);
		}
		*/
		$user=Session::get('sess_user_arr');
		if($user!="")
		{
			$children = DB::table('user')
            ->leftJoin('child', 'user.userid', '=', 'child.userid')
            ->where('child.parentusername','=',$user['username'])
            ->get();
			$parent=ParentModel::where('userid','=',$user['userid'])->first();
			return View::make('content.profile')->with('user',$user)->with('parent',$parent)->with('children',$children);
		}
		else{
			return View::make('content.entry')->with('message','Oops, you are not logged in yet!')->with('background','#F6CECE')->with('sets',$this->sets);

		}
	}
	public function editprofile()//post
	{
		$occupation=Input::get('edit_occupation');
		$gender=Input::get('edit_gender');
		$bday=Input::get('edit_birthday');
		$email=Input::get('edit_email');
		$contact=Input::get('edit_contact');
		$city=Input::get('edit_city');
		$home=Input::get('edit_home');

		$user=Session::get('sess_user_arr');
		$userid=$user['userid'];

		$user=UserModel::where('userid',$userid);
		$user->update(['email'=>$email,'contact'=>$contact,'occupation'=>$occupation,'gender'=>$gender,'birthday'=>$bday,'city'=>$city,'home'=>$home]);

		/*
		This part needs to trash the old session that holds the UserModel row being
		processed during login. 
		*/
		Session::forget('sess_user_arr'); //Trash the old session

		//Getting the newly updated UserModel row and save it to a new session
		$user = UserModel::where('userid','=',$userid)->first(); //Get updated row in database after upload picture
		Session::put('sess_user_arr',$user); //Save session similar to the session name of before's session.
		
		return Redirect::intended('/profile');

	}
	public function editpp(){
		
			if(Input::hasFile('file')) //If this is a file uploaded
			{
				//upload profile picture and set filename to a variale to save to db
				$user=Session::get('sess_user_arr');

				$get_userid=$user['userid'];

				$file=Input::file('file');
				$filename=bin2hex(mcrypt_create_iv(10, MCRYPT_DEV_URANDOM))."".$user['username']."-".$file->getClientOriginalName()."_".rand(1,100);
				$file->move('public/profilepics',$filename);

				$picture=$filename;


				$user=UserModel::where('userid',$user['userid']);
				$user->update(['picture'=>$picture]);
				/*
				This part needs to trash the old session that holds the UserModel row being
				processed during login. 
				*/
				Session::forget('sess_user_arr'); //Trash the old session

				//Getting the newly updated UserModel row and save it to a new session
				$user = UserModel::where('userid','=',$get_userid)->first(); //Get updated row in database after upload picture
				Session::put('sess_user_arr',$user); //Save session similar to the session name of before's session.
				
				return Redirect::intended('/profile');


			}
			else
			{
				//set picture to null
				return Redirect::intended('/profile');
			}
		
		
		
	}
	public function view_child()
	{
		/*
		if (Auth::check())
		{
			return View::make('content.viewchild');
		}
		*/
		$user=Session::get('sess_user_arr');
		if($user!="")
		{
			return View::make('content.viewchild');
		}
		else{
			return View::make('content.entry')->with('message','Oops, you are not logged in yet!')->with('background','#F6CECE')->with('sets',$this->sets);
		}
	}
	//End of Profile

	//Dashboard
	public function view_dashboard()
	{
		/*
		if (Auth::check())
		{
			$user=Session::get('sess_user_arr');
			$parent=ParentModel::where('userid','=',$user['userid'])->first();
			return View::make('content.dashboard')->with('user',$user)->with('parent',$parent);
		}*/
		$user=Session::get('sess_user_arr');
		if($user!="")
		{
			$children = DB::table('user')
            ->leftJoin('child', 'user.userid', '=', 'child.userid')
            ->where('child.parentusername','=',$user['username'])
            ->get();

            $blocklist = DB::table('blacklist')
           	->where('parentusername','=',$user['username'])
            ->get();
			
			$parent=ParentModel::where('userid','=',$user['userid'])->first();
			
			return View::make('content.dashboard')->with('user',$user)->with('parent',$parent)->with('children',$children)->with('blocklist',$blocklist);
		}
		else{
			return View::make('content.entry')->with('message','Oops, you are not logged in yet!')->with('background','#F6CECE')->with('sets',$this->sets);
		}
	}


	public function add_blocklist()
	{	$childid=Input::get('get_childid');
		$blockid=bin2hex(mcrypt_create_iv(10, MCRYPT_DEV_URANDOM))."block:".$childid;
		
		$parentusername=Input::get('get_parent');
		$website=Input::get('website');
		$status="Enabled";

		$blacklist=new BlacklistModel;
		$blacklist->blockid=$blockid;
		$blacklist->childid=$childid;
		$blacklist->parentusername=$parentusername;
		$blacklist->website=$website;
		$blacklist->blockstatus=$status;
		$blacklist->fromDate="";
		$blacklist->toDate="";
		$blacklist->save();

		return Redirect::intended('/dashboard');		
	}

	public function delete_blocklist()
	{
		$delete=Input::get('delete');

		if(isset($delete) and $delete="Remove")
		{
			$blockid=Input::get('get_blockid');

			DB::table('blacklist')->where('blockid', '=', $blockid)->delete();
			return Redirect::intended('/dashboard');
		}
	}
	//End of Dashboard

	public function logout()
	{
		Session::flush();
		Auth::logout();

		return View::make('content.entry')->with('message','')->with('background','#F6CECE')->with('sets',$this->sets);
	}
}

?>