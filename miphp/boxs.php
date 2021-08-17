<?php 
    require_once('../../../../wp-load.php');

    $post = get_post( $_GET["box_id"] );



    if(isset($_GET["nota_cierre"])){
        
        $post->post_status = "private";
        wp_update_post( $post );
        update_post_meta($_GET["box_id"], 'lw_nota_cierre', $_GET["nota_cierre"]);

        $orders = wc_get_orders( array('meta_query' => array('wc_pos_register_id' => $_GET["box_id"] ) ) );
        $total = 0;
        foreach ( $orders as $order ) {
            foreach ( $order->get_items() as $item_id => $item ) {
                $total += $item->get_total();
            }
        }
        update_post_meta($_GET["box_id"], 'lw_monto_final', $total);
    }else if(isset($_GET["nota_apertura"])){
        $post->post_status = "publish";
        wp_update_post( $post );
        update_post_meta($_GET["box_id"], 'lw_nota_apertura', $_GET["nota_apertura"]);
        update_post_meta($_GET["box_id"], 'lw_monto_inicial', $_GET["monto_inicial"]);
    }
    echo json_encode(array("message" => "Datos Actualizados Correctamente.."));