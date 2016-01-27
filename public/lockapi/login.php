<?php

$username=$_POST['username'];
$password=$_POST['password'];

$hash_password=md5($password);
//$link = mysqli_connect("localhost", "root", "", "lock"); //for localhost
$link = mysqli_connect("fdb14.biz.nf", "2040664_lock", "", "2040664_lock");
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

//$username="madmax";
//$password=md5("nfsmwchamp");
$userid="";
$firstname="";
$lastname="";
$email="";
$contact="";
$accttype="";
$picture="";
$occupation="";
$gender="";
$birthday="";
$city="";
$home="";

/* create a prepared statement */
if ($stmt = mysqli_prepare($link, "SELECT userid,firstname,lastname,email,contact, accttype,picture, occupation, gender, birthday, city, home FROM user WHERE username=? AND password=?")) 
{

    /* bind parameters for markers */
    mysqli_stmt_bind_param($stmt, "ss", $username,$hash_password);

    /* execute query */
    mysqli_stmt_execute($stmt);

    /* bind result variables */
    mysqli_stmt_bind_result($stmt, $userid,$firstname,$lastname,$email,$contact,$accttype,$picture,$occupation,$gender,$birthday,$city,$home);

    /* fetch value */
    mysqli_stmt_fetch($stmt);

    //printf("%s is in district %s\n", $city, $district);
    //echo "User ID: ".$userid."<br />"."Firstname: ".$firstname."<br />"."Lastname: ".$lastname;
    
    if($userid!="")
    {
    	$response['status']="success";
    	$response['message']="Account found";
    	$response['userid']=$userid;
	    $response['firstname']=$firstname;
	    $response['lastname']=$lastname;
	    $response['username']=$username;
	    $response['password']=$password;
	    $response['email']=$email;
	    $response['contact']=$contact;
	    $response['accttype']=$accttype;
	    $response['picture']=$picture;
	    $response['occupation']=$occupation;
	    $response['gender']=$gender;
	    $response['birthday']=$birthday;
	    $response['city']=$city;
	    $response['home']=$home;

	    echo json_encode($response);
    }
    else{
    	$response['status']="failed";
    	$response['message']="Account not found";

    	echo json_encode($response);
    }
    

    /* close statement */
    mysqli_stmt_close($stmt);
}

/* close connection */
mysqli_close($link);


?>