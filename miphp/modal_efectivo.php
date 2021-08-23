<?php 
require_once('../../../../wp-load.php');
    $post = get_post( $_GET["box_id"] );
	// $option_rest = get_post( $_GET["box_id"] );
    ?>
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detalle de la Venta</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
      </div>
      <div class="modal-body">
		<div class="form-group text-center">
			<p><u>Tipo de Venta</u></p>
			<label class="custom-control custom-radio custom-control-inline">
				<input class="custom-control-input" checked="" type="radio" id="no_estado" name="estado" value="option1">
				<span class="custom-control-label"> Recibo </span>
			</label>
			<label class="custom-control custom-radio custom-control-inline">
				<input class="custom-control-input" type="radio" id="estado" name="estado" value="option2">
				<span class="custom-control-label"> Factura </span>
			</label>
		</div>
		
		<div class="form-group text-center">
			<p><u>Opciones de Impresion</u></p>
			<label class="custom-control custom-radio custom-control-inline">
				<input class="custom-control-input" checked="" type="radio" id="volver" name="volver" value="option3">
				<span class="custom-control-label"> Volver </span>
			</label>
			<label class="custom-control custom-radio custom-control-inline">
				<input class="custom-control-input" type="radio" id="imprimir" name="volver" value="option4">
				<span class="custom-control-label"> Imprimir </span>
			</label>
		</div>
		<div class="col form-group text-center">
			<label><u>Efectivo Entregado</u></label>
			<input id="entregado" onchange="entregado()" type="text" class="form-control" placeholder="<?php echo $_GET["total"] ?>" value="" autofocus>
		</div> 
		<div class="col form-group text-center">
			<label><u>Cambio en Efectivo</u></label>
			<input id="cambio" type="text" class="form-control" placeholder="" value="0" readonly>
		</div> 
      </div>
      <div class="modal-footer">
        <button href="#" id="new_shop_order" onclick="new_shop_order()" type="button" class="btn btn-primary" disabled> Finalizar </button>
      </div>
<?php 
