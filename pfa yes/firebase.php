<?php
// Firebase configuration
$firebase_url = 'https://dht11-new1-default-rtdb.firebaseio.com/';  // Replace with your Firebase database URL
$firebase_secret = 'CoPfUnxoGbDiBJ3w31T2pAUq95dk8MN7rpuxa5Tn';  // Replace with your Firebase database secret
$firebase_api_key = 'AIzaSyA0_votMsZ3r0KhS4_1L5FrFzEpTaNqdqU';
// Function to make a GET request to Firebase
function getFirebaseData($endpoint)
{
    global $firebase_url, $firebase_secret, $firebase_api_key;

    $url = $firebase_url . $endpoint . '.json'; // Firebase uses .json for REST API

    // Include the authentication parameter if using secret or API key
    if ($firebase_secret) {
        $url .= '?auth=' . $firebase_secret;
    } elseif ($firebase_api_key) {
        $url .= '?key=' . $firebase_api_key;
    }

    // Use cURL to make the HTTP GET request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($http_status !== 200) {
        // Handle HTTP errors
        echo "Error: Unable to fetch data from Firebase. HTTP Status Code: " . $http_status;
        return null;
    }

    curl_close($ch);

    return json_decode($response, true); // Decode JSON response into an associative array
}

// Example usage: Get data from Firebase and display it
$data = getFirebaseData('your-endpoint'); // Replace 'your-endpoint' with your Firebase data node/collection

if ($data) {
    echo "Firebase data:";
    echo "<pre>";
    print_r($data);
    echo "</pre>";
} else {
    echo "No data found.";
}
