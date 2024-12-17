<?php


return [
    'paths' => ['api/*', 'zoho/*'], // Add your routes here
    'allowed_methods' => ['*'],    // Allow all methods (GET, POST, PUT, DELETE, etc.)
    'allowed_origins' => ['http://localhost:3000'], // React front-end URL
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],   // Allow all headers
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // Allow cookies and session handling
];

