<?php
    session_start();
    require 'db.php';

    $rating = $_POST['rating'];
    $review = $_POST['comment'];
    $name = $_SESSION['Name'];
    $pid = $_GET['pid'];

    // echo $rating.$review.$pid.$name;
    $sql = "INSERT INTO review(pid,name,rating,comment)
            VALUES('$pid','$name', '$rating', '$review')";

    $result = mysqli_query($conn, $sql);
    if(!$result)
    {
        echo $result->mysqli_error();
    }
    else {
        header("Location: review.php?pid=".$pid);
    }

?>
