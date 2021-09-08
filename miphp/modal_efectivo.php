<?php 
require_once('../../../../wp-load.php');
    ?>
        <div class="modal-header text-center">
            <h5 class="modal-title text-center" id="exampleModalLabel">Detalle de la Venta <p><?php echo $_GET["type_payment"]; ?></p></h5>
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
		
		<?php if($_GET['type_payment'] == 'Efectivo'){?>
			<div class="row justify-content-md-center">
				<div class="col-md-6 form-group">
					<label><u>Efectivo Entregado</u></label>
					<input id="entregado" onchange="entregado()" type="text" class="form-control" placeholder="<?php echo $_GET["total"] ?>" value="" autofocus>
				</div> 
			</div>
			<div class="row justify-content-md-center">
				<div class="col-md-6 form-group ">
					<label><u>Cambio en Efectivo</u></label>
					<input id="cambio" type="text" class="form-control" placeholder="" value="0" readonly>
				</div> 
			</div>
			<div class="form-group text-center">
				<p class=""><u>Opciones de Impresion</u></p>
				<label class="custom-control custom-radio custom-control-inline">
					<input class="custom-control-input" checked="" type="radio" id="volver" name="volver" value="option3">
					<span class="custom-control-label"> Volver </span>
				</label>
				<label class="custom-control custom-radio custom-control-inline">
					<input class="custom-control-input" type="radio" id="imprimir" name="volver" value="option4">
					<span class="custom-control-label"> Imprimir </span>
				</label>
			</div>
		</div>
	
		<div class="modal-footer">
			<button href="#" id="new_shop_order" onclick="new_shop_order('<?php echo $_GET['type_payment']; ?>')" type="button" class="btn btn-primary" disabled> Finalizar </button>
		</div>
	  	<?php }else if($_GET['type_payment'] == 'Tigo Money'){ ?>
			<div class="col form-group text-center">
				<img class="img-thumbnail img-md text-center" src="resources/tigo_money.png" alt="">
			</div> 
		</div>
		<div class="modal-footer">
			<button href="#" id="new_shop_order" onclick="new_shop_order('<?php echo $_GET['type_payment']; ?>')" type="button" class="btn btn-primary" > Guardar </button>
		</div>
		<?php }else if($_GET['type_payment'] == 'QR Simple'){ ?>
			<div class="col form-group text-center">
			<img class="img-thumbnail img-md text-center" src="resources/qr_simple.jpg" alt="">
			</div> 
			</div>
		<div class="modal-footer">
			<button href="#" id="new_shop_order" onclick="new_shop_order('<?php echo $_GET['type_payment']; ?>')" type="button" class="btn btn-primary" > Guardar </button>
		</div>
		<?php }else if($_GET['type_payment'] == 'Transferencia Bancaria'){ ?>
			<div class="col form-group text-center">
			<img class="img-thumbnail img-md text-center" src="resources/tranferencia.jpg" alt="">
			</div> 
			</div>
		<div class="modal-footer">
			<button href="#" id="new_shop_order" onclick="new_shop_order('<?php echo $_GET['type_payment']; ?>')" type="button" class="btn btn-primary" > Guardar </button>
		</div>
		<?php }else if($_GET['type_payment'] == 'Tarjeta Credito/Debito'){ ?>
			<div class="col form-group text-center">
			<img class="img-thumbnail img-md text-center" src="resources/tarjeta_cd.jpeg" alt="">
			</div> 
			</div>
		<div class="modal-footer">
			<button href="#" id="new_shop_order" onclick="new_shop_order('<?php echo $_GET['type_payment']; ?>')" type="button" class="btn btn-primary" > Guardar </button>
		</div>
		<?php } ?>
<?php 
