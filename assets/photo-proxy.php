<?php
// Meneruskan foto dari Google Drive lewat domain sendiri.
// Kenapa perlu: Google mengirim header "Cross-Origin-Resource-Policy: same-site"
// pada file Drive, yang membuat browser pengunjung MENOLAK menampilkannya
// langsung sebagai <img> dari domain lain (nugal.id). Permintaan dari server
// ke server (di sini) tidak terkena pembatasan itu, jadi gambar diteruskan
// apa adanya dari domain kita sendiri.
//
// Staf cukup paste link "Bagikan" Google Drive biasa ke kolom foto_url di
// Sheet (file harus "Anyone with the link can view") -- index.html otomatis
// mengubahnya menjadi assets/photo-proxy.php?id=FILE_ID lewat fungsi
// photoUrl() di script.

$id = $_GET['id'] ?? '';
if (!preg_match('/^[A-Za-z0-9_-]{10,100}$/', $id)) {
    http_response_code(400);
    header('Content-Type: text/plain');
    exit('ID tidak valid');
}

$url = 'https://drive.usercontent.google.com/download?id=' . $id . '&export=view';

$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'header' => "User-Agent: Mozilla/5.0 (compatible; NugalPhotoProxy/1.0)\r\n",
        'timeout' => 10,
        'follow_location' => 1,
        'max_redirects' => 5,
        'ignore_errors' => true,
    ],
]);

$data = @file_get_contents($url, false, $context);
$contentType = '';
foreach ($http_response_header ?? [] as $header) {
    if (stripos($header, 'Content-Type:') === 0) {
        $contentType = trim(substr($header, strlen('Content-Type:')));
    }
}

if ($data === false || strpos($contentType, 'image/') !== 0) {
    http_response_code(502);
    header('Content-Type: text/plain');
    exit('Foto tidak dapat diambil dari Drive. Pastikan file dibagikan sebagai "Anyone with the link can view".');
}

header('Content-Type: ' . $contentType);
header('Content-Length: ' . strlen($data));
header('Cache-Control: public, max-age=86400');
echo $data;
