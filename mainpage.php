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
        
    </style>
</head>


<!-- including navigation bar -->
<body style='margin:0;position:relative;'>
<?php include 'navbar.php'; ?>

<!-- this is for posting popular posts. -->
<div class="right-div p-4 mb-3 bg-light border rounded" style="position: fixed; width:30%; right: 0px;">
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
            <a href="posting.php" class="btn btn-outline-dark" style="margin:10px;">+  Post</a>
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
                                    <div class="card-body">
                                        <p class="card-text"><?php echo $row['comment']; ?></p>
                                        <!-- calling likeComment function for increment like value when users press like button -->
                                        <button onclick="likeComment(<?php echo $row['id']; ?>)" class="btn btn-outline-success">Like</button>
                                        <span style="display:block;" id="likes_<?php echo $row['id']; ?>" class="card-text"><?php echo $row['like']; ?></span>
                                    </div>
                                </div>
                                <?php } ?>
                        </div>
                    <?php }else{ ?>
                        <p class="status error">Image(s) not found...</p> 
                    <?php }
                }
            ?>
    </div>




           
        
</body>
</html>

<script>

function likeComment(commentId) {
    // Make an AJAX call to update the 'like' column in the database
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Update the 'like' count in the HTML
            document.getElementById('likes_' + commentId).innerHTML = this.responseText;
        }
    };
    xhttp.open('POST', 'controller.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var query = "";
    query += "page=ViewTest";
    query += "&command=LikeComment";
    query += "&comment_id=" + commentId;
    xhttp.send(query);
} 
</script>
