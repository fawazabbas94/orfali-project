<?php
// register image sizes
add_image_size('slider', 1200, 700, true);
add_image_size('projectfeaturedimage', 768, 512, true);
add_image_size('listingfeaturedimage', 768, 512, true);
add_image_size('sliderthumb', 120, 70, true);
add_image_size('testimonialfeaturedimage', 512, 512, true);
add_image_size('memberimage', 512, 512, true);
add_image_size('companylogo', 512, 512, true);
add_image_size('areafeaturedimage', 600, 400, true);
// connect google maps
function my_acf_google_map_api($api)
{
    $api['key'] = 'AIzaSyD7G7CsDfSWsni0Rm7p0nSoVgoaZLIxVWo';
    return $api;
}
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');
// disable auto p in contact form 7
add_filter('wpcf7_autop_or_not', '__return_false');
// copy link button
function create_and_add_copy_link_button()
{
    function create_copy_link_button($atts)
    {
        $atts = shortcode_atts(
            array(
                'image_url' => '',
                'alt_text' => 'Copy Link',
            ),
            $atts,
            'copy_link_button'
        );
        if (empty($atts['image_url'])) {
            return 'Copy';
        }
        return '<button class="copy-link-button" style="border: none; background: none; padding: 0; cursor: pointer;">' .
            '<img src="' . esc_url($atts['image_url']) . '" alt="' . esc_attr($atts['alt_text']) . '" />' .
            '</button>';
    }
    add_shortcode('copy_link_button', 'create_copy_link_button');
    $copy_link_button_html = do_shortcode('[copy_link_button image_url="/wp-content/themes/woodmart-child/icons/interface-icons/link.svg" alt_text="Copy Link"]');
    $social_buttons = do_shortcode('[social_buttons]');
?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var copyLinkButtonHtml = '<?php echo addslashes($copy_link_button_html); ?>';
            var socialbuttons = '<?php echo json_encode($social_buttons); ?>';
            socialbuttons = socialbuttons.slice(1, -1);
            var targets = document.querySelectorAll('div.wd-social-icons');
            targets.forEach(function(target) {
                target.insertAdjacentHTML('beforeend', copyLinkButtonHtml);
            });
            var mobilenav = document.querySelectorAll('div.mobile-nav');
            mobilenav.forEach(function(nav) {
                nav.insertAdjacentHTML('beforeend', socialbuttons);
            });
            document.querySelectorAll(".copy-link-button").forEach(function(button) {
                button.addEventListener("click", function() {
                    const link = window.location.href.split('#')[0] + '#' + button.id;
                    const tempInput = document.createElement("input");
                    tempInput.value = link;
                    document.body.appendChild(tempInput);
                    tempInput.select();
                    document.execCommand("copy");
                    document.body.removeChild(tempInput);
                    button.classList.add("copied");
                    setTimeout(function() {
                        button.classList.remove("copied");
                    }, 1000);
                });
            });
        });
    </script>
<?php
}
add_action('wp_footer', 'create_and_add_copy_link_button');

// page custom class
function add_custom_classes_to_body($classes)
{
    if (is_page()) {
        $page_id = get_the_ID();
        $custom_classes = get_field('custom_class', $page_id);
        if (!empty($custom_classes)) {
            $custom_classes_array = array_map('trim', explode(',', $custom_classes));
            foreach ($custom_classes_array as $custom_class) {
                $classes[] = sanitize_html_class($custom_class);
            }
        }
        $predefined_classes = get_field('predefined_classes', $page_id);
        if (!empty($predefined_classes) && is_array($predefined_classes)) {
            foreach ($predefined_classes as $predefined_class) {
                $classes[] = sanitize_html_class($predefined_class);
            }
        }
    }
    return $classes;
}
add_filter('body_class', 'add_custom_classes_to_body');

// init sliders & carousels
function init_slider()
{
?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Helper function to initialize Fancybox
            function initFancybox(selector, fancyboxOptions) {
                Fancybox.bind(selector, fancyboxOptions);
            }

            // Helper function to initialize Carousel
            function initCarousel(elementId, options) {
                const element = document.getElementById(elementId);
                if (element) {
                    new Carousel(element, options);
                }
            }

            // Common Fancybox options
            const commonFancyboxOptions = {
                infinite: true,
                compact: true,
                idle: true,
                animated: true,
                showClass: true,
                hideClass: true,
                dragToClose: true,
                Toolbar: {
                    display: {
                        left: ["infobar"],
                        middle: [],
                        right: ["slideshow", "fullscreen", "close"],
                    },
                },
            };

            // Initialize Single Listing Photos Carousel with Fancybox
            const singleListingGallery = document.getElementById("single-listing-gallery");
            if (singleListingGallery) {
                new Carousel(singleListingGallery, {
                    infinite: true,
                    contentClick: "iterateZoom",
                    Images: {
                        Panzoom: {
                            maxScale: 2,
                        },
                    },
                });

                initFancybox('[data-fancybox="single-listing-gallery"]', {
                    ...commonFancyboxOptions,
                    Image: {
                        zoom: true,
                    },
                    Thumbs: {
                        type: "modern",
                        center: true,
                        Carousel: {
                            center: true,
                            fill: true,
                            classes: {
                                container: "f-thumbs f-modern-thumbs",
                                viewport: "f-modern-thumbs__viewport",
                                track: "f-modern-thumbs__track",
                                slide: "f-modern-thumbs__slide",
                            },
                        },
                    },
                });
            }

            // Initialize video Fancybox
            initFancybox('[data-fancybox="video"]', {
                ...commonFancyboxOptions,
                Toolbar: {
                    display: {
                        left: ["infobar"],
                        middle: [],
                        right: ["fullscreen", "close"],
                    },
                },
            });

            // Initialize project gallery Fancybox
            initFancybox('[data-fancybox="project-gallery-carousel"]', {
                ...commonFancyboxOptions,
                Image: {
                    zoom: true,
                },
                Thumbs: {
                    type: "modern",
                    center: true,
                    Carousel: {
                        center: true,
                        fill: true,
                        classes: {
                            container: "f-thumbs f-modern-thumbs",
                            viewport: "f-modern-thumbs__viewport",
                            track: "f-modern-thumbs__track",
                            slide: "f-modern-thumbs__slide",
                        },
                    },
                },
            });

            // Common Carousel options
            const carouselOptions = {
                default: {
                    infinite: true,
                    center: false,
                    transition: false,
                    slidesPerPage: 1, // Show 1 slide at a time on mobile
                    fill: false, // Don't stretch slides to fill viewport
                    preload: 1, // Preload adjacent slides
                    // Add responsive breakpoints
                    breakpoints: {
                        "(min-width: 640px)": {
                            slidesPerPage: 2,
                        },
                        "(min-width: 768px)": {
                            slidesPerPage: 3,
                        },
                        "(min-width: 1024px)": {
                            slidesPerPage: 4,
                        },
                    },
                },
                projectGallery: {
                    infinite: true,
                    center: false,
                    transition: false,
                    slidesPerPage: "2",
                },
                types: {
                    infinite: true,
                    center: false,
                    transition: false,
                    slidesPerPage: "7",
                    Dots: {
                        dynamicFrom: false,
                    },
                },
                districts: {
                    infinite: true,
                    center: false,
                    transition: false,
                    slidesPerPage: "6",
                    Dots: {
                        dynamicFrom: false,
                    },
                },
                companies: {
                    infinite: true,
                    center: false,
                    transition: false,
                    slidesPerPage: "6",
                    Dots: {
                        dynamicFrom: false,
                    },
                },
                people: {
                    infinite: true,
                    center: false,
                    transition: false,
                    slidesPerPage: "5",
                    Dots: {
                        dynamicFrom: false,
                    },
                },
            };

            // Initialize Carousels
            const carousels = [{
                    id: "related-projects-carousel",
                    options: carouselOptions.default
                },
                {
                    id: "related-listings-carousel",
                    options: carouselOptions.default
                },
                {
                    id: "testimonials-carousel",
                    options: carouselOptions.default
                },
                {
                    id: "project-gallery-carousel",
                    options: carouselOptions.projectGallery
                },
                {
                    id: "careers-carousel",
                    options: carouselOptions.default
                },
                {
                    id: "types-carousel",
                    options: carouselOptions.types
                },
                {
                    id: "districts-carousel",
                    options: carouselOptions.districts
                },
                {
                    id: "companies-carousel",
                    options: carouselOptions.companies
                },
                {
                    id: "people-carousel",
                    options: carouselOptions.people
                },
                {
                    id: "best-payment-plans",
                    options: carouselOptions.default
                },
                {
                    id: "luxury-branded-projects",
                    options: carouselOptions.default
                },
                {
                    id: "most-affordable",
                    options: carouselOptions.default
                },
                {
                    id: "most-recent-launches",
                    options: carouselOptions.default
                },
                {
                    id: "our-top-picks",
                    options: carouselOptions.default
                },
                {
                    id: "home-page-projects",
                    options: carouselOptions.default
                },
                {
                    id: "home-page-listings",
                    options: carouselOptions.default
                },
            ];
            carousels.forEach(({
                id,
                options
            }) => initCarousel(id, options));
        });
    </script>

<?php
}
add_action('wp_footer', 'init_slider');
// active filters collapsible
function init_active_filters_collapsible()
{
?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterTitle = document.querySelector('.active-filter-title');
            const filters = document.querySelector('.archive-active-filter');
            const arrow = filterTitle.querySelector('.arrow');
            const facetwpSelections = document.querySelector('.facetwp-selections');

            function toggleFilterButton() {
                if (facetwpSelections && facetwpSelections.children.length > 0) {
                    filterTitle.style.display = 'flex';
                } else {
                    filterTitle.style.display = 'none';
                    filters.style.maxHeight = '0px';
                }
            }
            filterTitle.addEventListener('click', function() {
                if (filters.style.maxHeight === '0px' || filters.style.maxHeight === '') {
                    filters.style.maxHeight = filters.scrollHeight + 'px';
                    arrow.classList.remove('down');
                    arrow.classList.add('up');
                } else {
                    filters.style.maxHeight = '0px';
                    arrow.classList.remove('up');
                    arrow.classList.add('down');
                }
            });
            toggleFilterButton();
            const observer = new MutationObserver(toggleFilterButton);
            if (facetwpSelections) {
                observer.observe(facetwpSelections, {
                    childList: true
                });
            }
        });
    </script>
<?php
}
add_action('wp_footer', 'init_active_filters_collapsible');
// shortcode to include a PHP file
function include_php_file_shortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'path'    => '',
            'country' => '',
            'city'    => '',
            'type'    => '',
            'tag'    => '',
            'position'     => '',
        ),
        $atts,
        'snippet'
    );
    $file_path = get_stylesheet_directory() . $atts['path'];
    if (file_exists($file_path)) {
        ob_start();
        include $file_path;
        return ob_get_clean();
    } else {
        return 'File not found: ' . esc_html($atts['path']);
    }
}
add_shortcode('snippet', 'include_php_file_shortcode');
// hide filter counts
add_filter('facetwp_facet_dropdown_show_counts', '__return_false');
// accordion
function accordion()
{
?>
    <script>
        const items = document.querySelectorAll('.accordion button');

        function toggleAccordion() {
            const itemToggle = this.getAttribute('aria-expanded');

            for (i = 0; i < items.length; i++) {
                items[i].setAttribute('aria-expanded', 'false');
            }

            if (itemToggle == 'false') {
                this.setAttribute('aria-expanded', 'true');
            }
        }

        items.forEach((item) => item.addEventListener('click', toggleAccordion));
    </script>
<?php
}
add_action('wp_footer', 'accordion');
// preload facets
add_filter('facetwp_preload_url_vars', function ($url_vars) {
    // Get the current path without trimming slashes
    $current_path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    // Check if the current path matches specific conditions
    if ($current_path === 'uae/off-plan/projects') {
        if (empty($url_vars['p_country'])) {
            $url_vars['p_country'] = ['uae'];
        }
        if (empty($url_vars['p_city'])) {
            $url_vars['p_city'] = ['dubai'];
        }
        if (empty($url_vars['p_type'])) { // Assuming 'type' is the key for property type
            $url_vars['p_type'] = ['off-plan'];
        }
    } elseif ($current_path === 'turkiye/off-plan/projects') {
        if (empty($url_vars['p_country'])) {
            $url_vars['p_country'] = ['turkiye'];
        }
        if (empty($url_vars['p_city'])) {
            $url_vars['p_city'] = ['istanbul'];
        }
        if (empty($url_vars['p_type'])) { // Assuming 'type' is the key for property type
            $url_vars['p_type'] = ['off-plan'];
        }
    }
    return $url_vars;
});

// Hide search in fselect
add_filter('facetwp_render_output', function ($output) {
    $facets = FWP()->helper->get_facets();
    foreach ($facets as $facet) {
        if ('fselect' == $facet['type'] || (isset($facet['ui_type']) && 'fselect' == $facet['ui_type'])) {
            $output['settings'][$facet['name']]['showSearch'] = false;
        }
    }
    return $output;
});

add_filter('facetwp_render_output', function ($output) {
    $output['settings']['district']['numDisplayed'] = 2;
    return $output;
});

add_filter('facetwp_render_output', function ($output) {
    $output['settings']['auto_complete']['numDisplayed'] = 1;
    return $output;
});
add_filter('facetwp_render_output', function ($output) {
    $output['settings']['auto_complete']['showSearch'] = true;
    return $output;
});
add_filter('facetwp_render_output', function ($output) {
    $output['settings']['auto_complete_project']['numDisplayed'] = 1;
    return $output;
});
add_filter('facetwp_render_output', function ($output) {
    $output['settings']['auto_complete_project']['showSearch'] = true;
    return $output;
});
function add_category_filter_after_title()
{
    // Only show on blog page
    if (!is_home() && !is_archive()) {
        return;
    }

    $categories = get_categories(array(
        'orderby' => 'name',
        'order' => 'ASC',
        'hide_empty' => true
    ));

    $current_cat_id = is_category() ? get_queried_object_id() : 0;
    $blog_url = get_permalink(get_option('page_for_posts'));
?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var pageTitle = document.querySelector('.wd-page-title');
            if (pageTitle) {
                var filterHtml = `
                <div class="category-filter-wrapper" style="margin: 20px 0;">
                    <div class="category-filter-container">
                        <button class="carousel-arrow carousel-prev" aria-label="Previous">
                            <
                        </button>
                        <div class="category-filter-scroll">
                            <div class="category-filter">
                                <a href="<?php echo esc_url($blog_url); ?>" class="filter-link <?php echo (!is_category()) ? 'active' : ''; ?>">All</a>
                                <?php foreach ($categories as $category): ?>
                                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="filter-link <?php echo ($current_cat_id == $category->term_id) ? 'active' : ''; ?>"><?php echo esc_html($category->name); ?></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <button class="carousel-arrow carousel-next" aria-label="Next">
                            >
                        </button>
                    </div>
                </div>
            `;
                pageTitle.insertAdjacentHTML('afterend', filterHtml);

                // Initialize carousel
                initCategoryCarousel();
            }
        });

        function initCategoryCarousel() {
            const container = document.querySelector('.category-filter-scroll');
            const prevBtn = document.querySelector('.carousel-prev');
            const nextBtn = document.querySelector('.carousel-next');
            
            if (!container || !prevBtn || !nextBtn) return;

            const scrollAmount = 200; // Adjust scroll distance

            // Check scroll position and update buttons
            function updateButtons() {
                const scrollLeft = container.scrollLeft;
                const scrollWidth = container.scrollWidth;
                const clientWidth = container.clientWidth;

                prevBtn.disabled = scrollLeft <= 0;
                nextBtn.disabled = scrollLeft >= scrollWidth - clientWidth - 10;
                
                prevBtn.style.opacity = prevBtn.disabled ? '0.3' : '1';
                nextBtn.style.opacity = nextBtn.disabled ? '0.3' : '1';
            }

            // Scroll handlers
            prevBtn.addEventListener('click', () => {
                container.scrollBy({
                    left: -scrollAmount,
                    behavior: 'smooth'
                });
            });

            nextBtn.addEventListener('click', () => {
                container.scrollBy({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            });

            // Update buttons on scroll
            container.addEventListener('scroll', updateButtons);
            
            // Initial button state
            updateButtons();

            // Update on window resize
            window.addEventListener('resize', updateButtons);
        }
    </script>
    <style>
        .page-title {
            padding-block-end: 10px !important;
        }

        .category-filter-container {
            position: relative;
            max-width: var(--wd-container-w);
            margin: 0 auto;
            padding: 0 50px; /* Space for arrows */
        }

        .category-filter-scroll {
            overflow-x: auto;
            overflow-y: hidden;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE and Edge */
        }

        .category-filter-scroll::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }

        .category-filter {
            display: flex;
            gap: 15px;
            padding: 5px 0;
            white-space: nowrap;
        }

        .filter-link {
            flex-shrink: 0;
            padding: 8px 16px;
            background: #fff;
            border: 1px solid var(--rem-c2-dark-20);
            text-decoration: none;
            color: #333;
            border-radius: 50px;
            transition: all 0.3s;
            white-space: nowrap;
        }

        .filter-link:hover {
            background: #e0e0e0;
        }

        .filter-link.active {
            background: #333;
            color: #fff;
        }

        .carousel-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            z-index: 10;
        }

        .carousel-arrow:hover:not(:disabled) {
            background: #f5f5f5;
        }

        .carousel-arrow:disabled {
            cursor: not-allowed;
        }

        .carousel-prev {
            left: 6px;
        }

        .carousel-next {
            right: 6px;
        }

        /* Mobile styles */
        @media (max-width: 768px) {
            .category-filter-container {
                padding: 0 55px; /* Smaller padding on mobile */
            }

            .carousel-arrow {
                top: 43%;
                width: 30px;
                height: 30px;
                background: rgba(255, 255, 255, 0.9);
            }

            .carousel-arrow svg {
                width: 18px;
                height: 18px;
            }

            .filter-link {
                padding: 6px 12px;
                font-size: 14px;
            }

            .category-filter {
                gap: 10px;
            }
        }

        /* Touch device - show scroll indicator */
        @media (hover: none) and (pointer: coarse) {
            .category-filter-scroll {
                padding-bottom: 10px;
            }

            /* Optional: Show subtle scroll indicator on mobile */
            .category-filter-container::after {
                content: '';
                position: absolute;
                right: 0;
                top: 0;
                bottom: 0;
                width: 30px;
                background: linear-gradient(to right, transparent, rgba(255,255,255,0.8));
                pointer-events: none;
            }
        }
    </style>
<?php
}
add_action('wp_footer', 'add_category_filter_after_title');
add_action('wp', function () {
    // Only redirect on the actual front page (not blog page)
    if (is_front_page() && !is_home() && !isset($_GET['_for'])) {
        wp_redirect(add_query_arg('_for', 'buy', home_url()));
        exit;
    }
});
function get_fake_post_views($post_id) {
    // Generate base views (50-300) using post ID
    srand($post_id);
    $base_views = rand(50, 300);
    
    // Calculate days since post was published
    $post_date = get_post_time('U', true, $post_id);
    $days_passed = floor((time() - $post_date) / 86400);
    
    // Add views for each day (0-20 per day)
    $total_views = $base_views;
    for ($i = 0; $i < $days_passed; $i++) {
        srand($post_id + $i);
        $total_views += rand(0, 20);
    }
    
    return $total_views;
}

function inject_views_count() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all posts data for the current page
        const viewsData = {
            <?php
            // Get all post IDs on the current page
            global $wp_query;
            $post_ids = array();
            
            // Collect post IDs from main query
            if ($wp_query->have_posts()) {
                while ($wp_query->have_posts()) {
                    $wp_query->the_post();
                    $post_ids[] = get_the_ID();
                }
                wp_reset_postdata();
            }
            
            // Also get posts from any custom queries on the page
            $all_posts = get_posts(array(
                'post_type' => 'post',
                'posts_per_page' => -1,
                'fields' => 'ids'
            ));
            
            // Generate views for all possible posts
            $views_array = array();
            foreach ($all_posts as $post_id) {
                $views_array[] = '"' . $post_id . '": ' . get_fake_post_views($post_id);
            }
            echo implode(',', $views_array);
            ?>
        };
        
        // Function to inject views
        function injectPostViews() {
            // Find all possible post containers
            const postSelectors = [
                '.wd-post-entry',
                '.post-item',
                'article.post',
                '.blog-post',
                '.entry',
                '[class*="post-"][class*="-item"]',
                '[id*="post-"]'
            ];
            
            const posts = document.querySelectorAll(postSelectors.join(', '));
            
            posts.forEach(function(post) {
                // Skip if already has views
                if (post.querySelector('.post-views')) {
                    return;
                }
                
                // Try to get post ID from various sources
                let postId = null;
                
                // Method 1: From class name
                const classMatch = post.className.match(/post-(\d+)/);
                if (classMatch) {
                    postId = classMatch[1];
                }
                
                // Method 2: From ID attribute
                if (!postId && post.id) {
                    const idMatch = post.id.match(/post-(\d+)/);
                    if (idMatch) {
                        postId = idMatch[1];
                    }
                }
                
                // Method 3: From data attribute
                if (!postId) {
                    postId = post.getAttribute('data-post-id');
                }
                
                if (postId && viewsData[postId]) {
                    // Find date elements with more selectors
                    const dateSelectors = [
                        '.wd-post-date',
                        '.post-date',
                        '.entry-date',
                        'time',
                        '.date',
                        '.posted-on',
                        '[class*="date"]',
                        '.meta-date'
                    ];
                    
                    let dateElement = null;
                    for (const selector of dateSelectors) {
                        dateElement = post.querySelector(selector);
                        if (dateElement) break;
                    }
                    
                    if (dateElement) {
                        const viewsHtml = '<span class="post-views" style="margin-left: 15px; color: #666; font-size: 0.9em;">' + 
                                        viewsData[postId] + ' views</span>';
                        dateElement.insertAdjacentHTML('afterend', viewsHtml);
                    }
                }
            });
        }
        
        // Initial injection
        injectPostViews();
        
        // Re-run after AJAX loads (for infinite scroll, load more, etc.)
        // Observe for dynamic content
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.addedNodes.length) {
                    setTimeout(injectPostViews, 100);
                }
            });
        });
        
        // Start observing
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
        
        // Also listen for common AJAX events
        jQuery(document).on('post-load', injectPostViews);
        jQuery(document).ajaxComplete(injectPostViews);
    });
    </script>
    <?php
}
add_action('wp_footer', 'inject_views_count');
// Add custom body classes based on URL parameters
add_filter('body_class', 'add_url_parameter_body_class');
function add_url_parameter_body_class($classes) {
    // Check if '_for' parameter exists in URL
    if (isset($_GET['_for'])) {
        $for_value = sanitize_text_field($_GET['_for']);
        
        // Add class based on the parameter value
        if ($for_value === 'rent') {
            $classes[] = 'for-rent';
        } elseif ($for_value === 'buy') {
            $classes[] = 'for-buy';
        }
        
        // Also add a generic class with the value
        $classes[] = 'for-' . $for_value;
    }
    
    return $classes;
}
