<?php

return [

    'oneID' => [
        'url' => env('ONEID_URL', 'https://sso.egov.uz/sso/oauth/Authorization.do'),
        'client_id' => env('ONEID_CLIENT_ID', ''),
        'client_secret' => env('ONEID_CLIENT_SECRET', ''),
        'redirect_uri' => env('ONEID_REDIRECT_URI', ''),
        'scope' => env('ONEID_SCOPE', ''),
        'state' => env('ONEID_STATE', ''),
    ]

];
