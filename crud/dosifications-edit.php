<?php

function lw_dosification_edit() {
//update
    if (isset($_POST['update'])) {

    }
//delete
    else if (isset($_POST['delete'])) {
        
        wp_delete_post($_GET["id"], true);
    } else {//selecting value to update	
       
        $post = get_post( $_GET["id"] );
    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/iby-master/css/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Editar Dosificacion</h2>

        <?php if ($_POST['delete']) { ?>
            <div class="updated"><p>Dosificacion Eliminada</p></div>
            <a href="<?php echo admin_url('admin.php?page=dosifications') ?>">&laquo; Volver a la lista</a>

        <?php } else if ($_POST['update']) { ?>
            <div class="updated"><p>School updated</p></div>
            <a href="<?php echo admin_url('admin.php?page=') ?>">&laquo; Back to schools list</a>

        <?php } else { ?>
            <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <table class='wp-list-table widefat fixed'>
                    <tr><th>Title</th><td><input type="text" name="title" value="<?php echo $post->post_title; ?>"/></td></tr>
                </table>
                <br>
                <input type='submit' name="update" value='Guardar' class='button'> &nbsp;&nbsp;
                <input type='submit' name="delete" value='Eliminar' class='button' onclick="return confirm('&iquest;Est&aacute;s seguro de borrar este elemento?')">
                <a href="<?php echo admin_url('admin.php?page=dosifications'); ?>" class='button'> Volver</a>
            </form>
        <?php } ?>

    </div>
    <?php
}