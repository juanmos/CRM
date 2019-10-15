<?php
/**
 * @see https://github.com/Edujugon/PushNotification
 */

return [
    'gcm' => [
        'priority' => 'normal',
        'dry_run' => false,
        'apiKey' => env('GCM_KEY','AIzaSyBBUcbe1imTPCkj-fx1XjGvLa2Ki0Pfi5U')
    ],
    'fcm' => [
        'priority' => 'normal',
        'dry_run' => false,
        'apiKey' => 'My_ApiKey',
    ],
    'apn' => [
        'certificate' => __DIR__ . '/iosCertificates/certificado.pem',
        'passPhrase' => 'soltecnologica', //Optional
        'passFile' => '', //Optional
        'dry_run' => false,
    ],
];
