<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List Of Users</title>
    <link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.css"/>
</head>
<body>
<?php if ($errors) {
    foreach ($errors as $error) {
        echo "<p class=\"text-danger\">$error</p>";
    }
} ?>
<div class="panel-heading text-center p-3 border bg-light"><h4>List Of Users</h4></div>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <table class="table table-striped">
                <thead class="table-dark">
                <tr>
                    <th scope="col">Email</th>
                    <th scope="col">Name</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Status</th>
                    <th scope="col">Options</th>
                </tr>
                </thead>
                <?php foreach ($users as $user) {
                    $id = $user->getId();
                    $email = $user->getEmail();
                    $name = $user->getName();
                    $gender = $user->getGender();
                    $status = $user->getStatus();
                    echo "<tr><td>$email</td>";
                    echo "<td>$name</td>";
                    echo "<td>$gender</td>";
                    echo "<td>$status</td>";
                    echo "<td><a href=\"\users\\$id\\edit\">Edit</a><br>";
                    echo "<a type =\"button\" class=\"btn btn-danger\" 
                                     onclick=\"confirmDeleting('$email')\" value=\"delete\">Delete</a></td></tr>";
                } ?>
            </table>
            <a type="button" href="\users\create" class="btn btn-primary">Add User</a>
        </div>
    </div>
</body>
</html>
<script>
    function confirmDeleting(email) {
        if (confirm("Are you sure?")) {
            document.location.href = "/users/delete%DELETE?Email=" + email;
        }
    }
</script>
