<?php

    add_action('admin_menu','lw_menu_boxs');
    function lw_menu_boxs() {
        add_menu_page('POS', //page title
        'POS', //menu title
        'shop_manager', //capabilities
        'lw_boxs_list', //menu slug
        // 'sinetiks_schools_list', //function
        // 'dashicons-align-full-width'
        );
    }

    define('ROOTDIR', plugin_dir_path(__FILE__));
    // require_once(ROOTDIR . 'list.php');