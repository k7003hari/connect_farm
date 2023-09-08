<?php
    session_start();
    require '../db.php';
    
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST['upload']))
        {
            $pic = $_FILES['profilePic'];
            $picName = $pic['name'];
            $picTmpName = $pic['tmp_name'];
            $picSize = $pic['size'];
            $picError = $pic['error'];
            $p
            icType = $pic['type'];

            $picExt = explode('.', $picName);
            $picActualExt = strtolower(end($picExt));
            $allowed = array('jpg','jpeg','png');

            if(in_array($picActualExt, $allowed))
            {
                if($picError === 0)
                {
                    $_SESSION['picId'] = $_SESSION['id'];
                    $picNameNew = "profile".$_SESSION['picId'].".".$picActualExt ;
                    $_SESSION['picName'] = $picNameNew;
                    $_SESSION['picExt'] = $picActualExt;
                    $picDestination = "../images/profileImages/".$picNameNew;
                    move_uploaded_file($picTmpName, $picDestination);
                    $id = $_SESSION['id'];

                    $sql = "UPDATE members SET picStatus=1, picExt='$picActualExt' WHERE id='$id';";

                    $result = mysqli_query($conn, $sql);
                    if($result)
                    {
                        $_SESSION['message'] = "Profile picture Updated successfully !!!";
                        header("Location: ../profileView.php");
                    }
                    else
                    {
                        $_SESSION['message'] = "There was an error in updating your profile picture! Please Try again!";
                        header("Location: ../Login/error.php");
                    }
                }
                else
                {
                    $_SESSION['message'] = "There was an error in uploading your image! Please Try again!";
                    header("Location: ../Login/error.php");
                }
            }
            else
            {
                $_SESSION['message'] = "You cannot upload files with this extension!!!";
                header("Location: ../Login/error.php");
            }
        }
        else if(isset($_POST['remove']) AND $_SESSION['picId'] != 0)
        {
            $picToRemove = "../images/profileImages/".$_SESSION['picName'];
            if(!unlink($picToRemove))
            {
                $_SESSION['message'] = "There was an error in deleting the profile picture!";
                header("Location: ../Login/error.php");
            }
            else
            {
                $_SESSION['message'] = "The profile picture was successfully deleted!";
                $id = $_SESSION['id'];
                $sql = "UPDATE members SET picStatus=0, picExt='png' WHERE id='$id';";
                $_SESSION['picId'] = 0;
                $_SESSION['picExt'] = "png";
                $_SESSION['picName'] = "profile0.png";
                $result = mysqli_query($conn, $sql);

                header("Location: ../profileView.php");
            }
        }
        else
        {
            header("Location: ../profileView.php");
        }
    }

function dataFilter($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>
