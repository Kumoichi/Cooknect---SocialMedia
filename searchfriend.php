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
                <button class="btn btn-secondary" type="button" onclick="searchUsers()" id="searchButton">Search</button>
            </div>
            <div id="searchResults"></div>
        </div>
    </div>
</div>

<div class="container">
  <div class="row justify-content-center mt-5">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-header bg-secondary text-white">
          Results
        </div>
        <div class="card-body" id="tr2-6-result-pane">
        </div>
      </div>
    </div>
  </div>
</div>


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
    var t = "<table class='table table-striped'>";
    t += "<thead><tr><th>Username</th></tr></thead>";
    t += "<tbody>";
    for (var i = 0; i < rows.length; i++) {
        t += "<tr>";
        t += "<td>" + rows[i]['Username'] + "</td>";
        t += "<td>";
        t += "<button type='button' class='btn btn-secondary' data-username='" + rows[i]['Username'] + "'>Check the page</button>";
        t += "</td>";
        t += "</tr>";
    }
    t += "</tbody></table>";
    $("#tr2-6-result-pane").html(t);
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
});}


</script>

</body>
</html>
