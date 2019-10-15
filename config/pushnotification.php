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
        'apiKey' => env('FCM_KEY','AAAALbV5u8k:APA91bHVW1O6hfCHIjUZjzkiAaVoWdn7_uH88Pod_6RoEvQBin2ms4HP5NKF3HOU_68GaWSWM9EVcq4QHX8JZXWkdtNE007E-UAr-VMKQcXuRdWLPv0jFuATPrxQTDNZidBgHOpVJ87Z')
    ],
    'apn' => [
        'certificate' => __DIR__ . '/iosCertificates/certificado.pem',
        'passPhrase' => 'soltecnologica', //Optional
        'passFile' => '', //Optional
        'dry_run' => false,
    ],
];
