<?php

/**
 * Retrieves the client's IP address from various server variables.
 *
 * @return string|null The client's IP address, or null if not found or invalid.
 */
function getClientIp() {
    // Array of possible header names containing client IP
    $headers = [
        'HTTP_CLIENT_IP',
        'HTTP_X_REAL_IP',
        'HTTP_X_FORWARDED_FOR',
        'REMOTE_ADDR'
    ];

    foreach ($headers as $header) {
        if (!empty($_SERVER[$header]) && filter_var($_SERVER[$header], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER[$header];

            // Handle HTTP_X_FORWARDED_FOR which may contain multiple IPs separated by commas
            if ($header === 'HTTP_X_FORWARDED_FOR') {
                $ip = explode(',', $ip)[0]; // Take the first IP in the list
            }

            return preg_replace('/^::ffff:/', '', $ip); // Remove IPv6 compatibility prefix
        }
    }

    return null; // Return null if no valid IP address found
}
