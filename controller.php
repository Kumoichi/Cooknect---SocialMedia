<?php
if (empty($_POST['page'])) {  // When no page is sent from the client; The initial display
                               
    $display_modal_window = 'no-modal';  // This variable will be used in 'view_startpage.php'.
                              // It will display the start page without any box
    $error_msg_username = '';
    $error_msg_password = '';
    include('startpage.php');
    exit();
}


require_once('model.php');  // This file includes some routines to use DB.

// When commands come from StartPage
if ($_POST['page'] == 'StartPage')
{
    $command = $_POST['command'];
    switch($command) {
        case 'LogIn':   //With username, password
            if (!username_password_valid($_POST['username'], $_POST['password'])) {
                $display_modal_window = 'login';  // It will display the start page with the LogIn box.
                $error_msg_username = '* Wrong username, or';
                $error_msg_password = '* Wrong password'; // Set an error message into a variable.
                include('startpage.php');
            } 
            else {
                session_start();
                $_SESSION['signed'] = 'YES';
                $_SESSION['username'] = $_POST['username'];
                $result = getContent($_SESSION['username']);
                $resultTwo = getRankedImage($_SESSION['username']);
                $desc = getDescription($_SESSION['username']);
                // $description = getDescription($_SESSION['username']);
                include('mainpage.php');
            }
            exit();
            break;

        case 'SignUp':  // With username, password, email
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $result = user_exists($username);//checking whether user is already in database or not.
            
            if (!$result){
                $display_modal_window = 'login';// It will display the start page with the LogIn box.
                include('startpage.php');
                signup_a_new_user($username, $password, $email);//inserting username, password, email
            }
            else{
                $display_modal_window = 'signup';//shows sign up window again
                $error_signup = 'this username is already taken';
                include('startpage.php');
            }
            exit();
            break;
            
        default:
            echo "Unknown command from StartPage<br>";
            exit();
            break;
    }
}


else if ($_POST['page'] == 'MainPage')
{
    session_start();
    $command = $_POST['command'];
    switch($command) {          
        case 'LikeComment':
            $commentId = $_POST['comment_id'];
            $likes = getLikes($commentId); //getting number of likes

            if ($likes !== false) {
                $likes++;
                if (updateLikes($commentId, $likes)) {//update incremented like number
                    echo $likes;
                } else {
                    echo 'Error: Failed to update likes';
                }
            } else {
                echo 'Error: Comment not found';
            }

            exit();
            break;
        case 'DeletePost':
            $id = $_POST['postId'];
            deletePost($id);
            $result = getContent($_SESSION['username']);
            $resultTwo = getRankedImage($_SESSION['username']);
            $desc = getDescription($_SESSION['username']);
            include("mainpage.php");
            exit();
            break;

        case 'PostImage':
            include("posting.php");
            exit();
            break;
        
        default:
            echo "Unknown command from MainPage<br>";
            exit();
            break;
    }
}


else if ($_POST['page'] == 'NavPage')
{
    session_start();
    $command = $_POST['command'];
    switch($command) {  // When a command is sent from the client
        case 'ShowProfile':
            $result = user_data($_SESSION['username']);//getting username, email, description
            include('profile.php');
            exit();
            break;
        
        case 'LogOut':
            session_reset();
            session_destroy();//reseting and destroying session when user is logging out.
            $display_modal_window = 'none';//modal window for sign up and log in won't be shown
            include('startpage.php');
            exit();
            break;
        
        case 'GoMain':
            $result = getContent($_SESSION['username']);
                $resultTwo = getRankedImage($_SESSION['username']);
                $desc = getDescription($_SESSION['username']);
                include('mainpage.php');
                exit();
                break;

        case 'NavSearch':
                include('searchfriend.php');
                exit();
                break;

        default:
            echo "Unknown command from MainPage<br>";
            exit();
            break;
    }
}


else if ($_POST['page'] == 'ProfilePage')
{
    session_start();
    $command = $_POST['command'];
    switch($command) {
        case 'EditProfile':
            //username, email, description get updated. 
            $data = edited_data($_SESSION['username'], $_POST['nameuser'],$_POST['emailuser'],$_POST['passworduser'], $_POST['descriptionuser']);
            $result = user_data($_POST['nameuser']);//username, email, description are returned.
            $_SESSION['username'] = $_POST['nameuser'];
            $success = "Profile updated successfully";
            include('profile.php');
            exit();
            break;
        
        case 'Unsubscribe':
            $status = '';
            $username = $_SESSION['username'];
            $result = deleteUser($username);
            if($result)
            {
                $status = 'successfully unsubscribed';
            } else {
                $status = 'failed to unsubscribe';
            }
            echo "<script>alert('$status');</script>";
            $display_modal_window = 'backtostart';
            include('startpage.php');
            exit();
            
        default:
            echo "Unknown command from MainPage<br>";
            exit();
            break;
    }
}

else if ($_POST['page'] == 'PostingPage')
{
    $status = $statusMsg = ''; 

    session_start();
    $command = $_POST['command'];
    switch($command) {  // When a command is sent from the client
        case 'PostingImage':
        $status = 'error'; 
        if(!empty($_FILES["image"]["name"])) { 
            // Get file info 
           
            //The basename() function is a built-in function in PHP. 
            //It is used to extract the filename from a path. 
            $fileName = basename($_FILES["image"]["name"]); 
            //pathinfo buit-in function, the file extension of the uploaded file is then extracted
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
            
            // Allow certain file formats 
            $allowTypes = array('jpg','png','jpeg','gif'); 
            //checks whether extention is allowed type
            if(in_array($fileType, $allowTypes)){ 
                $image = $_FILES['image']['tmp_name'];
                
                // Check image size
                $maxAllowedPacket = mysqli_fetch_assoc(mysqli_query($conn, "SHOW VARIABLES LIKE 'max_allowed_packet'"))['Value'];
                $imgSize = filesize($image);
                if ($imgSize > $maxAllowedPacket) {
                    $statusMsg = "File size is too large. Max allowed packet size is " . $maxAllowedPacket . " bytes.";
                    echo "<script>alert('$statusMsg');</script>";
                } else {
                //file_get_contents function is used to read the contents of the uploaded image file
                // and store them in the $imgContent variable as a string.
                //addslashes adds backslash in case file name include like quote characters, 
                //so it recgnizes image file correctly that prevent potential problem in database
                $imgContent = addslashes(file_get_contents($image)); 
                $comment = $_POST['comment'];
                $username = $_SESSION['username'];
                $insert = insertContent($username, $comment, $imgContent);//just inserting $username, $comment, $imgContent
                if($insert){ 
                    $status = 'success'; 
                    $statusMsg = "File uploaded successfully."; 
                    echo "<script>alert('$statusMsg');</script>";
                }else{ 
                    $statusMsg = "File upload failed, please try again."; 
                }  
            }
            }else{ 
                $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
                echo "<script>alert('$statusMsg');</script>";
            } 
        }else{ 
            $statusMsg = 'Please select an image file to upload.'; 
            echo "<script>alert('$statusMsg');</script>";
        } 
       


        //getting id, image, comment, like.
        $result = getContent($_SESSION['username']);
        //getting id, image, comment, 'like'. In order of number of 'like'.
        $resultTwo = getRankedImage($_SESSION['username']);
        //getting description.
        $desc = getDescription($_SESSION['username']);

        // unset the POST variables to prevent data from being resubmitted on refresh
        
        include("mainpage.php");
        exit();
        break;
    }
}


if ($_POST['page'] == 'SearchFriend')
{
    $command = $_POST['command'];
    switch($command) {  
        case 'GetFriend': 
            // get the search term from the request
            $searchTerm = isset($_POST['searchTerm']) ? $_POST['searchTerm'] : '';

            $result = getFriend($searchTerm);
            
            $rows = array();
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $rows[] = $row;
                }
            }
            echo json_encode($rows);
            // close the database connection
            mysqli_close($conn);
            exit();
            break;

        case 'FriendPost':
            session_start();
            $username = $_POST['username'];
            $result = getContent($username);
            $resultTwo = getRankedImage($username);
            $desc = getDescription($username);
            include('friendpage.php');
            exit();
            break;
        
    default:
        echo "Unknown command from StartPage<br>";
        exit();
        break;
    }
}

//Wrong
else {
    echo 'Wrong page<br>';
}
?>