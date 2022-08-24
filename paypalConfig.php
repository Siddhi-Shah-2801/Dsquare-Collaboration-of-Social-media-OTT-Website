<?php
require_once("PayPal-PHP-SDK/autoload.php");

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'Aes4wf-s03i-gpzwN5YF_nC_7tVPgCGDz7qYARgRKbMuAso8c3Vzr9hvm4yHzibru_5-4K65jw-kOpeJ',     // ClientID
        'ECONiQ69Wiq4WnJdRqi3o4Z-5Xs6Bjx6AD2w2nV8eedt5SVkV4ENBufAP5Zv4sb_u4QFDPq9LYgWgCj6'      // ClientSecret
    )
);
?>