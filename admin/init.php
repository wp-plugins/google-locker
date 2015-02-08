<?php
/*-----------------------------------------------------------------------------------*/
/*	Init settings - Options variable & functions
/*-----------------------------------------------------------------------------------*/

// General options
function gl_get_general_settings_key( ) {
    return 'g_locker_general_settings';
}

function gl_get_general_settings_values( ) {
    $general_settings = (array) get_option( gl_get_general_settings_key() );
    
    // Merge with general defaults
    $general_settings = array_merge( gl_general_default_settings(), $general_settings );
    
    return $general_settings;
}

// Social options
function gl_get_social_lock_settings_key( ) {
    return 'g_locker_social_lock_settings';
}

function gl_get_social_lock_setting_values( ) {
    $social_lock_settings = (array) get_option( gl_get_social_lock_settings_key() );
    
    // Merge with social defaults
    $social_lock_settings = array_merge( gl_social_lock_default_settings(), $social_lock_settings );
    
    return $social_lock_settings;
}

// Content options
function gl_get_content_lock_settings_key( ) {
    return 'g_locker_content_lock_settings';
}

function gl_get_content_lock_setting_values( ) {
    $content_lock_settings = (array) get_option( gl_get_content_lock_settings_key() );
    
    // Merge with content defaults
    $content_lock_settings = array_merge( gl_content_lock_default_settings(), $content_lock_settings );
    
    return $content_lock_settings;
}

function gl_get_howtouse_settings_key( ) {
    return 'g_locker_howtouse_settings';
}

function gl_get_plugin_options_key( ) {
    return 'g_locker';
}

// Function get all settings tabs
function gl_get_plugin_settings_tabs( ) {
    $plugin_settings_tabs[ gl_get_general_settings_key() ]      = 'General';
    $plugin_settings_tabs[ gl_get_social_lock_settings_key() ]  = 'Social Locker';
    $plugin_settings_tabs[ gl_get_content_lock_settings_key() ] = 'Content Locker';
    $plugin_settings_tabs[ gl_get_howtouse_settings_key() ]   	= 'How to use?';
    
    return $plugin_settings_tabs;
}

// General default options value
function gl_general_default_settings( ) {
    $general_default_settings = array(
        'google_active' => '',
        'google_share' => '',
        'google_url' => 'http://www.wptp.net',
        'youtube_active' => '',
        'youtube_channel' => 'GoogleDevelopers',
        'language' => 'en_US',
        'short_language' => 'en',
        'cookie_days' => '365'
    );
    
    return $general_default_settings;
}

// Social default options value
function gl_social_lock_default_settings( ) {
    $social_lock_default_settings = array(
        'sl_title' => 'This content is locked!',
        'sl_message' => 'This is Google Locker. Please click on one of the buttons.',
        'sl_style' => 'starter',
        'sl_title_color' => '#000000',
        'sl_message_color' => '#000000',
        'sl_bg_color' => '#22d8d2',
        'sl_shadow_color' => '#22d8d2',
        'sl_layout' => 'count',
        'sl_btn_effect' => 'fade'
    );
    
    return $social_lock_default_settings;
}

// Content default options value
function gl_content_lock_default_settings( ) {
    $content_lock_default_settings = array(
        'cl_title' => 'This content is locked!',
        'cl_message' => 'This is Google Locker. Please click on one of the buttons.',
        'cl_style' => 'starter',
        'cl_title_color' => '#000000',
        'cl_message_color' => '#000000',
        'cl_bg_color' => '#22d8d2',
        'cl_shadow_color' => '#22d8d2',
        'cl_layout' => 'count',
        'cl_btn_effect' => 'fade'
    );
    
    return $content_lock_default_settings;
}

function gl_init_settings( ) {
    // Load jQuery First
    wp_enqueue_script( 'jquery' );
    
    // CSS
    wp_deregister_style( 'gl_css' );
    wp_register_style( 'gl_css', G_LOCKER_PLUGIN_URL . '/assets/css/gl.css' );
    wp_enqueue_style( 'gl_css' );
    
    // Show color picker for some color option. Example: Title Color, Shadow Color
    if ( is_admin() ) {
		// Jquery UI
		wp_enqueue_script( 'jquery-ui', 'https://code.jquery.com/jquery-1.10.2.js');
		wp_enqueue_script( 'jquery-ui', 'https://code.jquery.com/ui/1.11.2/jquery-ui.js');
		wp_enqueue_style( 'jquery-ui', 'https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css' );
		
		// Color Picker for color options
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'gl-custom-script-handle', G_LOCKER_PLUGIN_URL . '/assets/js/gl-wp-color-picker.js', array(
             'wp-color-picker' 
        ), false, true );
    }
}

add_action( 'init', 'gl_init_settings' );

/*-----------------------------------------------------------------------------------*/
/*	Short code
/*-----------------------------------------------------------------------------------*/

require_once( G_LOCKER_PLUGIN_DIR . '/admin/shortcode.php' );

/*-----------------------------------------------------------------------------------*/
/*	Pages setting
/*-----------------------------------------------------------------------------------*/

require_once( G_LOCKER_PLUGIN_DIR . '/admin/pages.php' );

/**
 * Add scripts for button
 */
function gl_admin_assets( $hook ) {

    global $wp_version;
    
    if ( version_compare( $wp_version, '3.9', '>=' ) ) {
        if ( in_array( $hook, array('edit.php', 'post.php', 'post-new.php') ) ) {
            ?>
            <style>
                i.g-locker-shortcode-icon {
                    background: url("<?php echo G_LOCKER_PLUGIN_URL ?>/assets/admin/img/g-locker-shortcode-icon.png");
                }
            </style>
            <?php
        }
    }
}

add_action( 'admin_enqueue_scripts', 'gl_admin_assets' );

/**
 * Add Social Button
 */
add_filter( 'mce_external_plugins', 'gl_add_plugin' );
add_filter( 'mce_buttons', 'gl_register_button' );

function gl_register_button( $buttons ) {
    
    if ( !current_user_can( 'edit_posts' ) )
        return $buttons;
    array_push( $buttons, "g_locker" );
    return $buttons;
}

function gl_add_plugin( $plugin_array ) {
    
    if ( !current_user_can( 'edit_posts' ) )
        return $plugin_array;
    global $wp_version;
    
    if ( version_compare( $wp_version, '3.9', '<' ) ) {
        $plugin_array[ 'g_locker' ] = G_LOCKER_PLUGIN_URL . '/assets/admin/js/g_locker.tinymce3.js';
    } else {
        $plugin_array[ 'g_locker' ] = G_LOCKER_PLUGIN_URL . '/assets/admin/js/g_locker.tinymce4.js';
    }
    
    return $plugin_array;
}
?>