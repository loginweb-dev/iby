<?php
/**
* Plugin Name: iBy - Modulo TPV Inteligente
* Plugin URI: https://loginweb.dev/iby/
* Description: Plugins Diseñado y Desarrollado por Loginweb, para Gestionar la Facturacion Computarizada, Flujo de Caja, Compras.
* Version: 1.0
* Author: Ing. Percy Alvarez Cruz
* Author URI: https://loginweb.dev/profile
**/
// add meta produsts-------------------------------------------------------------
add_action( 'woocommerce_product_options_stock_status', 'loginweb_product_options');
function loginweb_product_options(){
	global $post;

    echo '</div><div class="options_group">'; // New separated section
	woocommerce_wp_text_input( array(
		'id'      => 'lg_estante',
		'value'   => get_post_meta( get_the_ID(), 'lg_estante', true ),
		'label'   => 'Estante',
		'type'   => 'text'
	) );
	
	woocommerce_wp_text_input( array(
		'id'      => 'lg_bloque',
		'value'   => get_post_meta( get_the_ID(), 'lg_bloque', true ),
		'label'   => 'Bloque',
		'type'   => 'text'
	) );
 
}
add_action( 'woocommerce_process_product_meta', 'loginweb_save_fields', 10, 2 );
function loginweb_save_fields( $id, $post ){
 
	update_post_meta( $id, 'lg_estante', $_POST['lg_estante'] );
	update_post_meta( $id, 'lg_bloque', $_POST['lg_bloque'] );
	// update_post_meta( $id, 'lg_date', $_POST['lg_date'] );

}
// add actions list orders -----------------------------------------------
// Add your custom order status action button (for orders with "processing" status)
add_filter( 'woocommerce_admin_order_actions', 'add_custom_order_status_actions_button', 100, 2 );
function add_custom_order_status_actions_button( $actions, $order ) {
  
    // if ( $order->has_status( array( 'processing' ) ) ) {
	if($order->get_meta('lw_pos_type_order') == 'factura'){
        // The key slug defined for your action button
        $action_slug = 'parcial';

        // Set the action button
        $actions[$action_slug] = array(
            'url'       => WP_PLUGIN_URL.'/iby/miphp/print_factura.php?cod_order='.$order->get_id(),
            'name'      => __( 'Reimprime Factura', 'woocommerce' ),
            'action'    => $action_slug,
        );
    }
    return $actions;
}

// Set Here the WooCommerce icon for your action button
// add_action( 'admin_head', 'add_custom_order_status_actions_button_css' );
// function add_custom_order_status_actions_button_css() {
//     $action_slug = "parcial"; // The key slug defined for your action button

//     echo '<style>.wc-action-button-'.$action_slug.'::after { font-family: woocommerce !important; content: "\e002" !important; }</style>';
// }
// //-------------------------OPTIONS RESTAURANT tipo de venta--------------------
// add_filter( 'manage_edit-shop_order_columns', 'custom_shop_order_column', 20 );
// function custom_shop_order_column($columns)
// {
//     $reordered_columns = array();
//     foreach( $columns as $key => $column){
//         $reordered_columns[$key] = $column;
//         if( $key ==  'order_status' ){
//             $reordered_columns['my-column1'] = __( 'Tipo','theme_domain');
//         }
//     }
//     return $reordered_columns;
// }

// add_action( 'manage_shop_order_posts_custom_column' , 'custom_orders_list_column_content', 20, 2 );
// function custom_orders_list_column_content( $column, $post_id )
// {
//     switch ( $column )
//     {
//         case 'my-column1' :
//             $my_var_one = get_post_meta( $post_id, 'lw_or', true );
//             if(!empty($my_var_one))
//                 echo $my_var_one;
//             else
//                 echo '<small>(<em>no value</em>)</small>';
//             break;
//     }
// }

// insert post setting ------------------------------------------------------
function lw_create_setting() {
	$setting = array(
		'post_title'    => 'Post setting TPV',
		'post_status'   => 'publish',
		'post_type'   => 'pos_lw_setting',
		'meta_input' => array(
			'lw_image' => null,
			'lw_ceo' => null,
			'lw_direction' => null,
			'lw_movil' => null,
			'lw_city' => null,
			'lw_activity' => null,
			'lw_name_business' => null,
			'lw_nit' => null,
			'lw_legend' => null,
		)
	);
	wp_insert_post( $setting );
}
//. create table ----------------------------------------------------------------
// function to create the DB / Options / Defaults					
// function ss_options_install() {

//     global $wpdb;

//     $table_name = $wpdb->prefix . "lw_dosification";
//     $charset_collate = $wpdb->get_charset_collate();
//     $sql = "CREATE TABLE $table_name (
//             `id` MEDIUMINT NOT NULL AUTO_INCREMENT,
//             `autoritation` varchar(50) CHARACTER SET utf8 NOT NULL,
//             `date_limit` varchar(50) CHARACTER SET utf8 NOT NULL,
//             `lwkey` varchar(255) CHARACTER SET utf8 NOT NULL,
//             PRIMARY KEY (`id`)
//           ) $charset_collate; ";

//     require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
//     dbDelta($sql);
// }

// // run the install scripts upon plugin activation
register_activation_hook(__FILE__, 'lw_create_setting');


//menu TPV items --------------------------------------------------------------------
add_action('admin_menu','lw_add_menu');
function lw_add_menu() {
	
	//MENU TPV
	add_menu_page('Punto de Venta', //page title
        'Punto de Venta', //menu title
        'manage_options', //capabilities
        'terminal-punto-venta', //menu slug
        'lw_boxs_list', //function
        'dashicons-align-full-width'
	);
	
		// MENU CAJAS ---------------------------------------------
		add_submenu_page('terminal-punto-venta', //parent slug
			'Cajas', //page title
			'Cajas', //menu title
			'manage_options', //capability
			'cajas', //menu slug
			'lw_boxs_list' //function
		);
		// MENU Tiendas ---------------------------------------------
			add_submenu_page('terminal-punto-venta', //parent slug
			'Tiendas', //page title
			'Tiendas', //menu title
			'manage_options', //capability
			'tiendas', //menu slug
			'lw_outlet_list' //function
		);
		add_submenu_page('null', //parent slug
			'Nueva Caja', //page title
			'Nueva Caja', //menu title
			'manage_options', //capability
			'boxs-create', //menu slug
			'lw_boxs_create' //function
		);
		add_submenu_page('null', //parent slug
			'Editar Caja', //page title
			'Editar Caja', //menu title
			'manage_options', //capability
			'boxs-edit', //menu slug
			'lw_boxs_edit' //function
		);

	//MENU dosifications ---------------------------------------------------------------
	add_submenu_page('terminal-punto-venta', //parent slug
	'Dosificaciones', //page title
	'Dosificaciones', //menu title
	'manage_options', //capability
	'dosifications', //menu slug
	'lw_dosifications_list'); //function

		add_submenu_page('null', //parent slug
			'Nueva Dosification', //page title
			'Nueva Dosification', //menu title
			'manage_options', //capability
			'dosification-create', //menu slug
			'lw_dosification_create' //function
		);
		add_submenu_page('null', //parent slug
			'Editar Dosification', //page title
			'Editar Dosification', //menu title
			'manage_options', //capability
			'dosification-edit', //menu slug
			'lw_dosification_edit' //function
		);

    //MENU Compras ---------------------------------------------------------------
	add_submenu_page('terminal-punto-venta', //parent slug
	'Compras', //page title
	'Compras', //menu title
	'manage_options', //capability
	'compras', //menu slug
	'lw_compras_list'); //function

     //MENU Proformas ---------------------------------------------------------------
	add_submenu_page('terminal-punto-venta', //parent slug
	'Proformas', //page title
	'Proformas', //menu title
	'manage_options', //capability
	'proformas', //menu slug
	'lw_proformas_list'); //function

    //MENU Settings ---------------------------------------------------------------
	add_submenu_page('terminal-punto-venta', //parent slug
	'Configuracion', //page title
	'Configuracion', //menu title
	'manage_options', //capability
	'setting', //menu slug
	'lw_setting'); //function
}

//menu TPV items --------------------------------------------------------------------
add_action('admin_menu','lw_add_menu_conta');
function lw_add_menu_conta() {
	
	//MENU TPV
	add_menu_page('Contabilidad', //page title
        'Contabilidad', //menu title
        'manage_options', //capabilities
        'contabilidad', //menu slug
        //'lw_bg', //function
        'dashicons-dashboard',
	);
}

// Cargando files php -----------------------------------------------------
define('ROOTDIR', plugin_dir_path(__FILE__));
require_once(ROOTDIR . 'crud/welcome.php');

require_once(ROOTDIR . 'crud/boxs-list.php');
require_once(ROOTDIR . 'crud/boxs-create.php');
require_once(ROOTDIR . 'crud/boxs-edit.php');

require_once(ROOTDIR . 'crud/outlet-list.php');

require_once(ROOTDIR . 'crud/dosifications-list.php');
require_once(ROOTDIR . 'crud/dosifications-create.php');
require_once(ROOTDIR . 'crud/dosifications-edit.php');

require_once(ROOTDIR . 'crud/compras-list.php');

require_once(ROOTDIR . 'crud/proformas-list.php');

require_once(ROOTDIR . 'crud/setting.php');
?>

