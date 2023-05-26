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
        'name' => $comment->comment_author, // Change 'author' to 'name' to match the Laravel validation rule
        'comment' => $comment->comment_content
    );

    // Send the data to the API using cURL or any HTTP library of your choice
    $api_url = 'https://api.juniortest-uchirai-govere.com/comments';
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Handle the API response if needed
    if ($response === false) {
        // API request failed
        error_log('API request failed: ' . curl_error($ch));
    } else {
        // API request succeeded
        $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($response_code === 201) {
            // Comment saved successfully to the API
            error_log('Comment saved to the API: ' . $comment_id);
        } else {
            // API request returned an error
            error_log('API request returned an error: ' . $response_code);
        }
    }
}
