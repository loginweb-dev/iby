<?php

function lw_boxs_edit() {
    $post = get_post( $_GET["box_id"] );
//update
    if (isset($_POST['update'])) {
        // $post = get_post( $_GET["box_id"] );
        // update_post_meta( $post->ID, 'post_content', $_POST["post_content"]);
        wp_update_post(array('ID' => $_GET["box_id"], 'post_content' => $_POST["post_content"], 'post_status' => $_POST["post_status"], 'post_title' => $_POST["post_title"]));
        update_post_meta( $_GET["box_id"], 'lw_nota_apertura', $_POST["lw_nota_apertura"]);
        update_post_meta( $_GET["box_id"], 'lw_monto_inicial', $_POST["lw_monto_inicial"]);
        
        update_post_meta( $_GET["box_id"], 'lw_or', $_POST["option_restaurant"]  ? 'true' : 'false');
        $post = get_post( $_GET["box_id"] );
    }
//delete
    else if (isset($_POST['delete'])) {
        wp_delete_post($_GET["box_id"], true);
    } 
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/iby/css/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Caja</h2>
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
                        <th>Estado</th>
                        <td>
                            <input type="text" name="post_status" value="<?php echo $post->post_status; ?>"/>
                            <p>pusblish=creado, pending=abierto, private=cerrado </p>
                        </td>
                        
                    </tr>
                    <tr>
                        <th>Titulo</th><td><input type="text" name="post_title" value="<?php echo $post->post_title; ?>"/></td>
                    </tr>
                    <tr>
                        <th class="ss-th-width">Nota de Apertura</th>
                        <td><Textarea name="lw_nota_apertura" class="ss-field-width"><?php echo $post->lw_nota_apertura; ?></Textarea></td>
                    </tr>
                    <tr>
                        <th>Monto Inicial</th><td><input type="text" name="lw_monto_inicial" value="<?php echo $post->lw_monto_inicial; ?>"/></td>
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
                <input type='submit' name="update" value='Guardar' class='button'> &nbsp;&nbsp;
                <input type='submit' name="delete" value='Eliminar' class='button' onclick="return confirm('&iquest;Est&aacute;s seguro de borrar este elemento?')">
                <a href="<?php echo admin_url('admin.php?page=cajas'); ?>" class='button'> Volver</a>
            </form>
      

    </div>
    <?php
}