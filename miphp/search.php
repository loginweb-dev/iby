<?php 

    require_once('../../../../wp-load.php');
    global $woocommerce, $product, $post;
    if ($_GET["get_products"]) {
        $args = array(
            'orderby' => 'date',
            'order' => 'DESC',
            'status' => 'publish',
            'post_type'   => array('product', 'product_variation'),
            's' => $_GET["get_products"],
        );
        $json = array();
        $loop = wc_get_products($args);
     
        
        foreach ($loop as $key) {
            $item = wc_get_product( $key->get_id() );
            if ($item->get_type() == "variable") {
                foreach ($key->get_available_variations() as $variation) {
                    $provar = wc_get_product($variation['variation_id']);
                    array_push($json, array(
                        "id" => $variation['variation_id'],
                        "name" => $provar->name,
                        "description" => $provar->description ? $provar->description : $provar->short_description, //description
                        "regular_price" => $provar->regular_price,
                        "bought_price" => $provar->get_meta('_wc_cog_cost'),
                        "sku" => $provar->sku, 
                        "image" => get_the_post_thumbnail_url($item->id), 
                        "stock_quantity" => $provar->stock_quantity ? $provar->stock_quantity : 0,
                        "lg_estante" => $provar->get_meta('lg_estante'),
                        "lg_bloque" => $provar->get_meta('lg_bloque'),
                        "lg_date" => $provar->get_meta('_expiration-date'), //lg_date
                        "brands" => json_encode(get_the_terms($item->id, 'product_brand') ? get_the_terms($item->id, 'product_brand') : get_the_terms($item->id, 'yith_product_brand')), //product_brand
                        "cats" => json_encode(get_the_terms($item->id, 'product_cat')),
                    ));
                }
                // echo json_encode($json);
            } else {
                # code...
                // print_r($item);
                $ed = get_post_meta($item->id,'_expiration-date',true);
    		    // echo ($ed ? get_date_from_gmt(gmdate('Y-m-d H:i:s',$ed),get_option('date_format').' '.get_option('time_format')) : __("Never",'post-expirator'));

                array_push($json, array(
                    "id" => $item->id,
                    "name" => $item->name,
                    "description" => $item->description ? $item->description : $item->short_description, //description
                    "regular_price" => $item->regular_price,
                    "bought_price" => $item->get_meta('_wc_cog_cost'),
                    "sku" => $item->sku, 
                    "image" => get_the_post_thumbnail_url($item->id) ? get_the_post_thumbnail_url($item->id) : 'resources/default_product.png', 
                    "stock_quantity" => $item->stock_quantity ? $item->stock_quantity : 0,
                    "lg_estante" => $item->get_meta('lg_estante'),
                    "lg_bloque" => $item->get_meta('lg_bloque'),
                    "lg_date" => get_date_from_gmt(gmdate('Y-m-d H:i:s',$ed),get_option('date_format').' '.get_option('time_format')), //lg_date
                    "brands" => json_encode(get_the_terms($item->id, 'yith_product_brand')), //product_brand
                    "cats" => json_encode(get_the_terms($item->id, 'product_cat')),
                ));
            }
        }
       echo json_encode($json);
    } else if($_GET["get_customer_id"]) {

         $args = array(
            'role' => 'customer',
            'order' => 'ASC',
            'search' => $_GET["get_customer_id"]
        );
        $query = new WP_User_Query($args);
        $users = (array) $query->results;
        $json = array();
        foreach ( $users as $user ) {
            $usermeta = get_user_meta($user->id);
            array_push($json, array(
                "id" => $user->id,
                "user_nicename" => $user->user_nicename,
                "user_email" => $user->user_email,
                "user_login" => $user->user_login,
                "billing_first_name" => $usermeta['billing_first_name'][0],
                "billing_last_name" => $usermeta['billing_last_name'][0],
                "billing_phone" => $usermeta['billing_phone'][0],
                "billing_postcode" => $usermeta['billing_postcode'][0]
            ));
 
        }
        echo json_encode($json);
        // $get_user = get_user_by( 'id', $_GET['get_customer_id']);
        // echo json_encode(array('message' => 'Cliente Obtenido Correctamente..', 'id' => $get_user->id, 'billing_first_name' => get_user_meta($get_user->id ,'billing_first_name', true),  $get_user->id, 'billing_first_name' => get_user_meta($get_user->id ,'billing_first_name', true)));
    } else if($_GET["get_customers"]) {

        $search_string = $_GET["get_customers"];

        $args  = array(
            'search' => "*{$search_string}*",
            'search_columns' => array(
            'user_login',
            'user_nicename',
            'user_email',
            'meta_query' => array(
                'relation' => 'OR',
                    array(
                        'key' => 'billing_first_name',
                        'value' => $search_string,
                        'compare' => 'LIKE'
                    ),
                    array(
                        'key' => 'billing_last_name',
                        'value' => $search_string,
                        'compare' => 'LIKE'
                    )
                ))
            );
       $query = new WP_User_Query($args);
       $users = (array) $query->results;
       $json = array();
       foreach ( $users as $user ) {
           $usermeta = get_user_meta($user->id);
           array_push($json, array(
               "id" => $user->id,
               "user_nicename" => $user->user_nicename,
               "user_email" => $user->user_email,
               "user_login" => $user->user_login,
               "billing_first_name" => $usermeta['billing_first_name'][0],
               "billing_last_name" => $usermeta['billing_last_name'][0],
               "billing_phone" => $usermeta['billing_phone'][0],
               "billing_postcode" => $usermeta['billing_postcode'][0]
           ));

       }
       echo json_encode($json);
    }
    

?>