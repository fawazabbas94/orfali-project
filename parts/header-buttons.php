<?php
function get_header_button_data()
{
    $header_contact_button_for_turkiye = get_field('header_contact_button_for_turkiye', 'option');
    $header_contact_button_for_uae = get_field('header_contact_button_for_uae', 'option');
    $header_contact_button_for_global = get_field('header_contact_button_for_global', 'option');
    $body_classes = get_body_class();
    if (in_array('uae', $body_classes)) {
        return $header_contact_button_for_uae ?? [];
    } elseif (in_array('turkiye', $body_classes)) {
        return $header_contact_button_for_turkiye ?? [];
    } else {
        return $header_contact_button_for_global ?? [];
    }
}
$header_button_data = get_header_button_data();
$button_text = $header_button_data['button_text'] ?? '';
$button_link = $header_button_data['button_link'] ?? '';
$button_icon_data = $header_button_data['button_icon'] ?? '';
$button_icon = '';
if (is_numeric($button_icon_data)) {
    $button_icon = wp_get_attachment_image_url($button_icon_data, 'full');
} elseif (is_array($button_icon_data) && isset($button_icon_data['url'])) {
    $button_icon = $button_icon_data['url'];
} elseif (is_string($button_icon_data)) {
    $button_icon = $button_icon_data;
}
?>
<div class="wd-button-wrapper text-center">
    <a href="<?php echo esc_url($button_link); ?>" title="" target="_blank"
        class="btn btn-color-white btn-style-bordered btn-style-round btn-size-default header-whatsapp btn-icon-pos-left">
        <?php echo esc_html($button_text); ?>
        <span class="wd-btn-icon">
            <?php if ($button_icon): ?>
                <img width="682" height="682" src="<?php echo esc_url($button_icon); ?>"
                    class="attachment-20x20 size-20x20" alt="" decoding="async">
            <?php endif; ?>
        </span>
    </a>
</div>