<?php
function custom_admin_footer_text($footer_text)
{
    $custom_text = 'All rights reserved. <a href="https://lisco-solutions.com/" data-type="link" data-id="https://lisco-solutions.com/" target="_blank" rel="noreferrer noopener">LiSco Solutions</a> © 2023-2024.';
    return $custom_text;
}
add_filter('admin_footer_text', 'custom_admin_footer_text');
function custom_admin_version_text($version)
{
    $custom_version_text = 'Developed by <a href="https://lisco-solutions.com" target="_blank" rel="noreferrer noopener">LiSco Solutions</a>';
    return $custom_version_text;
}
add_filter('update_footer', 'custom_admin_version_text', 9999);