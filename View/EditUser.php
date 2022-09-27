<?php
?>
<!DOCTYPE html>

<html>
<head>
    <meta name="viewport" content="width=device-width"/>
    <title>Edit User</title>
    <link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.css"/>
    <style>
    </style>
</head>
<body>
<div class="panel panel-success">
    <nav class="navbar navbar-light bg-light">
        <h2 class="p-3">Edit User</h2>
        <a class="nav-link my-2 my-sm-0" href="/users%GET">Back to UserList</a>
    </nav>
    <div class="panel-body">
        <form class="p-a-1" action="/users%PUT?id=<?php echo $user->getId() ?>" method="post">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col col-sm-2">
                    </div>
                    <div class="col-md offset-md p-5">
                        <div class="p-1">
                            <label for="Email">User Email</label>
                            <input value="<?php echo $user->getEmail() ?>" type="email" class="form-control"
                                   name="email" required/>
                        </div>
                        <div class="p-1">
                            <label for="name">User Name</label>
                            <input value="<?php echo $user->getName() ?>" class="form-control" name="name" required/>
                        </div>
                        <div class="p-1">
                            <label for="gender">Gender</label>
                            <select value="<?php echo $user->getGender() ?>" class="form-control" name="gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="p-1">
                            <label for="status">Status</label>
                            <select value="<?php echo $user->getStatus() ?>" class="form-control" name="status">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col col-sm-2">
                    </div>
                </div>
            </div>
            <div class="p-3">
                <div class="text-center">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>