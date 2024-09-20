<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $apiKey = 'API_KEY'; // ここにIMGBBのAPIキーを入力
    $image = $_FILES['image'];

    if ($image['error'] === UPLOAD_ERR_OK) {
        $url = 'https://api.imgbb.com/1/upload';
        $imagePath = new CURLFile($image['tmp_name']);

        $data = [
            'key' => $apiKey,
            'image' => $imagePath
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $responseData = json_decode($response, true);

        if (isset($responseData['data']['url'])) {
            $imageUrl = $responseData['data']['url'];
            $cdnUrl = 'https://cdn.statically.io/img/i.ibb.co/' . basename($imageUrl); // CDNリンクの生成
            
            echo "<h2>アップロード成功！</h2>";
            echo "<img src='$imageUrl' alt='Uploaded Image' width='300'><br>";
            echo "<h2>埋め込みコード:</h2>";
            echo "<textarea readonly onclick='this.select();'> &lt;img src=&quot;$cdnUrl&quot; alt=&quot;Uploaded Image&quot; /&gt;</textarea>";
        } else {
            echo "<h2>アップロード失敗</h2>";
            echo "<p>{$responseData['error']}</p>";
        }
    } else {
        echo "<h2>画像のアップロードに失敗しました。</h2>";
    }
} else {
    echo "<h2>不正なリクエストです。</h2>";
}
?>
