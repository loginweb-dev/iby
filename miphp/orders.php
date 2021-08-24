<?php 
    require_once('../../../../wp-load.php');
    global $woocommerce;
    $current_user = wp_get_current_user();
    require_once('code-control/CodigoControlV7.php');
    require_once 'class.Cart.php';
    $cart = new Cart([
        'cartMaxItem'      => 0,
        'itemMaxQuantity'  => 99,
        'useCookie'        => false,
    ]);

    $datos_factura = get_posts( array('post_status' => 'publish', 'post_type' => 'pos_lw_setting') );
    $dosification = get_posts( array('post_status' => 'publish', 'post_type' => 'pos_dosification') );
 
    // get user -------------------------------
    $get_user = get_user_by( 'id', $_GET['cod_customer']);
    
    // creando nuevo pedido con cliente -----------------------------
    $order = wc_create_order(array('customer_id'=>$_GET["cod_customer"] ));

    //Agregando productos al pedido--------------------------
    $allItems = $cart->getItems();
    
    $item_id = null;
    $product = null;
    foreach ($allItems as $items) {
        foreach ($items as $item) {
            if ($item['attributes']['sku'] == 'extra') {
                $carts = $order->get_items();
                foreach ( $carts as $value ) {
                    // echo $item->get_name();
                    $product = wc_get_product($value->get_product_id());
                    // echo $item->get_id();
                    $item_id = $value->get_id();
                }
                wc_update_order_item_meta($item_id, '_line_subtotal' , $cart->getAttributeTotal('price'), false);
                wc_update_order_item_meta($item_id, '_line_total' , $cart->getAttributeTotal('price'), false);
                wc_update_order_item_meta($item_id, '_line_subtotal_tax' , $cart->getAttributeTotal('price'), false);
                wc_update_order_item_meta($item_id, '_line_tax' , $cart->getAttributeTotal('price'), false);
                wc_update_order_item_meta($item_id, 'Extras (Bs.'.$item['attributes']['price'].')', $item['attributes']['name'], false);
            } else {
                $order->add_product( get_product($item['id']), $item['quantity']);
            }
        }
    }
    $num_tickets = count(wc_get_orders( array('meta_query' => array('wc_pos_register_id' => $_GET["cod_box"] ) ) ) );
    //Agregando facturacion----------------------------------------------------
    // $order->set_address( $address, 'billing' );
    // $order->set_address( $address, 'shipping' );
    $order->calculate_totals();
    $order->update_status("wc-completed");
    update_post_meta($order->id, 'lw_pos_type_order', $_GET["tipo_venta"] );
    update_post_meta($order->id, 'lw_pos_tickes', $num_tickets);
    update_post_meta($order->id, 'lw_or', $_GET["option_restaurant"]);
    update_post_meta($order->id, 'wc_pos_order_type', 'POS');
    update_post_meta($order->id, 'wc_pos_register_id', $_GET["cod_box"]);
    update_post_meta($order->id, 'wc_pos_served_by_name', $current_user->user_login);
    update_post_meta($order->id, 'wc_pos_amount_change', $_GET["cambio"] );
    update_post_meta($order->id, 'wc_pos_amount_pay', $_GET["entregado"] );
    update_post_meta($order->id, '_payment_method', 'pos_cash');
    update_post_meta($order->id, '_payment_method_title', $_GET["type_payment"] );
    update_post_meta($order->id, '_order_total', $cart->getAttributeTotal('price') );

    
    
    
    

    if ($_GET["tipo_venta"] == "factura") {
        // solo para factura --------------------------------------------------------
        $num_factura = count(wc_get_orders( array('meta_query' => array('lw_dosification_key' => $key)) ));
        update_post_meta($order->id, 'lw_dosification_key', get_post_meta($dosification[0]->ID, 'lw_key', true));
        update_post_meta($order->id, 'lw_dosification_autoritation', get_post_meta($dosification[0]->ID, 'lw_autorization', true));
        update_post_meta($order->id, 'lw_dosification_date_limit', get_post_meta($dosification[0]->ID, 'lw_date', true));
        update_post_meta($order->id, 'lw_number_factura', $num_factura);
        update_post_meta($order->id, 'lw_nit_busines', get_post_meta($datos_factura[0]->ID, 'lw_nit', true));
        update_post_meta($order->id, 'lw_nit_customer', get_user_meta($get_user->id, 'billing_postcode', true));
        update_post_meta($order->id, 'lw_name_customer', get_user_meta($get_user->id ,'billing_first_name', true).' '.get_user_meta($get_user->id, 'billing_last_name', true));
            // Data for QR-------------------------
            $code_control = CodigoControlV7::generar(get_post_meta($dosification[0]->ID, 'lw_key', true), $num_factura, get_user_meta($get_user->id, 'billing_postcode', true), get_post_meta($dosification[0]->ID, 'lw_date', true), $order->get_total(), get_post_meta($dosification[0]->ID, 'lw_key', true));
            update_post_meta($order->id, 'lw_codigo_control', $code_control);
            $newcodeqr = get_post_meta($datos_factura[0]->ID, 'lw_nit', true).'|'.$num_factura.'|'.get_post_meta($dosification[0]->ID, 'lw_autorization', true).'|'.$order->get_total().'|'.get_post_meta($dosification[0]->ID, 'lw_date', true).'|'.$code_control.'|'.get_user_meta($get_user->id, 'billing_postcode', true);
            update_post_meta($order->id, 'lw_codigo_qr', $newcodeqr);
            echo json_encode(array('cod_order' => $order->id, 'text_qr' => $newcodeqr));
    }else {
        // echo json_encode(array('cod_order' => $order->id));
        $newcodeqr = 'GRACIAS POR TU PREFERENCIA';
        echo json_encode(array('cod_order' => $order->id, 'text_qr' => $newcodeqr));
    }
    $cart->clear();
?>