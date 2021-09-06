<?php 
    require_once('../../../../wp-load.php');
    // echo $_GET["cupon_code"];
    $args=array(
        'title' => $_GET["cupon_code"] ,
        'post_type' => 'shop_coupon',
        'post_status' => 'publish'
        );
    $post = get_posts($args);
    echo json_encode(array("message" => "Producto Agredado Correctamente.", "cupon_id"=> $post[0]->ID));  
    // print_r($post);
    // echo get_post_meta($post[0]->ID, 'discount_type', true) ;
    // echo get_post_meta($post[0]->ID, 'coupon_amount', true) ;