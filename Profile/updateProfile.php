<?php
    session_start();
    require '../db.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $name = dataFilter($_POST['name']);
        $mobile = dataFilter($_POST['mobile']);
        $user = dataFilter($_POST['uname']);
        $email = dataFilter($_POST['email']);
        $section = dataFilter($_POST['section']);
        $post = dataFilter($_POST['post']);
        $year = dataFilter($_POST['year']);
        $edu = dataFilter($_POST['edu']);

        $_SESSION['Email'] = $email;
        $_SESSION['Name'] = $name;
        $_SESSION['Username'] = $user;
        $_SESSION['MobileNo'] = $mobile;
        $_SESSION['Section'] = $section;
        $_SESSION['Post'] = $post;
        $_SESSION['Edu'] = $edu;
        $_SESSION['Year'] = $year;
    }
    $id = $_SESSION['id'];

    $sql = "UPDATE members SET Name='$name',Username='$user',MobileNo='$mobile',Email='$email',Year='$year',Section='$section',Edu='$edu',Post='$post' WHERE id='$id';";

    $result = mysqli_query($conn, $sql);
    if($result)
    {
        $_SESSION['message'] = "Profile Updated successfully !!!";
        header("Location: ../profileView.php");
    }
    else
    {
        $_SESSION['message'] = "There was an error in updating your profile! Please Try again!";
        header("Location: ../Login/error.php");
    }

function dataFilter($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>
