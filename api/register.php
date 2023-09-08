<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../const.php';
require __DIR__ . '/../connect.php';
require __DIR__ . '/../tools.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

error_reporting(E_ERROR | E_PARSE);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_user_data_auth = file_get_contents('php://input');
    $decoded_data = json_decode($new_user_data_auth, true);
    $decoded_data['pass'] = crypt_tool($decoded_data['pass']);

    pg_prepare(
        $dbconn,
        'reg_new_user',
        'INSERT INTO users(username, encrypted_pass, user_email) VALUES ($1, $2, $3)'
    );
    if (!pg_connection_busy($dbconn)) {
        pg_send_execute(
            $dbconn,
            'reg_new_user',
            $decoded_data
        );
    }
    $result = pg_get_result($dbconn);

    if ($result) {
        // An error occurred, fetch the PostgreSQL error message
        header("Content-Type: application/json");
        $error_message = pg_last_error($dbconn);
        $error_code = pg_result_error_field($result, PGSQL_DIAG_SQLSTATE);
        // Construct an error response in JSON format
        $response = array(
            'success' => false,
            'message' => 'Query failed',
            'error' => $error_message,
            'error_code' => $error_code // Include the PostgreSQL error code
        );

        // Convert the response array to JSON
        $json_response = json_encode($response);

        // Set the HTTP response code to indicate an error (e.g., 400 Bad Request)
        //http_response_code(400);

        // Output the JSON response
        echo $json_response;
    } else {
        $response = array(
            'success' => true,
            'message' => 'User registered successfully'
        );

        // Convert the response array to JSON
        $json_response = json_encode($response);

        // Output the JSON response
        echo $json_response;
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    phpinfo();
}
