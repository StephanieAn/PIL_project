<?
//lier les pages css et php ensemble
function register_assets()
{
    wp_register_style('style', get_stylesheet_uri('style.css'));
    wp_enqueue_style('fonts', get_template_directory_uri() . '/resources/fonts/II Vorkurs/stylesheet.css', NULL, microtime(), 'all');
    wp_enqueue_style('style');

    // wp_register_script('LogoAnim', './JS/script.js');
    // wp_enqueue_script('LogoAnim');

    wp_enqueue_script('video-hover', get_theme_file_uri('./js/video-hover.js'), null, microtime(), true);
    wp_enqueue_script('moving-text', get_theme_file_uri('./js/moving-text.js'), null, microtime(), true);
    wp_enqueue_script("test",get_theme_file_uri('./js/accordeons-espace.js'),null,microtime(),true);
    wp_enqueue_script("script", get_theme_file_uri('./js/secteur_accordion.js'), null, microtime(),true);
    wp_enqueue_style('fontawesome','https://use.fontawesome.com/releases/v5.15.4/css/all.css');
    wp_enqueue_script("script", get_theme_file_uri('./js/cookie.js'), null, microtime(), true);
}

//appeller la liaison entre css et php
add_action('wp_enqueue_scripts', 'register_assets');

function wpc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}

add_filter('upload_mimes', 'wpc_mime_types');
//appeller la liaison entre css et php
add_action('wp_enqueue_scripts', 'register_assets');


register_nav_menus(array(
    'main' => 'Menu_header',
    'aside' => 'Categories',
    'contact' => 'Contact'
));

function add_file_types_to_uploads($file_types)
{
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge($file_types, $new_filetypes);
    return $file_types;
}
add_filter('upload_mimes', 'add_file_types_to_uploads');
