<?php 
    require_once('../../../../wp-load.php');
    $current_user = wp_get_current_user();
    require_once 'class.Cart.php';
    $cart = new Cart([
        'cartMaxItem'      => 0,
        'itemMaxQuantity'  => 99,
        'useCookie'        => false,
    ]);

    // get user -------------------------------
    // $get_user = get_user_by( 'id', $_GET['cod_customer']);
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
                 wc_update_order_item_meta($item_id, $item['attributes']['name'].' (Bs.'.$item['attributes']['price'].')', $item['quantity'], false);
             } else {
                 $order->add_product( get_product($item['id']), $item['quantity']);
             }
         }
     }
    $order->calculate_totals();
    switch ($_GET['option']) {
        case 'Compra':
            $order->update_status("wc-compra");
            break;
        case 'Proforma':
            $order->update_status("wc-proforma");
            break;
        
        default:
            # code...
            break;
    }
    $order->set_customer_note( $_GET["note_customer"] );
    $order->save();
    $newcodeqr = 'COMPRA REALIZARA POR EL TPV';
    echo json_encode(array('cod_order' => $order->id, 'text_qr' => $newcodeqr));
    $cart->clear();
?>