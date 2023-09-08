<?php
    session_start();

	require '../db.php';

	if(!isset($_SESSION['logged_in']) OR $_SESSION['logged_in'] == 0)
	{
		$_SESSION['message'] = "You need to first login to write a blog !!!";
		header("Location: ../Login/error.php");
		die();
	}


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$title = dataFilter($_POST['blogTitle']);
		$content = $_POST['blogContent'];
		$userName = $_SESSION['Username'];
	}


    $sql = "INSERT INTO blogdata (blogUser, blogTitle, blogContent)
		    VALUES ('$userName', '$title', '$content')";
    $result = mysqli_query($conn, $sql);

    if(!$result)
    {
        $_SESSION['message'] = "Some Error occurred !!!";
        header("location: ../Login/error.php");
    }
	else
	{
		header("Location: ../blogView.php");
	}

    function dataFilter($data)
    {
    	$data = trim($data);
     	$data = stripslashes($data);
    	$data = htmlspecialchars($data);
      	return $data;
    }

?>
