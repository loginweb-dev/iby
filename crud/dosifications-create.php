<?php

function lw_dosification_create() {
    if (isset($_POST['insert'])) {
        $my_box = array(
            'post_title'    => $_POST["title"],
            'post_status'   => 'publish',
            'post_type'   => 'pos_dosification',
            'meta_input' => array(
                'lw_autorization' => $_POST["autorization"],
                'lw_date' => $_POST["date"],
                'lw_key' => $_POST["lw_key"],
            )
        );
        
        // Insert the post into the database
        wp_insert_post( $my_box );
        header('Location: ' . admin_url('admin.php?page=cajas'), true);
        die();
    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/iby/css/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Nueva Dosificacion</h2>
        <?php if (isset($message)): ?><div class="updated"><p><?php echo $message; ?></p></div><?php endif; ?>
        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <!-- <p>Three capital letters for the ID</p> -->
            <table class='wp-list-table widefat fixed'>
                <tr>
                    <th class="ss-th-width">Titulo</th>
                    <td><input type="text" name="title" value="<?php echo $_POST["title"]; ?>" class="ss-field-width" /></td>
                </tr>
                <tr>
                    <th class="ss-th-width">Autorizacion</th>
                    <td><input type="text" name="autorization" value="<?php echo $_POST["autorization"]; ?>" class="ss-field-width" /></td>
                </tr>
                <tr>
                    <th class="ss-th-width">Fecha de Caducidad</th>
                    <td><input type="text" name="date" value="<?php echo $_POST["date"]; ?>" class="ss-field-width" /></td>
                </tr>
                <tr>
                    <th class="ss-th-width">Llave</th>
                    <td><input type="text" name="lw_key" value="<?php echo $_POST["lw_key"]; ?>" class="ss-field-width" /></td>
                </tr>
            </table>
            <br>
            <input type='submit' name="insert" value='Guardar' class='button'>
            <a href="<?php echo admin_url('admin.php?page=dosifications'); ?>" class='button'> Volver</a>
        </form>
    </div>
    <?php
}