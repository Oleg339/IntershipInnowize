function confirmDeleting(id) {
    if (confirm("Are you sure?")) {
        fetch('/users/' + id, {
            method: 'DELETE'
        })
        document.location.href = "/";
    }
}

async function getUsers() {
    let users = document.getElementById('users');

    let response = await fetch('/users', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    });

    info = '';
    usersJson = await response.json();

    for (let i = 0; i < usersJson.length; i++) {
        users.innerHTML += '<tr><td>' + usersJson[i]['email'] + '</td>' +
            '<td>' + usersJson[i]['name'] + '</td>' +
            '<td>' + usersJson[i]['gender'] + '</td>' +
            '<td>' + usersJson[i]['status'] + '</td>' +
            '<td><a href=\'View\\EditUser.php?id=' + usersJson[i]['id'] + '\'>Edit</a><br>' +
            '<a type=\'button\' class="btn btn-danger" onclick=\'confirmDeleting(' + usersJson[i]['id'] + ')\'>Delete</a></td></tr>'
    }

    users.innerHTML += info;
}

async function confirmEditUser(id) {
    const form = document.getElementById("form");

    let response = await fetch('/users/' + id, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json'
        },
        body: new URLSearchParams(new FormData(form))
    });

    if (response.ok) {
        document.location.href = "/";
    }

    await getErrors(await response.json());
}

async function confirmAddUser() {
    const form = document.getElementById("form");

    let response = await fetch('/users', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: new URLSearchParams(new FormData(form))
    });

    if (response.ok) {
        document.location.href = "/";
    }

    await getErrors(await response.json());
}

async function getUser(id) {
    let response = await fetch('/users/' + id, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })

    user = await response.json();
    document.getElementById('email').setAttribute('value', user['email']);
    document.getElementById('name').setAttribute('value', user['name']);
    document.getElementById('gender').setAttribute('value', user['gender']);
    document.getElementById('status').setAttribute('value', user['status']);
}

async function getErrors(info) {
    let errors = document.getElementById('errors');
    errors.innerHTML = '';

    for (const item in info['messages']) {
        errors.innerHTML += info['messages'][item] + "<br>";
    }
}

