<?php
   if (!isset($_SESSION['signed'])) {
    $display_modal_window = 'backtostart'; 
    include('startpage.php');
    exit();
   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
<?php include 'navbar.php'; ?>

<!--form of usrename, email, description -->
<div class="container">
    <div style="height:100%; width:800px">
    <form id='edit-profile-form' method='post' action='controller.php'>
  <h4>Username:</h4>
  <input class ="p-3 mb-3 bg-light border border-1 shadow" style="width:400px" 
    type="text" name="nameuser" id="username">

  <h4> Email </h4>
  <input class ="p-3 mb-3 bg-light border border-1 shadow" style="width:400px" 
    type="text" name="emailuser" id="email">
  
  <h4> Description </h4>
  <input class="p-3 mb-3 bg-light border border-1 shadow"
    style="width: 60%; height: 100px; display:block;" name="descriptionuser" id="description">
  
  <input type='hidden' name='page' value='ProfilePage'>
  <input type='hidden' name='command' value='EditProfile'>
</form>

  <form id='form-unsubscribe' method='post' action='controller.php' style='display:none'>
      <input type='hidden' name='page' value='ProfilePage'>
      <input type='hidden' name='command' value='Unsubscribe'>
      <input type='submit'>
  </form>

  <button type="button" id="Editing" class="btn btn-outline-info">Edit Profile</button>
  <button type="button" class="btn btn-outline-info">Log Out</button>
  <button type="button" id='Unsubscribe' class="btn btn-outline-info">Unsubscribe</button>

</div>

</body>
</html>


<script>
  document.getElementById('Unsubscribe').addEventListener('click', function() {
        document.getElementById('form-unsubscribe').submit();
    });

  //username, email, description are sent when Editing button is clicked. 
  document.getElementById('Editing').addEventListener('click', function() {
        document.getElementById('edit-profile-form').submit();
    });
</script>


<?php
//if there is something in result, then shows most current usrename, email, description. 
    if (!empty($result)) {
      echo "<script>";
      foreach ($result as $row) {
      $username = $row['Username'];
      $email = $row['Email'];
      $description = $row['Description'];
      
      echo "document.getElementById('username').value = '$username';";
      echo "document.getElementById('email').value = '$email';";
      echo "document.getElementById('description').value = '$description';";
    }
  }
  echo "</script>";

  //when update was succeeded, alert message will be shown.
  if (!empty($success)) {
    echo "<script>alert('$success');</script>";
  }

?>