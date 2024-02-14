<?php
// Allow requests from any origin (for development purposes; update this to a specific domain in production)
header("Access-Control-Allow-Origin: *");

// Prevent caching by setting Cache-Control headers
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Define the external API URL
$apiUrl = 'https://proxylist.geonode.com/api/ip';

// Get the client's IP address
$clientIp = $_SERVER['REMOTE_ADDR'];

// Create context options with the client's IP as a custom header
$contextOptions = [
    'http' => [
        'header' => "Client-Ip: $clientIp\r\n"
    ]
];

// Create a stream context with the options
$context = stream_context_create($contextOptions);

// Fetch data from the external API with the custom headers
$data = file_get_contents($apiUrl, false, $context);

// Serve the data to the client
header('Content-Type: application/json');
echo $data;

?>