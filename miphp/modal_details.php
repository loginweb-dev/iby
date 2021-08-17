<?php 
require_once('../../../../wp-load.php');
    $post = get_post( $_GET["box_id"] );
    ?>
    <div class="modal-header">
        <h5 class="modal-title" id="modalBoxDetalleLabel">Detalle de Caja</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
	<div class="modal-body">
        <div class="form-group">
            <label><u>Estado</u></label>
            <input id="" type="text" class="form-control" placeholder="" value="<?php echo $post->post_status; ?>">
        </div>
        <div class="form-group">
            <label><u>Titulo</u></label>
            <input id="" type="text" class="form-control" placeholder="" value="<?php echo $post->post_title; ?>">
        </div>
        <div class="form-group">
            <label><u>Descripcion</u></label>
            <textarea id="" class="form-control"><?php echo $post->post_content;  ?></textarea>
        </div>
        <div class="form-group">
            <label><u>Nota de Apertura</u></label>
            <textarea id="" class="form-control"><?php echo get_post_meta($post->ID, 'lw_nota_apertura', true);  ?></textarea>
        </div>
        <div class="form-group">
            <label><u>Nota de Cierre</u></label>
            <textarea id="nota_cierre" class="form-control"><?php echo get_post_meta($post->ID, 'lw_nota_cierre', true);  ?></textarea>
        </div>
        <div class="form-group">
            <label><u>Monto Inicial</u></label>
            <input id="" type="text" class="form-control" placeholder="" value="<?php echo get_post_meta($post->ID, 'lw_monto_inicial', true); ?>">
        </div>
        <!-- <div class="form-group">
            <label><u>Pedidos</u></label>
            <input id="" type="text" class="form-control" placeholder="" value="<?php echo count(wc_get_orders( array('meta_query' => array('wc_pos_register_id' => $_GET["cod_box"])) )); ?>">
        </div> -->
        <!-- <div class="form-group">
            <label><u>Monto Final</u></label>
            <input id="" type="text" class="form-control" placeholder="" value="">
        </div> -->
    </div>    
    <div class="modal-footer">
        <button href="#" onclick="box_close()" type="button" class="btn btn-danger"><i class="fa fa-save"> </i> Cerrar Caja </button>
    </div>