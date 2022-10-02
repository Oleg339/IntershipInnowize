<!DOCTYPE html>

<html>
<head>
    <meta name="viewport" content="width=device-width"/>
    <title>Add User</title>
    <script type="text/javascript" src="/view/js/main.js"></script>
    <link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.css"/>
    <style>
    </style>
</head>
<body>
<p class="text-danger" id="errors"></p>
<div class="panel panel-success">
    <nav class="navbar navbar-light bg-light">
        <h2 class="p-3">Add User</h2>
        <a class="nav-link my-2 my-sm-0" href="/">Back to UserList</a>
    </nav>
    <div class="panel-body">
        <form class="p-a-1" id="form">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col col-sm-2">
                    </div>
                    <div class="col-md offset-md p-5">
                        <div class="p-1">
                            <label for="email">User Email</label>
                            <input type="email" class="form-control" name="email" required/>
                        </div>
                        <div class="p-1">
                            <label for="name">User Name</label>
                            <input class="form-control" name="name" required/>
                        </div>
                        <div class="p-1">
                            <label for="gender">Gender</label>
                            <select class="form-control" name="gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="p-1">
                            <label for="status">Status</label>
                            <select class="form-control" name="status">
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
            </div>
        </form>
        <div class="text-center">
            <button onclick="confirmAddUser()" class="btn btn-primary">submit</button>
        </div>
    </div>
</div>
</body>
</html>