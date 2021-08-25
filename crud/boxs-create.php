<?php

function lw_boxs_create() {
    if (isset($_POST['insert'])) {
        $my_box = array(
            'post_title'    => $_POST['post_title'],
            'post_content'  => $_POST['post_content'],
            'post_status'   => 'pending',
            'post_type'   => 'pos_register',
            'meta_input' => array(
                'lw_nota_apertura' => null,
                'lw_nota_cierre' => null,
                'lw_monto_inicial' => null,
                'lw_monto_final' => null,
                'outlet' => $_POST['outlet'] , //pos_outlet
                'receipt' => $_POST['receipt'] , //pos_receipt
                'customer' => $get_user->id, //user
                'lw_or' => $_POST["option_restaurant"]  ? 'true' : 'false', // options restaurnt
            )

        );
        
        // Insert the post into the database
        $box_id = wp_insert_post( $my_box );
        header('Location: ' . admin_url('admin.php?page=cajas'), true);
        die();
    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/iby/css/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Nueva Caja</h2>
        <?php if (isset($message)): ?><div class="updated"><p><?php echo $message; ?></p></div><?php endif; ?>
        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <!-- <p>Three capital letters for the ID</p> -->
            <table class='wp-list-table widefat fixed'>
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
                    <th class="ss-th-width">Titulo</th>
                    <td><input type="text" name="post_title" value="<?php echo $post_title; ?>" class="ss-field-width" /></td>
                </tr>
                <tr>
                    <th class="ss-th-width">Descripcion</th>
                    <td><Textarea name="post_content" class="ss-field-width"><?php echo $post_content; ?></Textarea></td>
                </tr>
                <tr><th>Restaurant</th>
                    <td><label><input type="checkbox" name="option_restaurant" <?php if(get_post_meta($post->ID, 'lw_or', true) == 'true') { echo 'checked'; }; ?> > Habilitar</label></td>
                </tr>

            </table>
            <br>
            <input type='submit' name="insert" value='Guardar' class='button'>
            <a href="<?php echo admin_url('admin.php?page=cajas'); ?>" class='button'> Volver</a>
        </form>
    </div>
    <?php
}