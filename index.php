<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>画像アップロード</title>
    <style>
        #preview {
            display: none;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>画像をアップロード</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data" id="uploadForm">
        <input type="file" name="image" accept="image/*" required onchange="previewImage(event)">
        <input type="submit" value="アップロード">
    </form>
    <div id="preview">
        <h2>プレビュー:</h2>
        <img id="previewImage" alt="選択した画像" width="300">
    </div>

    <script>
        function previewImage(event) {
            const preview = document.getElementById('preview');
            const previewImage = document.getElementById('previewImage');
            const file = event.target.files[0];
            const reader = new FileReader();
            
            reader.onload = function() {
                previewImage.src = reader.result;
                preview.style.display = 'block';
            }
            
            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        }
    </script>
</body>
</html>
