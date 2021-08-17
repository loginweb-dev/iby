<?php

function lw_dosifications_list() {
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/sinetiks-schools/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Dosificaciones</h2>
        <div class="tablenav top">
            <div class="alignleft actions">
                <a href="<?php echo admin_url('admin.php?page=dosification-create'); ?>">Agregar Nueva</a>
            </div>
            <br class="clear">
        </div>
        <?php
        $args = array(
            'post_type'        => 'pos_dosification'
        );
        $rows = get_posts( $args );
        ?>
        <table class='wp-list-table widefat fixed striped posts'>
            <tr>
                <th class="manage-column">ID</th>
                <th class="manage-column ss-list-width">Estado</th>
                <th class="manage-column ss-list-width">Titulo</th>
                <th class="manage-column ss-list-width">Autorizacion</th>
                <th class="manage-column ss-list-width">Fecha</th>
                <th class="manage-column ss-list-width">Llave</th>
                <th class="manage-column ss-list-width">Acciones</th>
            </tr>
            <?php for($i=0; $i < count($rows); $i++){ $user = get_user_by( 'id', $rows[$i]->post_author ); ?>
                <tr>
                    <td class="manage-column"><?php echo $rows[$i]->ID; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $rows[$i]->post_status; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $rows[$i]->post_title; ?></td>
                    <td class="manage-column ss-list-width"><?php echo get_post_meta( $rows[$i]->ID, 'lw_autorization', true ); ?></td>
                    <td class="manage-column ss-list-width"><?php echo get_post_meta( $rows[$i]->ID, 'lw_date', true ); ?></td>
                    <td class="manage-column ss-list-width"><?php echo get_post_meta( $rows[$i]->ID, 'lw_key', true ); ?></td>
                    
                    <td><a type="button" class="button" href="<?php echo admin_url('admin.php?page=dosification-edit&id=' . $rows[$i]->ID); ?>">Editar</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <?php
}