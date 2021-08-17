<?php
function lw_boxs_list() {
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/iby/css/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Listado de Cajas</h2>
        <!-- <div class="tablenav top"> -->
            <div class="alignleft actions">
                <a class="button"  href="<?php echo admin_url('admin.php?page=boxs-create'); ?>">Agregar Nueva</a>
            </div>
            <!-- <br class="clear"> -->
        <!-- </div> -->
        <?php

        $args = array(
            'post_type'        => 'pos_register',
            'post_status'        => array ('pending', 'publish', 'private'),
            'author' => '-1',
        );
        $rows = get_posts( $args );
        ?>

        <table class='wp-list-table widefat fixed striped posts'>
            <tr>
                <th class="manage-column ss-list-width">ID</th>
                <th class="manage-column ss-list-width">Estado</th>
                <th class="manage-column ss-list-width">Nombre</th>
                <th class="manage-column ss-list-width">Creado</th>
                <th class="manage-column ss-list-width">Nota Apertura</th>
                <th class="manage-column ss-list-width">Nota Cierre</th>
                <th class="manage-column ss-list-width">Monto Inicial</th>
                <th class="manage-column ss-list-width">Monto Final</th>
                <th class="manage-column ss-list-width">Usuario</th>
                <th class="manage-column ss-list-width">Acciones</th>
            </tr>
            <?php for($i=0; $i < count($rows); $i++){ $user = get_user_by( 'id', $rows[$i]->post_author ); ?>
                <tr>
                    <td class="manage-column ss-list-width"><?php echo $rows[$i]->ID; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $rows[$i]->post_status; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $rows[$i]->post_title; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $rows[$i]->post_date; ?></td>
                    <td class="manage-column ss-list-width"><?php echo get_post_meta( $rows[$i]->ID, 'lw_nota_apertura', true ); ?></td>
                    <td class="manage-column ss-list-width"><?php echo get_post_meta( $rows[$i]->ID, 'lw_nota_cierre', true ); ?></td>
                    <td class="manage-column ss-list-width"><?php echo get_post_meta( $rows[$i]->ID, 'lw_monto_inicial', true ); ?></td>
                    <td class="manage-column ss-list-width"><?php echo get_post_meta( $rows[$i]->ID, 'lw_monto_final', true ); ?></td>
                    
                    <td class="manage-column ss-list-width"><?php echo $user->display_name; ?></td>
                    
                    <td>
                        <a href="<?php if($rows[$i]->post_status=='pending' || $rows[$i]->post_status=='publish'){ echo WP_PLUGIN_URL.'/iby/pos.php?box_id='.$rows[$i]->ID; }else{ echo '#'; } ?>" target="_blank" class="button"><?php if($rows[$i]->post_status=='pending' || $rows[$i]->post_status=='publish'){ echo 'Abrir'; }else { echo 'Imprimir'; } ?></a>
                        <a href="<?php echo admin_url('admin.php?page=boxs-edit&box_id='.$rows[$i]->ID); ?>" class="button">Editar</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    
    <?php
    
}