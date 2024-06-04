async function uploadImage() {
    var form = document.getElementById("uploadForm");
    var formData = new FormData(form);

    try {
        const response = await fetch('upload.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.text();
        document.getElementById("status").innerHTML = result;
    } catch (error) {
        console.error('Error:', error);
    }
}
