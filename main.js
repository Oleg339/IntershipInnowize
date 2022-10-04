async function uploadFile() {
    var files = document.getElementById("file").files;

    if (files.length === 0) {
        alert("Please select a file");
    }

    var formData = new FormData();
    formData.append("file", files[0]);

    let response = await fetch('Controller/FileController.php', {
        method: 'POST',
        body: formData
    });

    let data = await response.json();

    document.getElementById('fileInf').innerHTML = ''
    document.getElementById('fileInf').innerHTML += '<tr><td>name: ' + data['name'] + '</td></tr>'
    document.getElementById('fileInf').innerHTML += '<tr><td>size: ' + data['size'] + ' bytes </td></tr>'

    if(data['meta']){
        document.getElementById('fileInf').innerHTML += '<tr><td>resolution: ' + data['meta'][0] + '/' + data['meta'][1] + '</td></tr>'
        document.getElementById('fileInf').innerHTML += '<tr><td>bits: ' + data['meta']['bits'] + '</td></tr>'
    }

    document.getElementById('errors').innerHTML = '';
    if(data['messages'] !== undefined){
        for (let i = 0; i < data['messages'].length; i++) {
            document.getElementById('errors').innerHTML += data['messages'][i] + '<br>';
        }
    }

    await getFiles();
}

async function getFiles(){
    let response = await fetch('getFiles.php', {
        method: 'GET',
    });

    let data = await response.json();

    document.getElementById('files').innerHTML = '';

    for (let i = 0; i < data.length; i++) {
        document.getElementById('files').innerHTML += '<tr><td>' + data[i] + '</td></tr>';
    }
}
