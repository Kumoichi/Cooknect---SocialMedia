<?php include 'navbar.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Search</title>
  <!-- Bootstrap 5 CSS -->

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 5 Search Box Example</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container" style="margin-top: 20px;">
    <div class="row">
        <div class="col-md-6">
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="searchBox" placeholder="Search by username...">
                <button class="btn btn-primary" type="button" onclick="searchUsers()" id="searchButton">Search</button>
            </div>
            <div id="searchResults"></div>
        </div>
    </div>
</div>

<div id="tr2-6-result-pane"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
   function searchUsers() {
    var url = "controller.php";
    var searchText = $('#searchBox').val().toLowerCase().trim();
    var query = { page: "SearchFriend", command: "GetFriend", searchTerm: searchText };
    $.post(url, query, function(data) {
        var rows = JSON.parse(data);
        if (searchText != '') {
        rows = rows.filter(function(row) {
            return row['Username'].toLowerCase().indexOf(searchText) > -1;
        });
        }
        var t = "<table>";
        t += "<tr><th>Username</th><th>Delete</th></tr>";
        for (var i = 0; i < rows.length; i++) {
        t += "<tr>";
        t += "<td>" + rows[i]['Username'] + "</td>";
        t += "<td>";
        t += "<button type='button' data-username='" + rows[i]['Username'] + "'>Delete</button>";
        t += "</td>";
        t += "</tr>";
        }
        t += "</table>";
        document.getElementById("tr2-6-result-pane").innerHTML = t;
        $('[data-username]').click(function() {
        var username = $(this).data('username');
        // create and submit the form with the username value
        var form = $('<form action="controller.php" method="post">' +
                        '<input type="hidden" name="username" value="' + username + '">' +
                        '<input type="hidden" name="page" value="SearchFriend">' +
                        '<input type="hidden" name="command" value="FriendPost">' +
                    '</form>');
        $('body').append(form);
        form.submit();
        });
    });
}

</script>

</body>
</html>
