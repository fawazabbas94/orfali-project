<?php
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php wp_head(); ?>
</head>
<style type="text/css">
    .acf-map img {
        max-width: inherit !important;
    }

    :root {
        <?php
        function adjust_color($color, $percent)
        {
            $color = str_replace('rgb(', '', str_replace(')', '', $color));
            [$r, $g, $b] = array_map('intval', explode(',', $color));
            $r = max(0, min(255, $r + ($r * $percent / 100)));
            $g = max(0, min(255, $g + ($g * $percent / 100)));
            $b = max(0, min(255, $b + ($b * $percent / 100)));
            return "rgb($r, $g, $b)";
        }
        function rgba($color, $opacity)
        {
            $color = str_replace('rgb(', '', str_replace(')', '', $color));
            [$r, $g, $b] = array_map('intval', explode(',', $color));

            return "rgba($r, $g, $b, $opacity)";
        }
        for ($i = 1; $i <= 10; $i++) {
            $field_name = 'custom_color_' . $i;
            $main_color = get_field($field_name, 'option');
            if ($main_color) {
                echo '--rem-c' . $i . '-main: ' . $main_color . ';';
                $light_color = adjust_color($main_color, 15);
                $dark_color = adjust_color($main_color, -15);
                echo '--rem-c' . $i . '-light: ' . $light_color . ';';
                echo '--rem-c' . $i . '-dark: ' . $dark_color . ';';
                foreach (['main' => $main_color, 'light' => $light_color, 'dark' => $dark_color] as $key => $color) {
                    for ($j = 5; $j <= 100; $j += 5) {
                        $opacity = $j / 100;
                        echo '--rem-c' . $i . '-' . $key . '-' . $j . ': ' . rgba($color, $opacity) . ';';
                    }
                }
            }
        }
        $border_radius = get_field('border_radius', 'option');
        $button_border_radius = get_field('button_border_radius', 'option');
        $input_border_radius = get_field('input_border_radius', 'option');
        echo '--rem-border-radius: ' . $border_radius . 'px;';
        echo '--rem-button-border-radius: ' . $button_border_radius . 'px;';
        echo '--rem-input-border-radius: ' . $input_border_radius . 'px;';
        ?>
    }
</style>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7G7CsDfSWsni0Rm7p0nSoVgoaZLIxVWo&callback=Function.prototype"></script>
<script type="text/javascript">
    (function($) {
        function initMap($el) {
            var $markers = $el.find('.marker');
            var mapArgs = {
                zoom: $el.data('zoom') || 13,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map($el[0], mapArgs);
            map.markers = [];
            $markers.each(function() {
                initMarker($(this), map);
            });
            centerMap(map);
            return map;
        }

        function initMarker($marker, map) {
            var lat = $marker.data('lat');
            var lng = $marker.data('lng');
            var latLng = {
                lat: parseFloat(lat),
                lng: parseFloat(lng)
            };
            <?php
            $map_marker = get_field('map_marker');
            if ($map_marker === 'circle') :
            ?>
                var icon = {
                    url: 'https://temp1.lisco-solutions.com/wp-content/uploads/2024/06/marker.png',
                    size: new google.maps.Size(156, 156),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(78, 78)
                };
            <?php elseif ($map_marker === 'default') : ?>
                var icon = null
            <?php endif; ?>
            var marker = new google.maps.Marker({
                position: latLng,
                map: map,
                icon: icon
            });

            map.markers.push(marker);

            if ($marker.html()) {
                var infowindow = new google.maps.InfoWindow({
                    content: $marker.html()
                });
                google.maps.event.addListener(marker, 'click', function() {
                    infowindow.open(map, marker);
                });
            }
        }

        function centerMap(map) {
            var bounds = new google.maps.LatLngBounds();
            map.markers.forEach(function(marker) {
                bounds.extend({
                    lat: marker.position.lat(),
                    lng: marker.position.lng()
                });
            });
            if (map.markers.length == 1) {
                map.setCenter(bounds.getCenter());
            } else {
                map.fitBounds(bounds);
            }
        }

        $(document).ready(function() {
            $('.acf-map').each(function() {
                var map = initMap($(this));
            });
        });
    })(jQuery);
</script>

<body <?php
        if (is_single() && 'post' === get_post_type()) {
            $country = get_field('country');
            $body_classes = join(' ', get_body_class());
            if ($country) {
                $body_classes .= ' ' . sanitize_html_class($country->slug);
            } else {
                $body_classes .= ' global';
            }
            echo 'class="' . esc_attr($body_classes) . '"';
        } else {
            body_class();
        }
        ?>>
    <?php if (function_exists('wp_body_open')) : ?>
        <?php wp_body_open(); ?>
    <?php endif; ?>
    <?php do_action('woodmart_after_body_open'); ?>
    <div class="website-wrapper <?php echo (is_single() && 'post' === get_post_type()) ? ($country ? $country->slug : 'global') : ''; ?>">
        <?php if (woodmart_needs_header()) : ?>
            <?php if (!function_exists('elementor_theme_do_location') || !elementor_theme_do_location('header')) : ?>
                <header <?php woodmart_get_header_classes(); ?>>
                    <?php whb_generate_header(); ?>
                </header>
            <?php endif; ?>
            <?php woodmart_page_top_part(); ?>
        <?php endif ?>