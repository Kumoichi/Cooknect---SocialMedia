<!DOCTYPE html>
<html>
<head>
  <title>Navbar</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <style>
  
    .navbar {
      transition: background-color 0.5s ease-in-out;
    }

    .navbar.sticky {
      position: fixed;
      top: 0;
      width: 100%;
    }

    .navbar.scrolled {
        background-color: brown;
    }


    .navbar-nav .nav-link {
      padding: 1rem;
      transition: border-bottom 0.5s ease-in-out;
      border-bottom: 2px solid transparent;
    }

    .navbar-nav .nav-link:hover {
      border-bottom: 2px solid #fff;
    }

    body {
      padding-top: 70px; /* add padding equal to the height of the fixed nav bar */     
    }

</style>
    
<body>

  <!-- this is the navigation at the top -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">Cooknect</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a id="nav-profile" class="nav-link">Profile</a>
          </li>
         
          <li class="nav-item">
            <a class="nav-link" href="#">Search Friend</a>
          </li>
          <li class="nav-item">
            <a id="nav-logout" class="nav-link" href="#">Log out</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

<!-- this is the logout request form. -->
  <form id='form-logout' method='post' action='controller.php' style='display:none'>
    <input type='hidden' name='page' value='MainPage'>
    <input type='hidden' name='command' value='LogOut'>
    <input type='submit'>
  </form>

<!-- profile page request -->
  <form id='form-profile' method='post' action='controller.php' style='display:none'>
    <input type='hidden' name='page' value='NavPage'>
    <input type='hidden' name='command' value='ShowProfile'>
    <input type='submit'>
  </form>
</body>

<script>
//for when you press logout from nav.
    document.getElementById('nav-logout').addEventListener('click', function() {
        document.getElementById('form-logout').submit();
    });

//for when you press profile from nav. 
    document.getElementById('nav-profile').addEventListener('click', function() {
        document.getElementById('form-profile').submit();
    });
</script>





