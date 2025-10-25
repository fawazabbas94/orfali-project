<div class="person-meta-information">
    <?php
    $companies = get_field('companies');
    $positions = get_field('positions');
    $languages = get_field('languages');
    $language_display = get_field('language_display', 'option');
    if ($positions) : ?>
        <div class="positions person-list">
            <h3><?php echo __('Positions:', 'REM') ?></h3>
            <div class="positions-list sub-list">
                <?php
                $positions_list = [];
                foreach ($positions as $position) {
                    $positions_list[] = esc_html($position->name);
                ?>
                <?php
                } ?>
                <h4><?php echo implode(', ', $positions_list); ?></h4>
            </div>
        </div>
    <?php
    endif;
    if ($companies) : ?>
        <div class="companies person-list">
            <h3><?php echo __('Works at:', 'REM') ?></h3>
            <div class="companies-list sub-list">
                <?php
                $companies_array = [];
                foreach ($companies as $company) {
                    if ($company) {
                        $companies_array[] = [
                            'name' => get_the_title($company->ID),
                            'link' => get_permalink($company->ID)
                        ];
                    }
                }
                $html_strings = [];
                foreach ($companies_array as $company) {
                    $html_strings[] = "<a href='{$company['link']}' class='company-name'>{$company['name']}</a>";
                }
                $result = implode(', ', $html_strings);
                echo $result;
                ?>
            </div>
        </div>
    <?php
    endif;
    if ($languages) { ?>
        <div class="languages person-list">
            <h3><?php echo __('Speaks:', 'REM') ?></h3>
            <div class="languages-list sub-list">
                <p>
                    <?php
                    $language_list = [];
                    foreach ($languages as $language) {
                        $native_name = get_field('native_name', $language);
                        if ($language_display === 'both') {
                            $language_list[] = esc_html($language->name) . ' (' . esc_html($native_name) . ')';
                        } elseif ($language_display === 'active') {
                            $language_list[] = esc_html($language->name);
                        } elseif ($language_display === 'native') {
                            $language_list[] = esc_html($native_name);
                        }
                    }
                    echo implode(', ', $language_list);
                    ?>
                </p>
            </div>
        </div>
    <?php
    }
    ?>
</div>