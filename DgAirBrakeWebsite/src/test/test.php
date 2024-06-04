<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Image Upload</title>
</head>
<body>
<form id="uploadForm" enctype="multipart/form-data">
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="button" value="Upload Image" onclick="uploadImage()">
</form>

<div id="status"></div>

<script src="script.js"></script>
</body>
</html>
