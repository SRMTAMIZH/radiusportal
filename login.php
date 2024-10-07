<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // RADIUS server configuration
    $radius_server_ip = "192.168.15.254";
    $radius_port = 1812;
    $radius_secret = "your_shared_secret";  // Replace with your shared secret

    // Initialize RADIUS connection
    $radius = radius_auth_open();
    radius_add_server($radius, $radius_server_ip, $radius_port, $radius_secret, 5, 3);
    radius_create_request($radius, RADIUS_ACCESS_REQUEST);

    // Set RADIUS attributes
    radius_put_attr($radius, RADIUS_USER_NAME, $username);
    radius_put_attr($radius, RADIUS_USER_PASSWORD, $password);

    // Send RADIUS request
    $result = radius_send_request($radius);

    // Check authentication result
    if ($result == RADIUS_ACCESS_ACCEPT) {
        // Successful login
        header("Location: success.html"); // Create a success.html page for redirection
    } else {
        // Failed login
        header("Location: failed.html"); // Create a failed.html page for redirection
    }

    // Close RADIUS connection
    radius_close($radius);
}
?>
