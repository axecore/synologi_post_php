<?php


function post_delete_nas_synologi($url, $sid, $filePath)
{
    $api = 'SYNO.FileStation.Delete';
    $version = '2';
    $method = 'delete';

    $postFields = [
        'api' => $api,
        'version' => $version,
        'method' => $method,
        'path' => json_encode([$filePath]),
        'force_clean' => 'true'
    ];

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_PORT => 5000,
        CURLOPT_URL => "$url?_sid=$sid",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => http_build_query($postFields),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/x-www-form-urlencoded"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }
}
