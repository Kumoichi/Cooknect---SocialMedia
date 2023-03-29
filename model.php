<?php
/*
*   User management
*/


$conn = mysqli_connect('localhost', 'root', '', 'test');
include('controller.php');


//checking whether chosen username is in database or not.
function user_exists($username) 
{
        global $conn;
        $sql="select*from userstable where Username = '$username'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result)>0)
            return true;
        else
            return false;
}


//checking password matches with the password in database.
function username_password_valid($username, $password) 
{
        global $conn;
    $sql="select*from userstable where Username = '$username' AND Password = '$password'";
    $result = mysqli_query($conn,$sql);
    if (mysqli_num_rows($result)>0)
       return true;
    else
       return false;
}


//inserting username, password, email
function signup_a_new_user($username,$password,$email)
{
    global $conn;
    $current_date = date("Ymd");  // There is an example in Seminar 6.docx.
    $sql = "INSERT INTO userstable (Id, Username, Password,Email, Date)
              VALUES (null, '$username', '$password', '$email', '$current_date')";
    $result = mysqli_query($conn,$sql);
    return $result;
}


//returning username, email, description.
function user_data($username){
    global $conn;
    $sql = "SELECT Username, Email, Description FROM userstable where Username = '$username'";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
}

//updating username, email, description.
function edited_data($pusername, $username, $email, $description)
{
    global $conn;
    $sql1 = "UPDATE userstable
             SET Username = '$username', Email = '$email', Description = '$description' 
             WHERE Username = '$pusername'";
    $result1 = mysqli_query($conn, $sql1);

    // Update the username column in the images table
    $sql2 = "UPDATE images SET username = '$username' WHERE username = '$pusername'";
    $result2 = mysqli_query($conn, $sql2);
    
    return ($result1 && $result2);
}



function insertContent($username, $comment, $imageContent) {
    global $conn;
    $sql = "SELECT * FROM images ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("Error: " . mysqli_error($conn));
    }
    $row = mysqli_fetch_assoc($result);
    $lastComment = $row['comment'];
    $lastImage = $row['image'];
    if ($lastComment == $comment || $lastImage == $imageContent) {
        return false;
    }
    $sql = "INSERT into images (username, comment, image, created) VALUES ('$username','$comment', '$imageContent', NOW())"; 
    if(mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false;
    }
}

//selecting id, image, comment, like. Storing them in descending order
function getContent($username){
    global $conn;
    $sql = "SELECT id, image, comment, `like` FROM images WHERE username='$username' ORDER BY id DESC"; 
    $result = mysqli_query($conn,$sql);
    return $result;
}


//getting number of like
function getLikes($commentId) {
    global $conn;
    
    $sql = "SELECT `like` FROM images WHERE id = $commentId";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($result);
    $likeCount = $row['like'];

  

    return $likeCount;
}


//updating number of like
function updateLikes($commentId, $likes) {
    global $conn;
    $query = "UPDATE images SET `like` = '$likes' WHERE id = '$commentId'";
    if(mysqli_query($conn, $query)) {
        return true;
    } else {
        return false;
    }
}


function getRankedImage($username){
    global $conn;
    $sql = "SELECT id, image, comment, `like` FROM images WHERE username = '$username' ORDER BY `like` DESC"; 
    $result = mysqli_query($conn,$sql);
    return $result;
}


function deletePost($id)
{
    global $conn;
    $sql = "DELETE FROM images WHERE id = '$id'";
    if(mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false;
    }

}


?>   


<!-- essential features -->
<!-- search friend -->
<!-- use Jason for something, I don't know where to use honestly, I need to study, it will take 5 hours approximately -->
<!-- use AJAX for finding friends -->
<!-- you can use AJAX for viewing friends page too. once you press the button besides friends name then it shows thier page without loading. -->
<!-- add session in each page -->
<!-- when you press Cooknect, it jumps to the mainpage. -->
<!-- sql and query bunbetsu suru -->


<!-- desireable features -->
<!-- put the description inside the description box on the mainpage -->
