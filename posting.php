<?php
   if (!isset($_SESSION['signed']) || $_SESSION['signed'] != 'YES') {
    $display_modal_window = 'backtostart'; 
    include('startpage.php');
    exit();
   }
?>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <div class="text-center mt-4 mb-3">JPG, JPEG, PNG, & GIF are accepted</div>
  <form action="controller.php" method="post" enctype="multipart/form-data" class="p-3 bg-light rounded shadow">
  <input type="hidden" name="page" value="PostingPage">
  <input type='hidden' name='command' value='PostingImage'>
  <div class="mb-3">
    <label for="image" class="form-label">Select Image File:</label>
    <input type="file" class="form-control" name="image" id="image">
  </div>
  <div class="mb-3">
    <label for="comment" class="form-label">Comment:</label>
    <input type="text" class="form-control" name="comment" id="comment">
  </div>
  <button type="submit" name="submit" class="btn btn-primary mb-3">Upload</button>
</form>


<style>
form {
  max-width: 500px;
  margin: 0 auto;
}

form label {
  font-weight: bold;
}

form .form-control {
  background-color: #f8f9fa;
  border-color: #ced4da;
}

form .form-control:focus {
  background-color: #fff;
  border-color: #80bdff;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

form .btn-primary {
  background-color: #007bff;
  border-color: #007bff;
}

form .btn-primary:hover {
  background-color: #0069d9;
  border-color: #0062cc;
}


</style>

