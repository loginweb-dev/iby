<?php 
    require_once('../../../../wp-load.php');
    $post = get_post( $_GET["box_id"] );
    $current_user = wp_get_current_user();
    if(isset($_GET["nota_cierre"])){
        $my_post = array(
            'post_title'    => wp_strip_all_tags( 'POS Register #'.$_GET["box_id"] ),
            //'post_content'  => null,
            'post_type'  => 'pos_temp_order',
            'post_status'   => 'publish',
            'post_parent'   => $_GET["box_id"],
            'post_author'   => $current_user->id,
            'meta_input' => array(
                'lw_nota_apertura' => $post->lw_nota_apertura,
                'lw_nota_cierre' => $_GET["nota_cierre"],
                'lw_monto_inicial' => $post->lw_monto_inicial,
                'lw_monto_final' => $_GET["lw_monto_final"],
            )
        );
        wp_insert_post( $my_post );
        $post->post_status = "pending";
        wp_update_post( $post );
        update_post_meta($_GET["box_id"], 'lw_nota_apertura', null);
        update_post_meta($_GET["box_id"], 'lw_monto_inicial', null);
        update_post_meta($_GET["box_id"], 'lw_nota_cierre', $_GET["nota_cierre"]);
        update_post_meta($_GET["box_id"], 'lw_monto_final', $_GET["lw_monto_final"]);

        $orders = wc_get_orders(array('meta_query' => array('wc_pos_register_id' => $_GET["cod_box"], 'lw_accounting' => 'no')));
        foreach ($orders as $key) {
           update_post_meta( $key->ID, 'lw_accounting', 'yes' );
        }   
        update_post_meta($_GET["box_id"], 'lw_nota_cierre', $_GET["nota_cierre"]);
    }else if(isset($_GET["nota_apertura"])){
        $post->post_status = "publish";
        wp_update_post( $post );
        update_post_meta($_GET["box_id"], 'lw_nota_cierre', null);
        update_post_meta($_GET["box_id"], 'lw_monto_final', null);
        update_post_meta($_GET["box_id"], 'lw_nota_apertura', $_GET["nota_apertura"]);
        update_post_meta($_GET["box_id"], 'lw_monto_inicial', $_GET["monto_inicial"]);
    }
    echo json_encode(array("message" => "Datos Actualizados Correctamente.."));