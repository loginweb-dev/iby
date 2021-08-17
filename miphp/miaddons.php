<?php 
    require_once('../../../../wp-load.php');
    // include_once('../../woocommerce-product-addons/includes/class-product-addon-display.php' );
    // // $GLOBALS['Product_Addon_Display'] = new Product_Addon_Display();
    
    // $addons     = array();
	// $raw_addons = array();
    // $product_addons = array_filter( (array) get_post_meta( 366, '_product_addons', true ) );

    // $raw_addons[10]['product'] = apply_filters( 'get_product_addons_fields', $product_addons, 366 );
    // $args = array(
    //     'posts_per_page'   => -1,
    //     'orderby'          => 'meta_value',
    //     'order'            => 'ASC',
    //     'meta_key'         => '_priority',
    //     'post_type'        => 'global_product_addon',
    //     'post_status'      => 'publish',
    //     'suppress_filters' => true,
    //     'meta_query' => array(
    //         array(
    //             'key'   => '_all_products',
    //             'value' => '1',
    //         ),
    //     ),
    // );

    // $global_addons = get_posts( $args );

    // if ( $global_addons ) {
    //     foreach ( $global_addons as $global_addon ) {
    //         $priority                                     = get_post_meta( $global_addon->ID, '_priority', true );
    //         $raw_addons[ $priority ][ $global_addon->ID ] = apply_filters( 'get_product_addons_fields', array_filter( (array) get_post_meta( $global_addon->ID, '_product_addons', true ) ), $global_addon->ID );
    //     }
    // }

    // ksort( $raw_addons );
    // // print_r($raw_addons);
    // foreach ( $raw_addons as $addon_group ) {
    //     if ( $addon_group ) {
    //         foreach ( $addon_group as $addon ) {
                
    //             $addons = array_merge( $addons, $addon );
    //         }
    //     }
    // }

    // $max_addon_name_length = 0;
    // $addon_field_counter = 0;

    // foreach ( $addons as $addon_key => $addon ) {
    //     if ( empty( $addon['name'] ) ) {
    //         unset( $addons[ $addon_key ] );
    //         continue;
    //     }
    //     if ( empty( $addons[ $addon_key ]['field-name'] ) ) {
    //         $addon_name = substr( $addon['name'], 0, $max_addon_name_length );
    //         $addons[ $addon_key ]['field-name'] = sanitize_title( $addon_name . '-' . $addon_field_counter );
    //         // echo $addon_name;
    //         $addon_field_counter++;
    //     }
    //     // $addon_name = substr( $addon['name'], 0, 0 );
    //     echo $addons[ $addon_key ];
    // }
    // return apply_filters( 'get_product_addons', $addons );
    // include_once( dirname( __FILE__ ) . '/class-product-addon-display.php' );
    // $product = get_post( 366 );
	// $product_addons = array_filter( (array) get_post_meta( $product->ID, '_product_addons', true ) );
    // echo $product_addons;
    // $product_addons = unserialize(get_post_meta( 366, '_product_addons', true ));
    // $extra = get_post( 366 );
    // $product_addons = array_filter( (array) $product->get_meta( '_product_addons' ) );
    // $product_addons = array_filter( (array) get_post_meta( $extra->ID, '_product_addons', true ) );
    // var_dump($product_addons);

    // foreach ( $product_addons as $addon ) {
        // echo $addon['name'];
        // echo $addon['type'];
        // echo $addon_key;
        // echo $addon;
        // echo $addon['field-name'];
    // }   
    // $product = wc_get_product( 366 );
    // print_r($product);

    // $grabMeta = get_post_meta( 366, '_product_addons', true );
    // // var_dump($grabMeta);
    // $myvalues = unserialize( $grabMeta[0] );
    // print_r($grabMeta[0]);
    // // echo $myvalues['label'][0];
    // foreach ( $grabMeta[0] as $myvalue ) { 
    //     echo $myvalue[0][0]; 
    // }

    // $product_data['meta'] = array();
    // $product_data = maybe_unserialize(get_post_meta('366', '_product_addons' ));
    // print_r($product_data);


    // collect meta to object
    // $meta = new stdClass;
    // foreach( (array) get_post_meta( '366', '_product_addons' ) as $k => $v )
    // {
    //     $meta->$k = $v[0];

    // // Now, let's say the post has metafield 'book'
    // // Get it like so:
    // print_r($meta);

    // $tb_meta = get_post_meta(366, '_product_addons', true);
    // $tb_meta_unserialized = maybe_unserialize( base64_decode($tb_meta) );
    // var_dump($tb_meta_unserialized);

    

    // $metas = get_post_meta(366, '_product_addons', TRUE);
    // var_dump($metas);
    // foreach ( $metas as $metakey ){
    //     echo $metakey[0]['label'];
    //     // Similarly for all the fields you want to print
    // }

    // $myvals = get_post_meta( 366);
    // foreach($myvals as $key=>$val){
    //     foreach($val as $vals){
    //         // if ($key=='Youtube'){
    //         echo $vals.' - ' ;
    //         // echo 'Youtube';
    //         // }
    //     }
    // }

      

        // $myvals = get_post_meta(366);

        // foreach($myvals as $key=>$val)
        // {
        //     // echo $key['_product_addons'] . ' : ' . $val[0]. '<br/>';
        //     echo $val[0];
        // }

        // $ProductMeta = get_post_meta(366);
        // $addons = $ProductMeta['_product_addons'];
        // $addon = unserialize($addons);
        // var_dump($addon);
        // if($addon['type'] == "checkbox"){
        //     echo 'type';
        // }
        // foreach ($addons as $key => $value) {
        //     echo $value;
        // }
        // global $woocommerce;
        // global $product;
        // global $wpdb;
        //Modification : get product addon attributes
        
        $results = $wpdb->get_row('SELECT meta_value FROM wp_postmeta WHERE post_id = 366 AND  meta_key = "_product_addons"');
        // $results = get_post_meta(366, '_product_addons');
        $results = unserialize($results->meta_value);
        // var_dump($results);
        foreach ( $results  as $j => $fieldoption ) {
        
            if($fieldoption['type'] == "checkbox"){
                // echo 'type';
                
                // $selected = isset( $_POST[ 'addon-' . sanitize_title( $addon['field-name'] ) ] ) ? $_POST[ 'addon-' . sanitize_title( $addon['field-name'] ) ] : array();
                // if ( ! is_array( $selected ) ) {
                //     $selected = array( $selected );
                // }
            
                // $current_value = ( in_array( sanitize_title( $option['label'] ), $selected ) ) ? 1 : 0;
                
                // var_dump($fieldoption["description"]);
                
                
            
                foreach ( $fieldoption['options'] as $i => $option ) {
                    // var_dump($option);
                    echo $option['label'].' - '.$option['price'].'<br >' ;
                    
                    // echo sanitize_title( $addon['field-name']);
                    //$price = $option['price'] > 0 ? '(' . woocommerce_price( get_product_addon_price_for_display( $option['price'] ) ) . ')' : '';
               
                }
            }
        }
        
?>