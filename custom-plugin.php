<?php
/*
 * Plugin Name:       My Comments Plugin
 * Plugin URI:        https://github.com/UchiG
 * Description:       Save post comments to an API
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Uchirai Govere
 * Author URI:        https://uchirai-govere.vercel.app/
 */

// Plugin code above the closing PHP tag

// Hook into the comment post action
add_action('comment_post', 'my_comments_plugin_save_comment');

// Function to save comment to the API
function my_comments_plugin_save_comment($comment_id) {
    $comment = get_comment($comment_id);

    // Prepare the data to be sent to the API
    $data = array(
        'author' => $comment->comment_author,
        'email' => $comment->comment_author_email,
        'content' => $comment->comment_content
    );

    // Convert data to JSON format
    $json_data = json_encode($data);

    // Send the data to the API using cURL or any HTTP library of your choice
    $api_url = 'https://api.juniortest-uchirai-govere.com/comments'; // Replace with your API endpoint URL
    $response = wp_remote_post($api_url, array(
        'body' => $json_data,
        'headers' => array('Content-Type' => 'application/json')
    ));

    // Handle the API response if needed
    if (is_wp_error($response)) {
        // API request failed
        error_log('API request failed: ' . $response->get_error_message());
    } else {
        // API request succeeded
        $response_code = wp_remote_retrieve_response_code($response);
        if ($response_code === 200) {
            // Comment saved successfully to the API
            error_log('Comment saved to the API: ' . $comment_id);
        } else {
            // API request returned an error
            error_log('API request returned an error: ' . $response_code);
        }
    }
}
