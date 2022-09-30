<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List Of Users</title>
    <link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.css"/>
    <script type="text/javascript" src="view/js/main.js"></script>
</head>
<body>
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
                <?php
                $values = json_decode($data);
                foreach ($values as $value) {
                    $id = $value->id;
                    $email = $value->email;
                    $name = $value->name;
                    $gender = $value->gender;
                    $status = $value->status;
                    echo "<tr><td>$email</td>";
                    echo "<td>$name</td>";
                    echo "<td>$gender</td>";
                    echo "<td>$status</td>";
                    echo "<td><a href=\"\users\\$id\\edit\">Edit</a><br>";
                    echo "<a type =\"button\" class=\"btn btn-danger\" 
                                     onclick=\"confirmDeleting('$id')\" value=\"delete\">Delete</a></td></tr>";
                } ?>
            </table>
            <a type="button" href="\users\create" class="btn btn-primary">Add User</a>
        </div>
    </div>
</body>
</html>

