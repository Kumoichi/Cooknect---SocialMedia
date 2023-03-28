<!DOCTYPE html>

<html>
<head>
    <title>TRU CS Messenger</title>
    <style>
        #layout-main {
            position:relative;
            width:100vw; height:100vh;
        }

        #background-picture {
            width: 100%;
            height: 100%;
            filter: brightness(70%);
        }

        #project-title{
            position: absolute;
            color: white;
            font-size: 100px;
            top: 10%; left: 10%;
        }
        #layout-main-left {
            position:absolute; top:0; left:0;
            width: 100%; height:100%; 
            background-color:LightGray; 
        }

        .layout-content {
            width:80%;
            position:absolute;
            left:calc(50% - 40%);
        }
        
        .modal-window {
            width:400px; height:250px;
            border:1px solid black;
            display:none;
            background-color:White;
            position:fixed;
            top:calc(50vh - 125px); left:calc(50vw - 200px);
            z-index:999;
        }
        #blanket {
            display:none;
            width:100vw; height:100vh;
            position:fixed;
            top:0; left:0;
            z-index:998;
            opacity:0.5;
            background-color:Grey;
        }
        .modal-label-input {
            display:inline-block;
            width:100px;
            margin-left:20px;
        }

        #entry-modal{
            border:1px solid black;
            width: 300px;
            position:absolute; right: 10%; bottom:30%;
        }
    </style>
</head>

<body style='margin:0'>

    <!-- Page Layout -->
    
    <div id='layout-main'>
        <!-- https://www.photo-ac.com/main/detail/25528664����摜�̃\�[�X�� -->
        <img id='background-picture' src="image/washoku.jpg">
        <div id='project-title'>
            Cooknect
        </div>
                <div id='entry-modal'> Login or Sign up
                <button id='menu-login' style='display:inline-block; width:100%; height:40px'>Lofgin</button>
                <br>
                <br>
                <button id='menu-signup' style='display:inline-block; width:100%; height:40px'>Sign Up</button>
                </div>     
    </div>
    
    <script>
        // Centers the content in the left and right divs on the page
        let cleft = document.getElementById('content-left');
        cleft.style.top = (cleft.parentElement.offsetHeight - cleft.offsetHeight) / 2 + "px";
        window.addEventListener('resize', function() {
            let cleft = document.getElementById('content-left');
            cleft.style.top = (cleft.parentElement.offsetHeight - cleft.offsetHeight) / 2 + "px";
        });
        let cright = document.getElementById('content-right');
        cright.style.top = (cright.parentElement.offsetHeight - cright.offsetHeight) / 2 + "px";
        window.addEventListener('resize', function() {
            let cright = document.getElementById('content-right');
            cright.style.top = (cright.parentElement.offsetHeight - cright.offsetHeight) / 2 + "px";
        });
    </script>
    
    <!-- Modal Windows -->
    
    <div id='modal-login' class='modal-window'>
        <h2 style='text-align:center'>Login to TRU Messenger</h2>
        <br>
        <form method='post' action='controller.php'>
            <input type='hidden' name='page' value='StartPage'>
            <input type='hidden' name='command' value='LogIn'>
            <label class='modal-label-input' for='input-login-username'>Username:</label>
            <input id='input-login-username' type='text' name='username'>
            <?php if (!empty($error_msg_username)) echo $error_msg_username; ?>
            <br><br>
            <label class='modal-label-input' for='input-login-password'>Password:</label>
            <input id='input-login-password' type='password' name='password'>
            <?php if (!empty($error_msg_password)) echo $error_msg_password; ?>
            <br>
            <button id='submit-modal-login' type='submit' style='position:absolute; bottom:10px; left:20px'>Submit</button>
            <button id='cancel-modal-login' type='button' style='position:absolute; bottom:10px; right:20px'>Cancel</button>
        </form>
    </div>
    <div id='modal-signup' class='modal-window'>
        <h2 style='text-align:center'>Sign up to TRU Messenger</h2>
        <br>
        <form method='post' action='controller.php'>
            <input type='hidden' name='page' value='StartPage'>
            <input type='hidden' name='command' value='SignUp'>
            <label class='modal-label-input' for='input-signup-username'>Username:</label>
            <input id='input-signup-username' type='text' name='username'>
            <br><br>
            <label class='modal-label-input' for='input-signup-password'>Password:</label>
            <input id='input-signup-password' type='password' name='password'>
            <br><br>
            <label class='modal-label-input' for='input-signup-email'>Email:</label>
            <input id='input-signup-email' type='text' name='email'></br>
            <button id='submit-modal-signup' type='submit' style='position:absolute; bottom:10px; left:20px'>Submit</button>
            <button id='cancel-modal-signup' type='button' style='position:absolute; bottom:10px; right:20px'>Cancel</button>
        </form>
    </div>
    
    <div id='blanket'></div>
</body>
</html>

<script>
    // This code block is responsible for displaying the login modal window when the "menu-login" element is clicked.
    document.getElementById("menu-login").addEventListener("click", function() {
        document.getElementById("blanket").style.display = "block";
        document.getElementById("modal-login").style.display = "block";
    });

    // This code block is responsible for hiding the login modal window when the "cancel-modal-login" element is clicked.
    document.getElementById("cancel-modal-login").addEventListener("click", function() {
        document.getElementById("blanket").style.display = "none";
        document.getElementById("modal-login").style.display = "none";
    });

    // This code block is responsible for displaying the signup modal window when the "menu-signup" element is clicked.
    document.getElementById("menu-signup").addEventListener("click", function() {
        document.getElementById("blanket").style.display = "block";
        document.getElementById("modal-signup").style.display = "block";
    });

    // This code block is responsible for hiding the signup modal window when the "cancel-modal-signup" element is clicked.
    document.getElementById("cancel-modal-signup").addEventListener("click", function() {
        document.getElementById("blanket").style.display = "none";
        document.getElementById("modal-signup").style.display = "none";
    });

    // This code block is responsible for hiding all modal windows and the blanket overlay when the "blanket" element is clicked.
    document.getElementById("blanket").addEventListener("click", function() {
        document.getElementById("blanket").style.display = "none";
        document.getElementById("modal-login").style.display = "none";
        document.getElementById("modal-signup").style.display = "none";
    });
    
    // These functions are called to display the login and signup modal windows respectively.
    function display_login_modal() {
        document.getElementById("blanket").style.display = "block";
        document.getElementById("modal-login").style.display = "block";
    }
    
    function display_signup_modal() {
        document.getElementById("blanket").style.display = "block";
        document.getElementById("modal-signup").style.display = "block";
    }
    
    // This function is called to hide all modal windows and the blanket overlay.
    function no_modal() {
        document.getElementById("blanket").style.display = "none";
        document.getElementById("modal-login").style.display = "none";
        document.getElementById("modal-signup").style.display = "none";
    }
    

        <?php
        // This PHP code block checks for the value of $display_modal_window and calls the 
        //appropriate function to display the corresponding modal window.
        if ($display_modal_window == 'login') 
            echo "display_login_modal();";
        else if ($display_modal_window == 'signup') 
            echo "display_signup_modal();";
        else if ($display_modal_window == 'backtostart')
            echo "no_modal();";

        else
            ;
    ?>


 
</script>
