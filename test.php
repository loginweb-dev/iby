<?php 
require_once('../../../wp-load.php');

    $order = wc_get_order( 523 );
    // $total = $order->calculate_totals();
    // $total = $order->set_total(120);
    // $total = $order->calculate_totals();
    // echo $total;
    // $order->set_total($amount);
    // $item = $order->wc_add_order_item_meta();

    $items = $order->get_items();
    foreach ( $items as $item ) {
        echo $item->get_name();
        // echo $item->get_product_id();
        echo $item->get_id();
    }
?>