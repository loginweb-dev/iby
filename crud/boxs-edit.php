<?php

function lw_boxs_edit() {
    $post = get_post( $_GET["box_id"] );
//update
    if (isset($_POST['update'])) {
        wp_update_post(array('ID' => $_GET["box_id"], 'post_content' => $_POST["post_content"], 'post_status' => $_POST["post_status"], 'post_title' => $_POST["post_title"]));
        update_post_meta( $_GET["box_id"], 'lw_nota_apertura', $_POST["lw_nota_apertura"]);
        update_post_meta( $_GET["box_id"], 'lw_monto_inicial', $_POST["lw_monto_inicial"]);
        
        update_post_meta( $_GET["box_id"], 'lw_or', $_POST["option_restaurant"]  ? 'true' : 'false');
        $post = get_post( $_GET["box_id"] );
    }
//delete
    else if (isset($_POST['delete'])) {
        
        wp_delete_post($_POST["post_id"], true);
    } 
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/iby-master/css/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>
            Caja <a href="<?php echo admin_url('admin.php?page=cajas'); ?>" class='button'> Volver</a> 
            <a href="<?php echo WP_PLUGIN_URL.'/iby-master/pos.php?box_id='.$_GET["box_id"]; ?>" class='button'> Abrir</a>
            
        </h2>
        <?php if ($_POST['delete']) { ?>
            <div class="updated"><p>Caja Eliminada</p></div>
        <?php } else if ($_POST['update']) { ?>
            <div class="updated"><p>Caja updated</p></div>
        <?php } ?>
            <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <table class='wp-list-table widefat fixed'>
                    <tr><th>ID</th><td><input readonly type="text" name="id" value="<?php echo $post->ID; ?>"/></td></tr>
                    <tr>
                        <th class="ss-th-width">Tienda</th>
                        <td>
                            <select name="outlet" id="" class="ss-field-width">
                                <?php $rows = get_posts( array('post_type' => 'pos_outlet') ); ?>
                                <?php for ($i=0; $i < count($rows); $i++) { ?>
                                    <option value="<?php echo $rows[$i]->ID ?>"><?php echo $rows[$i]->post_title ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="ss-th-width">Descripcion</th>
                        <td><Textarea name="post_content" class="ss-field-width"><?php echo $post->post_content; ?></Textarea></td>
                    </tr>
                    <tr>
                        <th class="ss-th-width">PDF (factura o recibo)</th>
                        <td>
                            <select name="receipt" id="" class="ss-field-width">
                                <?php $rows = get_posts( array('post_type' => 'pos_receipt') ); ?>
                                <?php for ($i=0; $i < count($rows); $i++) { ?>
                                    <option value="<?php echo $rows[$i]->ID ?>"><?php echo $rows[$i]->post_title ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Titulo</th><td><input type="text" name="post_title" value="<?php echo $post->post_title; ?>"/></td>
                    </tr>
                    <tr><th>Restaurant</th>
                        <td>
                            <label><input type="checkbox" name="option_restaurant" <?php if(get_post_meta($post->ID, 'lw_or', true) == 'true') { echo 'checked'; }; ?> > Habilitar</label>
                            <p>Metas: (En Mesa, Recoje en Tienda, Delivery)</p>
                            <p>Habilita Panel de Productos</p>
                        </td>
                    </tr>
                </table>
                <br>
            </form>
    </div>
    <?php 

    $closeds = get_posts(array('post_type' => 'pos_temp_order', 'post_parent' => $_GET["box_id"], 'orderby' => 'date', 'order' => 'DESC', 'limit' => 10));
    $miorders = wc_get_orders(array('orderby' => 'date', 'order' => 'DESC', 'limit' => 10));
?>
    <h2>Todas las Ventas</h2>
    <table class="wp-list-table widefat fixed striped posts">
      <thead>
        <tr>
          <th scope="col">Fecha</th>
          <th scope="col">Cliente</th>
          <th scope="col">Conta</th>
          <th scope="col">Atendido</th>
          <th scope="col">Total</th>
        </tr>
      </thead>
      <tbody>
        <?php $mitotal=0; foreach ($miorders as $key) { $order = wc_get_order($key->ID); $data = $order->get_data(); $caja = get_post_meta($key->ID, 'wc_pos_register_id', true ); ?>
            <?php if ($caja == $_GET["box_id"]) { ?>
                <tr>
                    <td>
                        # <a href="<?php echo admin_url('post.php?post='.$order->get_id().'&action=edit'); ?>"><?php echo $order->get_id(); ?></a>
                        <br>
                        <?php echo $order->get_date_created()->date('Y-m-d H:i:s') ?>
                        <br>
                        <?php echo get_post_meta( $key->ID, 'lw_pos_type_order', true ); ?>
                    </td>
                    <td>
                        <?php echo get_post_meta( $key->ID, '_billing_email', true ); ?>
                        <br>
                        <?php $items = $order->get_items(); foreach ( $items as $item ) { $extra = $item->get_meta_data(); $product = $item->get_product(); ?>
                        
                            <small>
                                <a  href="<?php echo admin_url('post.php?post='.$item['product_id'].'&action=edit'); ?>"><?php echo $item['name']; ?></a>
                            </small>
                            <br>
                            <?php for ($i=0; $i < count($extra); $i++) { ?>
                            <?php if ($extra[$i]->key == '_wc_cog_item_cost' || $extra[$i]->key == '_wc_cog_item_total_cost' ) { ?>                        
                                <?php }else{ ?> 
                                    <small><?php echo $extra[$i]->key.': '.$extra[$i]->value; ?></small><br>
                                <?php } ?> 
                            <?php } ?> 
                        <?php } ?>
                    </td>
                    <td><?php echo get_post_meta( $key->ID, 'lw_accounting', true ); ?></td>
                    <td>
                        <?php echo get_post_meta( $key->ID, '_payment_method_title', true ); ?>
                        <br>
                        <?php echo get_post_meta( $key->ID, 'wc_pos_served_by_name', true ); ?>
                    </td>
                    <td><?php $mitotal = $mitotal + $order->get_total(); echo $order->get_total(); ?></td>
                </tr>
            <?php  } ?>
        <?php  } ?>
        <tr>
            <td></td>
            <td></td>
            <td>Total</td>
            <td>Bolivianos:</td>
            <td><?php echo  number_format($mitotal, 2, '.', ''); ?></td>
        </tr>
      </tbody>
    </table>

    <h2>Todos los Cierres</h2>
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
        <table class="wp-list-table widefat fixed striped posts">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Titulo</th>
            <th scope="col">Notas</th>
            <th scope="col">Montos</th>
            <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($closeds as $key) { ?>
            <tr>
                <th scope="row"><?php echo $key->ID; ?></th>
                <th scope="row"><?php echo $key->post_title; ?><br><small><?php echo $key->post_date; ?></small></th>
                <td><?php echo get_post_meta( $key->ID, 'lw_nota_apertura', true ); ?><br><?php echo get_post_meta( $key->ID, 'lw_nota_cierre', true ); ?></td>
                <td><?php echo get_post_meta( $key->ID, 'lw_monto_inicial', true ); ?><br><?php echo get_post_meta( $key->ID, 'lw_monto_final', true ); ?></td>
                <th scope="row"><?php echo get_post_meta($key->ID, 'lw_monto_final', true ); ?></th>
            </tr>
            <?php } ?>
        </tbody>
        </table>
    </form>
<?php } ?>