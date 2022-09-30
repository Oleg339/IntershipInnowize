function confirmDeleting(id) {
    if (confirm("Are you sure?")) {
        fetch('/users/' + id, {
            method: 'DELETE'
        })
        document.location.href = "/users";
    }
}

async function confirmForm(id) {
    const form = document.getElementById("form");
    let response = await fetch('/users/' + id, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json'
        },
        body: new URLSearchParams(new FormData(form))
    });

    if (response.ok) {
        document.location.href = "/users";
    }

    let info = await response.json();

    for (const item in info['messages']) {
        document.getElementById('errors').innerHTML += info['messages'][item] + "<br>";
    }
}

