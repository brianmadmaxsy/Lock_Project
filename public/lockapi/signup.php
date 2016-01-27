<?php

//POST data
$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$username=$_POST['username'];
$email=$_POST['email'];
$password=$_POST['password'];
$cpassword=$_POST['confirmpassword'];
$at=$_POST['accounttype'];
$parentusername=$_POST['parentusername'];
$contact=$_POST['contact'];
$picture=$_POST['file'];
//End of POST data

$userid=bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM))."=".$username."+".$at;

$occupation="Please specify";
$gender="Please specify";
$birthday="Please specify";
$city="Please specify";
$home="Please specify";

$pw=md5($password);
//$mysqli = new mysqli('localhost', 'root', '', 'lock'); //for localhost
$mysqli = new mysqli('fdb14.biz.nf', '2040664_lock', '', '2040664_lock');
		    /* check connection */
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}
	if($password==$cpassword)
	{
		if($at=="Parent")
		{
		    $stmt = $mysqli->prepare("INSERT INTO user(userid,firstname,lastname,username,password,email,contact,accttype,picture,occupation,gender,birthday,city,home) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		    $stmt->bind_param('ssssssssssssss', $userid,$firstname,$lastname,$username,$pw,$email,$contact,$at,$picture,$occupation,$gender,$birthday,$city,$home);   // bind $sample to the parameter

		    /*
		    $sample = isset($_POST['sample'])
		              ? $_POST['sample']
		              : '';
			*/
		    /* execute prepared statement */
		    $stmt->execute();

		    //printf("%d Row inserted.\n", $stmt->affected_rows);

		    /* close statement and connection */
		    $stmt->close();

	    	$parentid=bin2hex(mcrypt_create_iv(10, MCRYPT_DEV_URANDOM))."+".$userid;
			$membership="";
			$membership_status="";
	    	
	    	$stmt2 = $mysqli->prepare("INSERT INTO parent(userid,parentid,membership,membership_status) VALUES (?,?,?,?)");
		    $stmt2->bind_param('ssss', $userid,$parentid,$membership,$membership_status);   // bind $sample to the parameter

		    /*
		    $sample = isset($_POST['sample'])
		              ? $_POST['sample']
		              : '';
			*/
		    /* execute prepared statement */
		    $stmt2->execute();

		    /* close statement and connection */
		    $stmt2->close();
		    $response['status']="success";
			$response['message']="Account inserted to database";
			echo json_encode($response);
	    } //if($at=="parent")

	    else if($at=="Child")
	    {
	    	if ($stmt0 = mysqli_prepare($mysqli, "SELECT userid,accttype FROM user WHERE username=?")) 
			{
			    /* bind parameters for markers */
			    mysqli_stmt_bind_param($stmt0, "s", $parentusername);

			    /* execute query */
			    mysqli_stmt_execute($stmt0);

			    /* bind result variables */
			    mysqli_stmt_bind_result($stmt0, $temp_userid,$temp_accttype);

			    /* fetch value */
			    mysqli_stmt_fetch($stmt0);

			    //printf("%s is in district %s\n", $city, $district);
			    //echo "User ID: ".$userid."<br />"."Firstname: ".$firstname."<br />"."Lastname: ".$lastname;
			    
			    if($temp_userid!="" AND $temp_accttype=="Parent")
			    {
			    	$pw=md5($password);
					$mysqli = new mysqli('localhost', 'root', '', 'lock');

				    /* check connection */
				    if (mysqli_connect_errno()) {
				        printf("Connect failed: %s\n", mysqli_connect_error());
				        exit();
				    }

				    $stmt = $mysqli->prepare("INSERT INTO user(userid,firstname,lastname,username,password,email,contact,accttype,picture,occupation,gender,birthday,city,home) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
				    $stmt->bind_param('ssssssssssssss', $userid,$firstname,$lastname,$username,$pw,$email,$contact,$at,$picture,$occupation,$gender,$birthday,$city,$home);   // bind $sample to the parameter

				    /*
				    $sample = isset($_POST['sample'])
				              ? $_POST['sample']
				              : '';
					*/
				    /* execute prepared statement */
				    $stmt->execute();

				    //printf("%d Row inserted.\n", $stmt->affected_rows);

				    /* close statement and connection */
				    $stmt->close();

				    $childid=bin2hex(mcrypt_create_iv(15, MCRYPT_DEV_URANDOM))."+".$userid;
					$computerid=bin2hex(mcrypt_create_iv(10, MCRYPT_DEV_URANDOM))."computer".bin2hex(mcrypt_create_iv(10, MCRYPT_DEV_URANDOM))."*".$username;
					$status="disabled";
			    	
			    	$stmt2 = $mysqli->prepare("INSERT INTO child(userid,childid,computerid,parentusername,status) VALUES (?,?,?,?,?)");
				    $stmt2->bind_param('sssss', $userid,$childid,$computerid,$parentusername,$status);   // bind $sample to the parameter

				    /*
				    $sample = isset($_POST['sample'])
				              ? $_POST['sample']
				              : '';
					*/
				    /* execute prepared statement */
				    $stmt2->execute();

				    /* close statement and connection */
				    $stmt2->close();

				    $response['status']="success";
				    $response['message']="Account inserted to database";
				    echo json_encode($response);
			    }//if($temp_userid!="" AND $temp_accttype=="Parent")
			    else{
			    	$response['status']="failed";
			    	$response['message']="Parent Account not found";

			    	echo json_encode($response);
			    }
			    

			    /* close statement */
			    mysqli_stmt_close($stmt0);
			}
	    }

	    
	    
	}
	/* close connection */
   $mysqli->close(); 


?>