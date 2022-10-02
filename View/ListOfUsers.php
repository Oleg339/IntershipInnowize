<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List Of Users</title>
    <script src="view/js/main.js"></script>
    <link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.css"/>
</head>
<body  onload="getUsers()">
<div class="panel-heading text-center p-3 border bg-light"><h4>List Of Users</h4></div>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <table id="users" class="table table-striped">
                <thead class="table-dark">
                <tr>
                    <th scope="col">Email</th>
                    <th scope="col">Name</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Status</th>
                    <th scope="col">Options</th>
                </tr>
                </thead>
            </table>
            <a type="button" href="View/AddUser.php" class="btn btn-primary">Add User</a>
        </div>
    </div>
</body>
</html>


