<?php

function lw_setting() {
//update
    if (isset($_POST['update'])) {
    
       $post = get_post( $_POST["id"] );
       update_post_meta( $post->ID, 'lw_image', $_POST["lw_image"]);
       update_post_meta( $post->ID, 'lw_ceo', $_POST["lw_ceo"]);
       update_post_meta( $post->ID, 'lw_direction', $_POST["lw_direction"]);
       update_post_meta( $post->ID, 'lw_movil', $_POST["lw_movil"]);
       update_post_meta( $post->ID, 'lw_city', $_POST["lw_city"]);
       update_post_meta( $post->ID, 'lw_activity', $_POST["lw_activity"]);
       update_post_meta( $post->ID, 'lw_name_business', $_POST["lw_name_business"]);
       update_post_meta( $post->ID, 'lw_nit', $_POST["lw_nit"]);
       update_post_meta( $post->ID, 'lw_legend', $_POST["lw_legend"]);
    } 
    $setting = get_posts( array('post_status' => 'publish', 'post_type' => 'pos_lw_setting') );
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/iby/css/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Configuracion del TPV</h2>

        <?php if ($_POST['update']) { ?>
            <div class="updated"><p>Setting updated</p></div>
            <a href="<?php echo admin_url('admin.php?page=cajas') ?>">&laquo; Volver a Cajas</a>
        <?php } ?>
        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <table class='wp-list-table widefat fixed'>
                <tr><th>ID</th><td><input readonly type="text" name="id" value="<?php echo $setting[0]->ID; ?>"/></td></tr>
                <tr><th>Image o Logo</th><td><input type="text" name="lw_image" value="<?php echo get_post_meta($setting[0]->ID, 'lw_image', true); ?>"/></td></tr>
                <tr><th>CEO</th><td><input type="text" name="lw_ceo" value="<?php echo get_post_meta($setting[0]->ID, 'lw_ceo', true); ?>"/></td></tr>
                
                <tr><th>Direccion</th><td><textarea name="lw_direction"><?php echo get_post_meta($setting[0]->ID, 'lw_direction', true); ?></textarea></td></tr>
                
                <tr><th>Telefono</th><td><input type="text" name="lw_movil" value="<?php echo get_post_meta($setting[0]->ID, 'lw_movil', true); ?>"/></td></tr>
                <tr><th>Ciudad</th><td><input type="text" name="lw_city" value="<?php echo get_post_meta($setting[0]->ID, 'lw_city', true); ?>"/></td></tr>
                <!-- <tr><th>Actividad</th><td><input type="text" name="lw_activity" value="<?php echo get_post_meta($setting[0]->ID, 'lw_activity', true); ?>"/></td></tr> -->
                <tr><th>Actividad</th><td><textarea name="lw_activity"><?php echo get_post_meta($setting[0]->ID, 'lw_activity', true); ?></textarea></td></tr>
                
                <tr><th>Nombre del Negocio</th><td><input type="text" name="lw_name_business" value="<?php echo get_post_meta($setting[0]->ID, 'lw_name_business', true); ?>"/></td></tr>
                <tr><th>NIT</th><td><input type="text" name="lw_nit" value="<?php echo get_post_meta($setting[0]->ID, 'lw_nit', true); ?>"/></td></tr>
                <tr><th>Leyenda</th><td><textarea name="lw_legend"><?php echo get_post_meta($setting[0]->ID, 'lw_legend', true); ?></textarea></td></tr>
            </table>
                <br>
            <input type='submit' name="update" value='Actualizar' class='button'> &nbsp;&nbsp;
            <a href="<?php echo admin_url('admin.php?page=cajas'); ?>" class='button'> Volver</a>
        </form>
     

    </div>
    <?php
}