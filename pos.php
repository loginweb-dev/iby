<?php 
	require_once('../../../wp-load.php');
	$current_user = wp_get_current_user();
	if (!isset($current_user->display_name)) {
		header('Location: ' . '/', true);
   		die();
	}
	require_once 'miphp/class.Cart.php';
	$cart = new Cart([
		'cartMaxItem'      => 0,
		'itemMaxQuantity'  => 99,
		'useCookie'        => false,
	]);
	$post = get_post( $_GET["box_id"] );
	$QR_BASEDIR = dirname(__FILE__).DIRECTORY_SEPARATOR;
	// echo $QR_BASEDIR;
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="cache-control" content="max-age=604800" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>POS</title>

<link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon">
<link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
<!-- Font awesome 5 -->
<link href="fonts/fontawesome/css/all.min.css" type="text/css" rel="stylesheet">
<!-- custom style -->
<link href="css/ui.css" rel="stylesheet" type="text/css"/>
<link href="css/responsive.css" rel="stylesheet" media="only screen and (max-width: 1200px)" />
<script>
	let isMobile = {
		mobilecheck : function() {
			return (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino|android|ipad|playbook|silk/i.test(navigator.userAgent||navigator.vendor||window.opera)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test((navigator.userAgent||navigator.vendor||window.opera).substr(0,4)))
		}
	}
</script>
</head>
<body style="background-color: #F6F7F9;">
<header class="section-header" style="background-color: #FFFFFF;">
	<section class="header-main border-bottom">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-lg-6 col-md-6 col-sm-12">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Buscar Productos" id="criterio_id">
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12">
					<!-- <div class="widgets-wrap float-md-right"> -->
						<div class="widget-header icontext">
							<a href="#" class="icon icon-sm rounded-circle border"><i class="fa fa-address-book"></i></a>
							<div class="text">
								<span class="text-muted"><?php echo $post->post_title; ?></span>
								<input class="form-control" type="text" id="cod_box" value="<?php echo $_GET["box_id"]; ?>" hidden>
								<br><button class="btn btn-light btn-sm" id="box_show">Cerrar Caja</button>
								
							</div>
						</div>
						<div class="widget-header icontext">
							<a href="#" class="icon icon-sm rounded-circle border"><i class="fa fa-user"></i></a>
							<div class="text">
								<span class="text-muted">Hola <?php echo $current_user->display_name ?>!</span>
								<div> 
									<a href="/"> Volver al Panel</a>
								</div>
							</div>
						</div>
					<!-- </div> -->
				</div>
			</div>
		</div>
	</section>
</header>

<div id="milistsearch"></div>
<!-- <div id="milistcatgs"></div> -->

<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content">
	<div class="container-fluid">
		<div class="row">
			<main class="col-md-8">
				<div class="card mt-1">
					<article class="filter-group">
						<header class="card-header">
							<a href="#" data-toggle="collapse" data-target="#collapse100">
								<i class="icon-control fa fa-chevron-down"></i>
								<h6 class="title"> Carrito </h6>
							</a>
						</header>
						<div class="filter-content collapse show" id="collapse100">
							<div class="card-body">
								<div id="mitabla"></div>
							</div>
						</div>
					</article>
				</div>
				<div class="card mt-1">
					<div id="milistcatgs"></div>
				</div>
			</main>
			<aside class="col-md-4">
				<?php if(get_post_meta($post->ID, 'lw_or', true) == 'true'){ ?>
					<div class="card mt-1">
						<article class="filter-group">
							<header class="card-header">
								<a href="#" data-toggle="collapse" data-target="#collapse34">
									<i class="icon-control fa fa-chevron-down"></i>
									<h6 class="title"> Opciones de Restaurant </h6>
								</a>
							</header>
							<div class="filter-content collapse show" id="collapse34">
								<div class="card-body">
								<div class="form-group">
								<label class="custom-control custom-radio custom-control-inline">
									<input class="custom-control-input" type="radio"  id="rt" name="option_restaurant" value="option1">
									<span class="custom-control-label"> Recoger en Tienda </span>
								</label>
								<br>
								<label class="custom-control custom-radio custom-control-inline">
									<input class="custom-control-input" checked type="radio" id="em"  name="option_restaurant" value="option2">
									<span class="custom-control-label"> En Mesa </span>
								</label>
								<br>
								<label class="custom-control custom-radio custom-control-inline">
									<input class="custom-control-input" type="radio" id="de" name="option_restaurant" value="option3">
									<span class="custom-control-label"> Delivery </span>
								</label>
							</div>
							<hr>
							<?php 
								$results = $wpdb->get_row('SELECT meta_value FROM wp_postmeta WHERE post_id = 366 AND  meta_key = "_product_addons"');
								$results = unserialize($results->meta_value);
								foreach ( $results  as $j => $fieldoption ) {
									if($fieldoption['type'] == "checkbox"){
										foreach ( $fieldoption['options'] as $i => $option ) {
											// $id = $option['id'];
											$title = $option['label'];
											$price = $option['price'];
											?>
												<div class="form-check" id="miextra" disabled>
													<input id='<?php echo $i+1; ?>' onclick="extras('<?php echo $i+1; ?>', '<?php echo $title; ?>', <?php echo $price; ?>)" class="form-check-input" type="checkbox">
													<label for="my-input" class="form-check-label"> <?php echo $title; echo ' - '; echo $price; ?> Bs.</label>
												</div>
											<?php
										}
									}
								}
							?> 
						</article>
					</div>
				<?php } ?>
				<div class="card mt-1">
					<article class="filter-group">
						<header class="card-header">
							<a href="#" data-toggle="collapse" data-target="#collapse33">
								<i class="icon-control fa fa-chevron-down"></i>
								<h6 class="title"> Cliente </h6>
							</a>
						</header>
						<div class="filter-content collapse show" id="collapse33">
							<div class="card-body">
								<form>
									<div class="form-group">
											<input id="customer_search" type="text" class="form-control" placeholder="Buscar cliente">
											<input class="form-control" type="text" id="id_customer" hidden>
											<div id="list_search_customers"></div>
									</div>
								</form>
							</div>
						</div>
					</article>
				</div>
				<div class="card mt-1">
					<article class="filter-group">
						<header class="card-header">
							<a href="#" data-toggle="collapse" data-target="#collapse35">
								<i class="icon-control fa fa-chevron-down"></i>
								<h6 class="title">Resumen del Carrito </h6>
							</a>
						</header>
						<div class="filter-content collapse show" id="collapse35">
							<div class="card-body">
							<dl class="dlist-align">
							<dt>Total:</dt>
							<dd class="text-right  h5"><div id="total_numeral"></div></dd>
							</dl>
							<div id="total_literal"></div>
							<hr>
							<dl class="dlist-align">
							<dt>Cantidad:</dt> 
							<dd class="text-right  h5"><div id="cant_items"></div></dd>
							</dl>
							<hr>
							</div>
						</div>
					</article>
				</div>
				<div class="card mt-1">
					<article class="filter-group">
						<header class="card-header">
							<a href="#" data-toggle="collapse" data-target="#collapse36">
								<i class="icon-control fa fa-chevron-down"></i>
								<h6 class="title">Pasarela de Pago </h6>
							</a>
						</header>
						<div class="filter-content collapse show" id="collapse36">
							<div class="card-body">
								<div class= "row">
									<p class="text-center mb-6 mr-2">
										<button class="btn btn-light" id="btn_pago_efectivo" onclick="pasarela('Efectivo')" disabled> <i class="fa fa-money-bill-alt"></i> Efectivo</button>
									</p>
									<!-- <p class="text-center mb-3">btn_pago_delivery
										<button class="btn btn-light" id="btn_pago_delivery" disabled> <i class="fa fa-registered"></i> Delivery </button>
									</p> -->
									<p class="text-center mb-6">
										<button class="btn btn-light" id="btn_pago_tigo_money" onclick="pasarela('Tigo Money')" disabled> <i class="fa fa-registered"></i>Tigo Money</button>
									</p>
									<p class="text-center mb-6 mr-2">
										<button class="btn btn-light" id="btn_pago_qr_simple" onclick="pasarela('QR Simple')" disabled> <i class="fa fa-registered"></i>QR Simple</button>
									</p>
									<p class="text-center mb-6">
										<button class="btn btn-light" id="btn_pago_transferencia" onclick="pasarela('Transferencia Bancaria')"  disabled> <i class="fa fa-registered"></i>Transferencia</button>
									</p>
									<p class="text-center mb-6 mr-2">
										<button class="btn btn-light" id="btn_pago_tarjeta_cd" onclick="pasarela('Tarjeta Credito/Debito')" disabled> <i class="fa fa-registered"></i>Tarjerta Debito/Credito</button>
									</p>
								</div>
							</div>
						</div>
					</article>
				</div>
				<div class="card mt-1">
					<article class="filter-group">
						<header class="card-header">
							<a href="#" data-toggle="collapse" data-target="#collapse37" class="collapsed" aria-expanded="false">
								<i class="icon-control fa fa-chevron-down"></i>
								<h6 class="title">Otras Opciones </h6>
							</a>
						</header>
						<div class="filter-content collapse" id="collapse37">
							<div class="card-body">
								<p class="text-center mb-3">
									<button class="btn btn-light" id="btn_proforma" disabled> <i class="fa fa-registered"></i>Proforma</button>
								</p>
								<p class="text-center mb-3">
									<button class="btn btn-light" id="btn_compra" disabled> <i class="fa fa-registered"></i>Compra</button>
								</p>
							</div>
						</div>
					</article>
				</div>
			</aside> 
		</div> 
	</div> 
</section>
<!-- ========================= SECTION CONTENT END// ========================= -->


<!-- ========================= FOOTER ========================= -->
<footer class="section-footer border-top text-center mt-1">
	<small>App Creada por la Empresa LoginWeb @2021</small>
</footer>
<!-- ========================= FOOTER END // ========================= -->

<!-- Modal  APertura de Caja -->
<div class="modal fade" id="modalBox" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div id="box_body"></div>
		</div>
	</div>
</div>


<!-- custom javascript -->
<!-- jQuery -->
<script src="js/jquery-2.0.0.min.js" type="text/javascript"></script>
<!-- Bootstrap4 files-->
<script src="js/bootstrap.bundle.min.js" type="text/javascript"></script>
<script src="js/script.js" type="text/javascript"></script>
<script src="js/notify.js" type="text/javascript"></script>
<script src="src/index.js"></script>
<script type="text/javascript">
	// let notifier = new AWN(globalOptions);
		// Open cash---------------------------------------------------- 
		// $("#btn_pago_efectivo").click(function (e) { 
		// e.preventDefault();-----------------------------------------------
		function pasarela(type_payment) {
			let total = 0;
			$.ajax({
				url: "miphp/micart.php",
				dataType: "json",
				data: { "get_totals": true },
				success: function (response) {
					total = response.total_numeral;	
		
						$.ajax({
							url: "miphp/modal_efectivo.php",
							dataType: 'html',
							contentType: 'text/html',
							data: {"total" : total, "type_payment" : type_payment},
							success: function (response) {
								$('#box_body').html(response);	
								$('#modalBox').modal('show');
								$("#entregado").focus();
							}
						});
			
				}
			});	
		}
	// });

	//Extras -----------------------------------------------------
	function extras(id, title, price){
		$('#'+id).attr("disabled", true);
		$.ajax({
			url: "miphp/micart.php",
			dataType: "json",
			data: {"extra": true, "id": id, "title": title, "price": price },
			success: function (response) {
				$.notify(response.message, "info");
				build_cart();
				
			}
		});
		
	}
	//Cerrando Caja------------------------------------------------
	function box_close(){
		let nota_cierre = $("#nota_cierre").val();
		let box_id = "<?php echo $post->ID;  ?>";
		$.ajax({
			url: "miphp/boxs.php",
			dataType: "json",
			data: {"box_id": box_id, "nota_cierre": nota_cierre },
			success: function (response) {
				$('#modalBox').modal('toggle');
				window.location.href = "<?php echo admin_url('admin.php?page=cajas'); ?>";
			}
		});
		
	}

	// Venta Detalle  --------------------------------------------------------------
	function entregado(){
		let entregado = $("#entregado").val();
		$('#cambio').val("trabajando...");
		$('#new_shop_order').html("trabajando...");
		$('#new_shop_order').prop("disabled", true);
		$.ajax({
			url: "miphp/micart.php",
			dataType: "json",
			data: { "get_totals": true },
			success: function (response) {
				let newcambio = entregado - response.total_numeral;
				$('#cambio').val(newcambio);	
				$('#new_shop_order').html("Finalizar");
				$('#new_shop_order').prop("disabled", false);
			}
		});
	}
	// Create new Shop Order----------------------------------------------
	function new_shop_order(type_payment){
		$('#modalBox').modal('toggle');
		$.notify("Pedido en Proceso", "info");
		let id_customer = $("#id_customer").val();
		let cod_box = $("#cod_box").val();
		let entregado = $("#entregado").val();
		let cambio = $("#cambio").val();
		let tipo_venta = $("#no_estado").is(":checked") ? "recibo" : "factura";
		let option_restaurant = $("#em").is(":checked") ? "En Mesa" : $("#rt").is(":checked") ? "Recoger en Tienda" : $("#de").is(":checked") ? "Delivery" : null;
		let opciones_print = $("#volver").is(":checked") ? false : true;
		if (tipo_venta == "recibo" ) {
			if (opciones_print) {
				$.ajax({
					url: "miphp/orders.php",
					dataType: "json",
					data: {"cod_customer": id_customer, "cod_box": cod_box, "entregado": entregado, "cambio": cambio, "tipo_venta": tipo_venta, "option_restaurant": option_restaurant, "type_payment": type_payment },
					success: function (response) {
						$.ajax({
							url: "miphp/barcode.php",
							data: {"cod_order": response.cod_order, "text_qr": response.text_qr },
							success: function () {
								build_cart();
								build_costumer();
								build_extras();
								setTimeout(function(){ $.notify("Abriendo PDF", "info"); $('html,body').scrollTop(0); }, 3000);
								if(isMobile.mobilecheck()){
									window.location.href = '<?php echo WP_PLUGIN_URL; ?>'+'/iby/miphp/print_recibo.php?cod_order='+response.cod_order;
								}else{
									window.open('<?php echo WP_PLUGIN_URL; ?>'+'/iby/miphp/print_recibo.php?cod_order='+response.cod_order, '_blank', 'location=yes,height=600,width=400,scrollbars=yes,status=yes');
								}
							}
						});
					
					}
				});
			} else {
				$.ajax({
					url: "miphp/orders.php",
					data: {"cod_customer": id_customer, "cod_box": cod_box, "entregado": entregado, "cambio": cambio, "tipo_venta": tipo_venta, "option_restaurant": option_restaurant, "type_payment": type_payment },
					success: function () {
						build_cart();
						build_costumer();
						build_extras();
						$.notify("Venta Tipo Recibo Sin Imprimir, Realizada Correctamente..", "info");
					}
				});
			}
		} else {
			if (opciones_print) {
				$.ajax({
					url: "miphp/orders.php",
					dataType: "json",
					data: {"cod_customer": id_customer, "cod_box": cod_box, "entregado": entregado, "cambio": cambio, "tipo_venta": tipo_venta, "option_restaurant": option_restaurant, "type_payment": type_payment },
					success: function (response) {
						// $.notify("Creando QR..", "info");
						$.ajax({
							url: "miphp/barcode.php",
							data: {"cod_order": response.cod_order, "text_qr": response.text_qr },
							success: function () {
								build_cart();
								build_costumer();
								build_extras();
								setTimeout(function(){ $.notify("Abriendo PDF", "info"); $('html,body').scrollTop(0); }, 3000);
								if(isMobile.mobilecheck()){
									window.location.href = '<?php echo WP_PLUGIN_URL; ?>'+'/iby/miphp/print_factura.php?cod_order='+response.cod_order;
								}else{
									window.open('<?php echo WP_PLUGIN_URL; ?>'+'/iby/miphp/print_factura.php?cod_order='+response.cod_order, '_blank', 'location=yes,height=600,width=400,scrollbars=yes,status=yes');
								}
							}
						});
					
					}
				});
			} else {
				
				$.ajax({
					url: "miphp/orders.php",
					dataType: "json",
					data: {"cod_customer": id_customer, "cod_box": cod_box, "entregado": entregado, "cambio": cambio, "tipo_venta": tipo_venta, "option_restaurant": option_restaurant, "type_payment": type_payment },
					success: function (response) {
						$.notify("Creando QR..", "info");
						$.ajax({
							url: "miphp/barcode.php",
							data: {"cod_order": response.cod_order, "text_qr": response.text_qr },
							success: function () {
								build_cart();
								build_costumer();
								build_extras();
								$.notify("Venta Realizada sin Imprecion..", "info");
							}
						});
					}
				});
			}
		}
	}

	// box publish-------------------------------------------
	function box_publish(){
		$.ajax({
			url: "miphp/boxs.php",
			dataType: "json",
			data : {"box_id": '<?php echo $_GET["box_id"]; ?>', "nota_apertura": $("#nota_apertura").val(), "monto_inicial": $("#monto_inicial").val() },
			success: function (response) {
				$.notify(response.message, "info");
				$('#modalBox').modal('toggle');
				location.reload();
			}
		});
	}

	// add cant product -------------------------------------------
	function update_sum(product_id){
	$('#mitabla').html("<center><img class='img-sm' src='resources/reload.gif'></center>");	
		$.ajax({
			url: "miphp/micart.php",
			dataType: "json",
			data: {"update_sum": product_id},
			success: function (response) {
				$.notify(response.message, "info");
				build_cart();
			}
		});
	}
	function update_rest(product_id){
		$('#mitabla').html("<center><img class='img-sm' src='resources/reload.gif'></center>");	
		$.ajax({
			url: "miphp/micart.php",
			dataType: "json",
			data: {"update_rest": product_id},
			success: function (response) {
				$.notify(response.message, "info");
				build_cart();
			}
		});
	}
	// -------------------  Add product ---------------------------------------------
	function product_add (product_id){
		$('#milistsearch').html("");
		var stock = prompt("Cantidad a Ingresar", 1);
		if (stock) {
			$.ajax({
				url: "miphp/micart.php",
				dataType: "json",
				data: {"add": product_id, "stock": stock },
				success: function (response) {
					$.notify(response.message, "info");	
					build_cart();
				}
			});
		}
	}
	// -------------  REMOVE ITEM ---------------------------------------------------------
	function remove(product_id){
		console.log(product_id);
		$.ajax({
			url: "miphp/micart.php",
			dataType: "json",
			data: {"remove": product_id },
			success: function (response) {
				$.notify(response.message, "info");
				build_cart();
				build_extras();
			}
		});
	}


	function clear_search_products(){
		$('#milistsearch').html("<img src='resources/reload.gif'>");	
		$('#milistsearch').html("");
		$("#criterio_id").focus();

	}
	// EXTRAS ----------------------------------------------------------------------------
	function build_extras(){
		for (let index = 1; index < 10; index++) {
			$('#'+index).prop("checked", false);
			$('#'+index).attr("disabled", false);
		}
			
		$.ajax({
				url: "miphp/micart.php",
				dataType: "json",
				success: function (response) {
					for(var i=0; i < response.length; i++){
						if(response[i].sku == 'extra'){
							$('#'+response[i].id).prop("checked", true);
							$('#'+response[i].id).attr("disabled", true);	
						}
					}
				}
			});
				
	}
	// building cart list ----------------------------------------------------------------------------
	function build_cart(){
		$('#mitabla').html("<center><img class='img-sm' src='resources/reload.gif'></center>");	
		get_totals();
		$.ajax({
			url: "miphp/micart.php",
			dataType: "json",
			success: function (response) {
				if (response.length == 0) {
					$('#mitabla').html("<center><h6>Carrito Vacio</h6><img class='img-md' src='resources/car.png' accept='.png'></center>");						
					$('#miextra').prop("disabled", true);

					$('#btn_pago_efectivo').prop("disabled", true);
					// $('#btn_pago_delivery').prop("disabled", true);
					$('#btn_pago_tigo_money').prop("disabled", true);
					$('#btn_pago_qr_simple').prop("disabled", true);
					$('#btn_pago_transferencia').prop("disabled", true);
					$('#btn_pago_tarjeta_cd').prop("disabled", true);

					$('#btn_proforma').prop("disabled", true);
					$('#btn_compra').prop("disabled", true);
				} else {
					let table = "";
					table += "<table style='width: 100%;'><thead class='text-muted'><tr class='small text-uppercase'><th scope='col'>Productos</th><th scope='col' class='text-center'>Cantidad</th><th scope='col' class='text-center'>Sub Total</th></tr></thead>";
					for(var i=0; i < response.length; i++){
						if (response[i].sku == 'extra') {
							table += "<tr><td><figure class='itemside'><div class='aside'><img src="+response[i].image+
							" class='img-sm'></div><figcaption class='info'><h6>"+response[i].name+
							"</h6><p class='text-muted small'>  Precio Venta: "+response[i].price+
							"<br> ID: "+response[i].id+"<br> SKU: "+response[i].sku+"</p></figcaption></figure></td>"+
							"<td class='text-center'><p>EXTRA</p></td>"+
							"<td class='text-center'><div class='price-wrap'><var class='price h5'>"+response[i].price * response[i].quantity+"</var></div><div class='btn-group' role='group'><button onclick='remove("+response[i].id+")' type='button' class='btn btn-sm btn-warning'><i class='fa fa-trash'></button></div></td></tr>";
						} else {
						table += "<tr><td><figure class='itemside'><div class='aside'><img src="+response[i].image+
							" class='img-sm'></div><figcaption class='info'><h6>"+response[i].name+
							"</h6><p class='text-muted small'>  Precio Venta: "+response[i].price+
							"<br> ID: "+response[i].id+"<br> SKU: "+response[i].sku+"</p></figcaption></figure></td>"+
							"<td class='text-center'><div class='btn-group' role='group'><button onclick='update_rest("+response[i].id+")' type='button' class='btn btn-sm btn-light'>-</button><h5> "+response[i].quantity+" </h5><button onclick='update_sum("+response[i].id+")' type='button' class='btn btn-sm btn-light'>+</button></div></td>"+
							"<td class='text-center'><div class='price-wrap'><var class='price h5'>"+response[i].price * response[i].quantity+"</var></div><div class='btn-group' role='group'><button onclick='remove("+response[i].id+")' type='button' class='btn btn-sm btn-warning'><i class='fa fa-trash'></button></div></td></tr>";
						}
					}	
					table += "</tbody></table>";
					table += "<div class='card-body border-top'><button onclick='cart_clear()' class='btn btn-light btn-sm'>Limpiar Carrito</button></div>";
					
					$('#mitabla').html(table);
					
					$('#miextra').prop("disabled", false);

					$('#btn_pago_efectivo').prop("disabled", false);
					// $('#btn_pago_delivery').prop("disabled", false);
					$('#btn_pago_tigo_money').prop("disabled", false);
					$('#btn_pago_qr_simple').prop("disabled", false);
					$('#btn_pago_transferencia').prop("disabled", false);
					$('#btn_pago_tarjeta_cd').prop("disabled", false);

					$('#btn_proforma').prop("disabled", false);
					$('#btn_compra').prop("disabled", false);
					
				}
			}
		});
		// $("#criterio_id").focus();
	}
	// -------------- GET TOTALS -------------------------------------------------------------
	function get_totals(){
		$.ajax({
			url: "miphp/micart.php",
			dataType: "json",
			data: {"get_totals": true },
			success: function (response) {
				$('#total_numeral').html("<strong>"+response.total_numeral+"</strong>");
				$('#total_literal').html("<samll>"+response.total_literal+"</samll>");
				$('#cant_items').html("<strong>"+response.cant_items+"</strong>");
			}
		});
				
	}
	// -----------------  Clear Cart -----------------------------------------------------
	function cart_clear(){
		
		$.ajax({
			url: "miphp/micart.php",
			dataType: "json",
			data: {"clear": true },
			success: function (response) {
				$.notify(response.message, "info");
				build_cart();
				build_extras();
			}
		});
	}
	// --------------------------  add custumer ----------------------------------------------------------
	function customer_add (customer_id){
		$('#list_search_customers').html("<center><img class='img-sm' src='resources/reload.gif'></center>");	
			$.ajax({
				url: "miphp/search.php",
				dataType: "json",
				data: {"get_customer_id": customer_id },
				success: function (response) {
					let  customer = "<ul class='list-group list-group-flush'>";
						customer += "<li class='list-group-item'><span>Cliente: </span><small>"+response[0].billing_first_name+"  "+response[0].billing_last_name+"</small></li>";
						customer += "<li class='list-group-item'><span>NIT O Carnet: </span><small>"+response[0].billing_postcode+"</small></li>";
						customer += "<li class='list-group-item'><span>Correo: </span><small>"+response[0].user_email+"</small></li>";
						customer += "<li class='list-group-item'><span>Telefono: </span><small>"+response[0].billing_phone+"</small></li>";
						customer += "</ul>";
					$('#list_search_customers').html(customer);	
					$("#id_customer").val(response[0].id);
				}
			});
	}
	// ----------------  SET CUSTUMER ------------------------------------------------------
	function build_costumer(){
		$('#list_search_customers').html("<center><img class='img-sm' src='resources/reload.gif'></center>");	
		$.ajax({
			url: "miphp/search.php",
			dataType: "json",
			data: {"get_customers": "cliente.generico@gmail.com" },
			success: function (response) {
				let  customer = "<ul class='list-group list-group-flush'>";
					customer += "<li class='list-group-item'><span>Cliente: </span><small>"+response[0].billing_first_name+"  "+response[0].billing_last_name+"</small></li>";
					customer += "<li class='list-group-item'><span>NIT O Carnet: </span><small>"+response[0].billing_postcode+"</small></li>";
					customer += "<li class='list-group-item'><span>Correo: </span><small>"+response[0].user_email+"</small></li>";
					customer += "<li class='list-group-item'><span>Telefono: </span><small>"+response[0].billing_phone+"</small></li>";
					customer += "</ul>";
				$('#list_search_customers').html(customer);	
				$("#id_customer").val(response[0].id);
			}
		});
	}

	function customer_create(){
		$.ajax({
			url: "miphp/modal_customer.php",
			dataType: 'html',
			contentType: 'text/html',
			success: function (response) {
				$('#box_body').html(response);	
				$("#modalBox").modal('show');
			}
		});
	}
	function customer_store(){
		let user_email = $("#user_email").val();
		let first_name = $("#first_name").val();
		let last_name = $("#last_name").val();
		let billing_phone = $("#billing_phone").val();
		let billing_postcode = $("#billing_postcode").val();
		let user_login =first_name+'.'+last_name;
		$.ajax({
			url: "miphp/customer.php",
			dataType: "json",
			data: {
				"customer_store": true, 
				"user_email":  user_email, 
				"user_login":  user_login, 
				"first_name":  first_name, 
				"last_name":  last_name, 
				"billing_phone":  billing_phone, 
				"billing_postcode":  billing_postcode },
			success: function (response) {
				$.ajax({
					url: "miphp/search.php",
					dataType: "json",
					data: {"get_customers": user_email },
					success: function (response) {
						let  customer = "<ul class='list-group list-group-flush'>";
							customer += "<li class='list-group-item'><span>Cliente: </span><small>"+response[0].billing_first_name+"  "+response[0].billing_last_name+"</small></li>";
							customer += "<li class='list-group-item'><span>NIT O Carnet: </span><small>"+response[0].billing_postcode+"</small></li>";
							customer += "<li class='list-group-item'><span>Correo: </span><small>"+response[0].user_email+"</small></li>";
							customer += "<li class='list-group-item'><span>Telefono: </span><small>"+response[0].billing_phone+"</small></li>";
							customer += "</ul>";
						$('#list_search_customers').html(customer);	
						$("#id_customer").val(response[0].id);
					}
				});
				$.notify(response.message, "info");
				// console.log(user_email);
				$('#modalBox').modal('toggle');
			}
		});
	}
//----  load JQUERY --------------------
$(document).ready(function() {
	let isMobile = {
		mobilecheck : function() {
			return (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino|android|ipad|playbook|silk/i.test(navigator.userAgent||navigator.vendor||window.opera)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test((navigator.userAgent||navigator.vendor||window.opera).substr(0,4)))
		}
	}
	// alert(isMobile.mobilecheck());

	$('#milistcatgs').html("<center><img class='img-sm' src='resources/reload.gif'></center>");	
	$.ajax({
		url: "miphp/catalogo.php",
		dataType: 'html',
		contentType: 'text/html',
		success: function (response) {
			$('#milistcatgs').html(response);	
		}
	});
	// show box -------------------------------------------------------
	// $("#customer_create").click(function (e) { 
		// e.preventDefault();		
		
	// });


	// show box -------------------------------------------------------
	$("#box_show").click(function (e) { 
		e.preventDefault();		
		$.ajax({
			url: "miphp/modal_details.php",
			dataType: 'html',
			contentType: 'text/html',
			data: {"box_id": box_id },
			success: function (response) {
				$('#box_body').html(response);	
				$("#modalBox").modal('show');
			}
		});
	});



	// // Open cash---------------------------------------------------- 
	// $("#btn_pago_efectivo").click(function (e) { 
	// 	e.preventDefault();
	// 	let total = 0;
	// 	$.ajax({
	// 		url: "miphp/micart.php",
	// 		dataType: "json",
	// 		data: { "get_totals": true },
	// 		success: function (response) {
	// 			total = response.total_numeral;	
	// 			$.ajax({
	// 				url: "miphp/modal_efectivo.php",
	// 				dataType: 'html',
	// 				contentType: 'text/html',
	// 				data: {"box_id": box_id, "total" : total },
	// 				success: function (response) {
	// 					$('#box_body').html(response);	
	// 					$('#modalBox').modal('show');
	// 					$("#entregado").focus();
	// 				}
	// 			});
	// 		}
	// 	});
	// });
	// Open cash---------------------------------------------------- 
	$("#btn_pago_delivery").click(function (e) { 
		e.preventDefault();
		// let total = 0;
		// $.ajax({
		// 	url: "miphp/micart.php",
		// 	dataType: "json",
		// 	data: { "get_totals": true },
		// 	success: function (response) {
		// 		total = response.total_numeral;	
		// 		$.ajax({
		// 			url: "miphp/modal_efectivo.php",
		// 			dataType: 'html',
		// 			contentType: 'text/html',
		// 			data: {"box_id": box_id, "total" : total },
		// 			success: function (response) {
		// 				$('#box_body').html(response);	
		// 				$('#modalBox').modal('show');
		// 				$("#entregado").focus();
		// 			}
		// 		});
		// 	}
		// });
	});
	//--- Cargando Caja ---------------------------------------------------------
	// $("#criterio_id").focus();
	let status_box = "<?php echo $post->post_status;  ?>";
	let box_id = "<?php echo $post->ID;  ?>";
	if (status_box == 'pending') {
		$("#modalBox").modal('show');
		$.ajax({
			url: "miphp/moda_open_box.php",
			dataType: 'html',
			contentType: 'text/html',
			success: function (response) {
				$('#box_body').html(response);	

			}
		});
	} else if(status_box == 'publish') {
		// $("#modalBox").modal('show');
		// $.ajax({
		// 	url: "miphp/modal_details.php",
		// 	dataType: 'html',
		// 	contentType: 'text/html',
		// 	data: {"box_id": box_id },
		// 	success: function (response) {
		// 		$('#box_body').html(response);	
		// 	}
		// });
	}else{ 

	}
	build_cart();
	build_costumer();
	build_extras();

	// searchs products --------------------------------------------------------------
	$("#criterio_id").on('keyup', function (e) {
		if (e.key === 'Enter' || e.keyCode === 13) {
			$('#milistsearch').html("<center><img class='img-sm' src='resources/reload.gif'></center>");	
			$.ajax({
				url: "miphp/search.php",
				dataType: "json",
				data: { "get_products": $("#criterio_id").val() },
				success: function (response) {
					if (response.length == 0) {
						$('#milistsearch').html("<p>Sin Resultados  <a href='<?php echo get_site_url(); ?>/wp-admin/post-new.php?post_type=product' target='_blank' class='btn btn-sm btn-primary'>Crear Nuevo</a></p>");	
					} else {
						
						let table = "";
						
						
						table += "<table class='table'><tbody>";
						for(var i=0; i< response.length; i++){
							var userObjList = JSON.parse(response[i].brands);
							let roleList = '';
							if (userObjList.length > 0) {								
								userObjList.forEach(userObj => {
									roleList += userObj.name+', ';
								});
							}
							
							var userObjList2 = JSON.parse(response[i].cats);
							let roleList2 = '';
							if (userObjList2.length > 0) {
								userObjList2.forEach(userObj => {
									roleList2 += userObj.name+', ';
								});
							}
							var userObjList3 = JSON.parse(response[i].tags);
							let roleList3 = '';
							if (userObjList3.length > 0) {
								userObjList3.forEach(userObj => {
									roleList3 += userObj.name+', ';
								});
							}
							let img = response[i].image ? response[i].image : 'resources/default_product.png';
							table += "<tr><td><figure class='itemside'><div class='aside'><img src="+img+
								" class='img-sm'></div><figcaption class='info'><h6>"+response[i].name+
								"</h6><p class='text-muted small'>  Precio Venta: "+response[i].regular_price+
								"<p class='text-muted small'>  Stock: "+response[i].stock_quantity+
								"<br> ID: "+response[i].id+"<br> SKU: "+response[i].sku+"<br> MARCAS: "+roleList+"<br> CATEGORIAS: "+roleList2+"</p></figcaption></figure></td>"+
								"<td><strong>Detalles</strong><br><small>Precio Compra: "+response[i].bought_price+"<br> Estante: "+response[i].lg_estante+"<br> Bloque: "+response[i].lg_bloque+"<br> Vence: "+response[i].lg_date+"</small><br> Etiquetas: "+roleList3+"<br></td>"+
								"<td><button onclick='product_add("+response[i].id+")' type='button' class='btn btn-sm btn-primary'><i class='fa fa-shopping-cart'></i></button></td></tr>";
						}	
						table += "</tbody></table>";
						table += "<p> "+response.length+" resultados para: '"+$("#criterio_id").val()+"' <a href='#' onclick='clear_search_products()' class='btn btn-sm btn-light' id='clear_search_products'>Borrar</a></p>";
						$('#milistsearch').html(table);	

					}		
				}
			});
		}
	});
	
	// searchs customer --------------------------------------------------------------
	$("#customer_search").on('keyup', function (e) {
		if (e.key === 'Enter' || e.keyCode === 13) {
			$('#list_search_customers').html("<center><img class='img-sm' src='resources/reload.gif'></center>");	
			let criterio = $("#customer_search").val();
			$.ajax({
				url: "miphp/search.php",
				dataType: "json",
				data: { "get_customers": criterio },
				success: function (response) {
					if (response.length == 0) {
                        
						$('#list_search_customers').html("<p>Sin Resultados  <button class='btn btn-light' onclick='customer_create()' type='button'> Crear Nuevo </button> </p>");	
					} else {
						let table = "";
						table += "<table class='table' style='overflow:auto; border-collapse: collapse; table-layout:fixed;'><tbody>";
						for(var i=0; i< response.length; i++){
							table += "<tr><td><small>"+response[i].billing_postcode+"</small></td><td><small>"+response[i].billing_first_name+"</small></td><td><small>"+response[i].billing_last_name+"</small></td><td><button onclick='customer_add("+response[i].id+")' type='button' class='btn btn-sm btn-primary'><i class='fa fa-save'></i></button></td></tr>";
						}	
						table += "</tbody></table>";
						table += "<p>"+response.length+" Resultados </p>";
						$('#list_search_customers').html(table);	
					}		
				}
			});
		}
	});

	$("#criterio_id").change(function (e) { 
		e.preventDefault();
		
		if ($("#criterio_id").empty()) {
			$('#milistsearch').html("");
		}
	});
	
}); 
</script>
</body>
</html>

