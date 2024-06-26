<?php
// Add menu in admin
function page1_notify_menu() {
    add_options_page(
        'PAGE1 Notify Settings',
        'PAGE1 Notify',
        'manage_options',
        'page1-notify',
        'page1_notify_options_page'
    );
}
add_action('admin_menu', 'page1_notify_menu');

// Register settings
function page1_notify_settings_init() {
    register_setting('page1_notify', 'page1_notify_options', 'page1_notify_validate_options');

    add_settings_section(
        'page1_notify_section',
        __('Notification Settings', 'page1-notify'),
        'page1_notify_section_callback',
        'page1_notify'
    );

    add_settings_field(
        'page1_notify_title',
        __('Title', 'page1-notify'),
        'page1_notify_title_render',
        'page1_notify',
        'page1_notify_section'
    );

    add_settings_field(
        'page1_notify_description',
        __('Description', 'page1-notify'),
        'page1_notify_description_render',
        'page1_notify',
        'page1_notify_section'
    );

    add_settings_field(
        'page1_notify_url',
        __('Notification URL', 'page1-notify'),
        'page1_notify_url_render',
        'page1_notify',
        'page1_notify_section'
    );

    add_settings_field(
        'page1_notify_time',
        __('Notification Time (seconds)', 'page1-notify'),
        'page1_notify_time_render',
        'page1_notify',
        'page1_notify_section'
    );

    add_settings_field(
        'page1_notify_scroll',
        __('Notification Scroll (%)', 'page1-notify'),
        'page1_notify_scroll_render',
        'page1_notify',
        'page1_notify_section'
    );

    add_settings_field(
        'page1_notify_max_displays',
        __('Max Displays Per Session', 'page1-notify'),
        'page1_notify_max_displays_render',
        'page1_notify',
        'page1_notify_section'
    );
}
add_action('admin_init', 'page1_notify_settings_init');

function page1_notify_section_callback() {
    echo esc_html__('Configure the notification settings below.', 'page1-notify');
}

function page1_notify_title_render() {
    $options = get_option('page1_notify_options');
    ?>
    <input type='text' name='page1_notify_options[title]' value='<?php echo esc_attr($options['title']); ?>'>
    <?php
}

function page1_notify_description_render() {
    $options = get_option('page1_notify_options');
    ?>
    <textarea name='page1_notify_options[description]'><?php echo esc_textarea($options['description']); ?></textarea>
    <?php
}

function page1_notify_url_render() {
    $options = get_option('page1_notify_options');
    ?>
    <input type='url' name='page1_notify_options[url]' value='<?php echo esc_url($options['url']); ?>'>
    <?php
}

function page1_notify_time_render() {
    $options = get_option('page1_notify_options');
    ?>
    <input type='number' name='page1_notify_options[time]' value='<?php echo esc_attr($options['time']); ?>' min='0'>
    <p class="description"><?php echo esc_html__('Chỉ được lựa chọn 1 trong 2 hình thức', 'page1-notify'); ?></p>
    <?php
}

function page1_notify_scroll_render() {
    $options = get_option('page1_notify_options');
    ?>
    <input type='number' name='page1_notify_options[scroll]' value='<?php echo esc_attr($options['scroll']); ?>' min='0' max='100'>
    <p class="description"><?php echo esc_html__('Chỉ được lựa chọn 1 trong 2 hình thức', 'page1-notify'); ?></p>
    <?php
}

function page1_notify_max_displays_render() {
    $options = get_option('page1_notify_options');
    ?>
    <input type='number' name='page1_notify_options[max_displays]' value='<?php echo esc_attr(isset($options['max_displays']) ? $options['max_displays'] : 1); ?>' min='1'>
    <?php
}

function page1_notify_validate_options($input) {
    $options = get_option('page1_notify_options');
    $errors = [];

    if (!empty($input['time']) && !empty($input['scroll'])) {
        add_settings_error('page1_notify_options', 'both_fields_error', 'Chỉ được lựa chọn 1 trong 2 hình thức', 'error');
        return $options; // Return the previous options without updating
    }

    if (isset($input['title'])) {
        $options['title'] = sanitize_text_field($input['title']);
    }
    if (isset($input['description'])) {
        $options['description'] = sanitize_textarea_field($input['description']);
    }
    if (isset($input['url'])) {
        $options['url'] = esc_url_raw($input['url']);
    }
    if (isset($input['time'])) {
        $options['time'] = intval($input['time']);
    } else {
        $options['time'] = '';
    }
    if (isset($input['scroll'])) {
        $options['scroll'] = intval($input['scroll']);
    } else {
        $options['scroll'] = '';
    }
    if (isset($input['max_displays'])) {
        $options['max_displays'] = intval($input['max_displays']);
    } else {
        $options['max_displays'] = 1;
    }

    return $options;
}

function page1_notify_options_page() {
    ?>
    <form action='options.php' method='post'>
        <h2><?php echo esc_html__('PAGE1 Notify Settings', 'page1-notify'); ?></h2>
        <?php
        settings_fields('page1_notify');
        do_settings_sections('page1_notify');
        submit_button();
        ?>
    </form>
    <?php
}
