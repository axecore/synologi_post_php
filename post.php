<?php

function post_nas_synologi($url, $sid, $did, $path, $filename, $fileContent, $fileMimeType)
{
    $api = 'SYNO.FileStation.Upload';
    $version = '2';
    $method = 'upload';
    $path = $path;
    $createParents = 'true';
    $overwrite = 'true';
    $filename = $filename;
    $fileContent = $fileContent;
    $fileMimeType = $fileMimeType;

    $postFields = [
        [
            'name' => 'api',
            'contents' => $api
        ],
        [
            'name' => 'version',
            'contents' => $version
        ],
        [
            'name' => 'method',
            'contents' => $method
        ],
        [
            'name' => 'path',
            'contents' => $path
        ],
        [
            'name' => 'create_parents',
            'contents' => $createParents
        ],
        [
            'name' => 'overwrite',
            'contents' => $overwrite
        ],
        [
            'name' => 'file',
            'contents' => $fileContent,
            'filename' => $filename,
            'headers' => [
                'Content-Type' => $fileMimeType
            ]
        ]
    ];

    $boundary = '---011000010111000001101001';
    $postBody = '';

    foreach ($postFields as $postField) {
        $postBody .= "--{$boundary}\r\n";
        $postBody .= "Content-Disposition: form-data; name=\"{$postField['name']}\"";
        
        if (isset($postField['filename'])) {
            $postBody .= "; filename=\"{$postField['filename']}\"\r\n";
            $postBody .= "Content-Type: {$postField['headers']['Content-Type']}\r\n\r\n";
            $postBody .= $postField['contents'] . "\r\n";
        } else {
            $postBody .= "\r\n\r\n";
            $postBody .= $postField['contents'] . "\r\n";
        }
    }

    $postBody .= "--{$boundary}--";

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
        CURLOPT_POSTFIELDS => $postBody,
        CURLOPT_HTTPHEADER => [
            "Content-Type: multipart/form-data; boundary={$boundary}",
        ],
        CURLOPT_COOKIE => "id=$sid; did=$did",
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo $err;
    } else {
        echo $response;
    }
}