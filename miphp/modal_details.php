<?php 
require_once('../../../../wp-load.php');
    $post = get_post( $_GET["box_id"] );
    $tv=0;
    $orders = wc_get_orders(array('limit' => 100, 'meta_query' => array('wc_pos_register_id' => $_GET["cod_box"])));
    foreach ($orders as $key) {
        if (get_post_meta( $key->ID, 'lw_accounting', true )  == 'no') {
            $tv = $tv + get_post_meta( $key->ID, '_order_total', true );
        } 
    }   
    ?>
    <div class="modal-header">
        <h5 class="modal-title" id="modalBoxDetalleLabel">Detalle de Caja</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
	<div class="modal-body">
        <div class="form-group">
            <label><u>Titulo</u></label>
            <input id="" type="text" class="form-control" placeholder="" value="<?php echo $post->post_title; ?>" readonly>
        </div>
        <div class="form-group">
            <label><u>Nota de Apertura</u></label>
            <textarea id="" class="form-control" readonly><?php echo get_post_meta($post->ID, 'lw_nota_apertura', true);  ?></textarea>
        </div>
        <div class="form-group">
            <label><u>Nota de Cierre</u></label>
            <textarea id="nota_cierre" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label><u>Monto Final = <?php echo get_post_meta($post->ID, 'lw_monto_inicial', true); ?> + <?php echo $tv; ?></u> (MI+TV)</label>
            <input id="lw_monto_final" type="text" class="form-control" placeholder="" value="<?php echo $tv + get_post_meta($post->ID, 'lw_monto_inicial', true); ?>">
        </div>
    </div>    
    <div class="modal-footer">
        <button href="#" onclick="box_close()" type="button" class="btn btn-danger"><i class="fa fa-save"> </i> Cerrar </button>
    </div>