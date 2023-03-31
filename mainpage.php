<?php
   if (!isset($_SESSION['signed']) || $_SESSION['signed'] != 'YES') {
    $display_modal_window = 'backtostart'; 
    include('startpage.php');
    exit();
   }
?>

<!DOCTYPE html> 

<html>
<head>
    <title>TRU CS Messenger</title>

    <style>
        /* Layout */
        
        #layout-navigation {
            position: absolute;
            top: 20px;
            left: 0;
            width:180px;
            text-align: right;
        }
        
        #layout-main {
            position: absolute;
            top: 20px;
            left: 220px;
            width: calc(100vw - 200px - 100px - 40px - 2px);
        }
        
        #vertical-line-0 {
            position: absolute;
            top: 0;
            left: 200px;
            border-left: 1px solid LightGray;
            height: 100vh;
        }
        
        #vertical-line-1 {
            position: absolute;
            top: 0;
            right: 100px;
            border-left: 1px solid LightGray;
            height: 100vh;
        }

        /* Navigation images */
        
        .nav-image {
            width:40px;
            height:40px;
            padding:5px;
        }
        .nav-image:hover {
            background-color: LightGray;
            cursor: pointer;
        }

        .delete-button {
            position: absolute;
            left: 10%; 
            top: 50%; 
        }
        
    </style>
</head>


<!-- including navigation bar -->
<body style='margin:0;position:relative;'>
<?php include 'navbar.php'; ?>

<!-- this is for posting popular posts. -->
<div class="right-div p-4 mb-3 bg-light border rounded" style="background: black; position: fixed; width:30%; right: 0px;">
    <h4 class="text-center">Top 3 Popular Post</h4>
    <!-- making it scrollable -->
    <div class="containImage" style="max-height: 400px; overflow-y: auto;"> 
        <?php while($row = mysqli_fetch_assoc($resultTwo)){ ?> 
            <div class="card mb-3">
                <div style="height:400px">
                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>" style="max-height: 100%; max-width: 100%;" />
                    
                </div>
                <div class="card-body">
                    <p class="card-text"><?php echo $row['comment']; ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>




<!-- display the user description-->
  <div class="userdisplay" style="border:solid 1px black; width:70%;">
        <div class="userinfo" style="border:solid 1px black; height:200px;"> This is where you wanna display user description</div>
    </div>

    <!-- go to posting.php when you press + Post -->
    <div class="text-center" style="height:100%;width:70%; position:absolute; display:inline;">
                    <a id="postButton" class="btn btn-outline-dark" style="margin:10px;">+ Post</a>
                <form id='form-postImage' method='post' action='controller.php' style='display:none'>
                    <input type='hidden' name='page' value='MainPage'>
                    <input type='hidden' name='command' value='PostImage'>
                    <input type='submit' value='Submit'>
                </form>
                <?php
                
                if(!isset($result)) {
                    // handle the error condition here
                    echo "No image yet";
                } else {
                    //getting each image, comment, and like button data using while loop
                    if(mysqli_num_rows($result) > 0){ ?> 
                        <div class="gallery"> 
                            <?php while($row = mysqli_fetch_assoc($result)){ ?> 
                                <div class="card mb-3">
                                    <div style="height:400px">
                                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>" style="max-height: 100%; max-width: 100%;" />
                                    </div>
                                    <div class="card-body" style="position: relative">
                                        <p class="card-text"style="border-top:#DCDCDC 1px solid"><?php echo $row['comment']; ?></p>
                                        <button id="deleteButton" class="btn btn-outline-danger delete-button" onclick="deletePost(<?php echo $row['id']; ?>)" data-post-id="<?php echo $row['id']; ?>">Delete Post</button>
                                        <form id="deleteForm_<?php echo $row['id']; ?>" method="post" action="controller.php">
                                            <input type="hidden" name="page" value="MainPage">
                                            <input type='hidden' name='command' value="DeletePost">
                                            <input type="hidden" name="postId" value="<?php echo $row['id']; ?>">
                                        </form>
                                        <!-- calling likeComment function for increment like value when users press like button -->
                                        <button onclick="likeComment(<?php echo $row['id']; ?>)" class="btn btn-outline-success">Like</button>
                                        <span style="display:block;" id="likes_<?php echo $row['id']; ?>" class="card-text"><?php echo $row['like']; ?></span>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } 
                }
            ?>
    </div>
</body>
</html>


<script>
    document.getElementById('postButton').addEventListener('click',function() {
        document.getElementById('form-postImage').submit();
    });

function deletePost(postId) {
    var form = document.getElementById('deleteForm_' + postId);
    form.submit();
}

function likeComment(commentId) {
    // AJAX to update the 'like' column in the database
    $.ajax({
        url: 'controller.php',
        type: 'POST',
        data: {
            page: 'MainPage',
            command: 'LikeComment',
            comment_id: commentId
        },
        success: function(response) {
            // Update the 'like' count in the HTML
            $('#likes_' + commentId).html(response);
        }
    });
}
</script>