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

<!-- jQuery -->
<script src="js/jquery-2.0.0.min.js" type="text/javascript"></script>

<!-- Bootstrap4 files-->
<script src="js/bootstrap.bundle.min.js" type="text/javascript"></script>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>

<!-- Font awesome 5 -->
<link href="fonts/fontawesome/css/all.min.css" type="text/css" rel="stylesheet">

<!-- custom style -->
<link href="css/ui.css" rel="stylesheet" type="text/css"/>
<link href="css/responsive.css" rel="stylesheet" media="only screen and (max-width: 1200px)" />

</head>
<body style="background-color: #F6F7F9;">
<header class="section-header" style="background-color: #FFFFFF;">
	<section class="header-main border-bottom">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-lg-8 col-md-8 col-sm-12">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Buscar Productos" id="criterio_id">
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12">
					<div class="widgets-wrap float-md-right">
						<div class="widget-header icontext">
							<a href="#" class="icon icon-sm rounded-circle border"><i class="fa fa-address-book"></i></a>
							<div class="text">
								<span class="text-muted"><?php echo $post->post_title; ?></span>
								<input class="form-control" type="text" id="cod_box" value="<?php echo $_GET["box_id"]; ?>" hidden>
								<br><button class="btn btn-light" id="box_show">Cerrar Caja</button>
								
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

					</div>
				</div>
			</div>
		</div>
	</section>
</header>

<div id="milistsearch"></div>
<!-- <div id="milistcatgs"></div> -->

<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content padding-y">
<div class="container-fluid">

<div class="row">
	<main class="col-md-8">
		<div class="card">
			<div id="mitabla"></div>
		</div>
		<div class="card">
			<div id="milistcatgs"></div>
		</div>
	</main>
	
	<aside class="col-md-4 mt-1">
		<div class="card mb-3">
			<div class="card-body">
			<form>
				<div class="form-group">
					<label>Cliente</label>
						<input id="customer_search" type="text" class="form-control" placeholder="Buscar cliente">
						<input class="form-control" type="text" id="id_customer" hidden>
						<div id="list_search_customers"></div>
				</div>
			</form>
			</div>
		</div>
		<?php if(get_post_meta($post->ID, 'lw_or', true) == 'true'){ ?>
			<div class="card mb-3">
			<div class="card-body">
				<label for="">Opciones Restaurant</label>
				<hr>
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
				<div class="form-group">
					<strong>Extras</strong>
					<?php 
						$results = $wpdb->get_row('SELECT meta_value FROM wp_postmeta WHERE post_id = 366 AND  meta_key = "_product_addons"');
						$results = unserialize($results->meta_value);
						foreach ( $results  as $j => $fieldoption ) {
							if($fieldoption['type'] == "checkbox"){
								foreach ( $fieldoption['options'] as $i => $option ) {
									$price = $option['price'];
									$name = $option['label'];
									?>
										<div class="form-check" id="miextra" disabled>
											<input  onclick="extras(<?php echo $price; ?>, '<?php echo $name; ?>')" class="form-check-input" type="checkbox">
											<label for="my-input" class="form-check-label"> <?php echo $name; echo ' - '; echo $price; ?> Bs.</label>
										</div>
									<?php
								}
							}
						}
					?> 
				</div>
			</div> 
		</div>
		<?php } ?>

		<div class="card">
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
					<p class="text-center mb-3">
                        <button class="btn btn-light" id="btn_pago_efectivo" disabled> <i class="fa fa-money-bill-alt"></i> Efectivo</button>
					</p>
					<p class="text-center mb-3">
                        <button class="btn btn-light" data-toggle="modal" data-target="#" disabled> <i class="fa fa-qrcode"></i> Proforma </button>
					</p>
					<p class="text-center mb-3">
                        <button class="btn btn-light" id="btn_delivery" disabled> <i class="fa fa-registered"></i> Delivery </button>
					</p>
					
					<!-- <p class="text-center mb-3">
                        <button class="btn btn-light" data-toggle="modal" data-target="#" disabled> <i class="fa fa-registered"></i> Pago con Tigo Money</button>
					</p> -->
			</div> 
		</div>

	</aside> 

</div> 
</section>
<!-- ========================= SECTION CONTENT END// ========================= -->


<!-- ========================= FOOTER ========================= -->
<footer class="section-footer border-top padding-y">

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
<script src="js/script.js" type="text/javascript"></script>
<script src="js/notify.js" type="text/javascript"></script>
<script type="text/javascript">

	//Extras -----------------------------------------------------
	function extras(price, name){
		console.log(price+name);
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
	function new_shop_order(){
		$('#modalBox').modal('toggle');
		let id_customer = $("#id_customer").val();
		let cod_box = $("#cod_box").val();
		let entregado = $("#entregado").val();
		let cambio = $("#cambio").val();
		let tipo_venta = $("#no_estado").is(":checked") ? "recibo" : "factura";
		let option_restaurant = $("#em").is(":checked") ? "En Mesa" : $("#rt").is(":checked") ? "Recoger en Tienda" : $("#de").is(":checked") ? "Recoger en Tienda" : null;
		let opciones_print = $("#volver").is(":checked") ? false : true;
		if (tipo_venta == "recibo" ) {
			if (opciones_print) {
				$.ajax({
					url: "miphp/orders.php",
					dataType: "json",
					data: {"cod_customer": id_customer, "cod_box": cod_box, "entregado": entregado, "cambio": cambio, "tipo_venta": tipo_venta, "option_restaurant": option_restaurant },
					success: function (response) {
						build_cart();
						build_costumer();
						$.notify("Venta Tipo Recibo Con Impresion, Realizada Correctamente..");
						window.open('<?php echo admin_url('admin.php?print_pos_receipt=true&print_from_wc=true&order_id=') ?>'+response.cod_order+'&_wpnonce=444114a87f', '_blank', 'location=yes,height=600,width=400,scrollbars=yes,status=yes');
					}
				});
			} else {
				$.ajax({
					url: "miphp/orders.php",
					data: {"cod_customer": id_customer, "cod_box": cod_box, "entregado": entregado, "cambio": cambio, "tipo_venta": tipo_venta, "option_restaurant": option_restaurant  },
					success: function () {
						build_cart();
						build_costumer();
						$.notify("Venta Tipo Recibo Sin Imprimir, Realizada Correctamente..");
					}
				});
			}
		} else {
			if (opciones_print) {
				$.ajax({
					url: "miphp/orders.php",
					dataType: "json",
					data: {"cod_customer": id_customer, "cod_box": cod_box, "entregado": entregado, "cambio": cambio, "tipo_venta": tipo_venta, "option_restaurant": option_restaurant },
					success: function (response) {
						$.notify("Creando QR..");
						$.ajax({
							url: "miphp/barcode.php",
							data: {"cod_order": response.cod_order, "text_qr": response.text_qr },
							success: function () {
								build_cart();
								build_costumer();
							}
						});
						$.notify("Abriendo PDF..");
						window.open('<?php echo WP_PLUGIN_URL; ?>'+'/iby/miphp/print_factura.php?cod_order='+response.cod_order, '_blank', 'location=yes,height=600,width=400,scrollbars=yes,status=yes');
					}
				});
			} else {
				
				$.ajax({
					url: "miphp/orders.php",
					dataType: "json",
					data: {"cod_customer": id_customer, "cod_box": cod_box, "entregado": entregado, "cambio": cambio, "tipo_venta": tipo_venta, "option_restaurant": option_restaurant },
					success: function (response) {
						$.notify("Creando QR..");
						$.ajax({
							url: "miphp/barcode.php",
							data: {"cod_order": response.cod_order, "text_qr": response.text_qr },
							success: function () {
								build_cart();
								build_costumer();
								$.notify("Venta Realizada sin Imprecion..");
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
				$.notify(response.message);
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
				$.notify(response.message);
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
				$.notify(response.message);
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
					$.notify(response.message);
					build_cart();
				}
			});
		}
	}
	// -------------  REMOVE ITEM ---------------------------------------------------------
	function remove(product_id){
		$.ajax({
			url: "miphp/micart.php",
			dataType: "json",
			data: {"remove": product_id },
			success: function (response) {
				$.notify(response.message);
				build_cart();
			}
		});
	}


	function clear_search_products(){
		$('#milistsearch').html("<img src='resources/reload.gif'>");	
		$('#milistsearch').html("");
		$("#criterio_id").focus();
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
					$('#mitabla').html("<center><h2>Carrito Vacio</h2><img class='img-lg' src='resources/car.png' accept='.png'></center>");						
					$('#btn_pago_efectivo').prop("disabled", true);
					$('#btn_delivery').prop("disabled", true);
					$('#miextra').prop("disabled", true);
				} else {
					let table = "";
					table += "<table class='table'><thead class='text-muted'><tr class='small text-uppercase'><th scope='col'>Productos</th><th scope='col' class='text-center'>Cantidad</th><th scope='col' class='text-center'>Sub Total</th></tr></thead>";
					for(var i=0; i < response.length; i++){
						table += "<tr><td><figure class='itemside'><div class='aside'><img src="+response[i].image+
							" class='img-sm'></div><figcaption class='info'><h6>"+response[i].name+
							"</h6><p class='text-muted small'>  Precio Venta: "+response[i].price+
							"<br> ID: "+response[i].id+"<br> SKU: "+response[i].sku+"</p></figcaption></figure></td>"+
							"<td class='text-center'><div class='btn-group' role='group'><button onclick='update_rest("+response[i].id+")' type='button' class='btn btn-sm btn-light'>-</button><h5> "+response[i].quantity+" </h5><button onclick='update_sum("+response[i].id+")' type='button' class='btn btn-sm btn-light'>+</button></div></td>"+
							"<td class='text-center'><div class='price-wrap'><var class='price h5'>"+response[i].price * response[i].quantity+"</var></div><div class='btn-group' role='group'><button onclick='remove("+response[i].id+")' type='button' class='btn btn-sm btn-warning'><i class='fa fa-trash'></button></div></td></tr>";
					}	
					table += "</tbody></table>";
					table += "<div class='card-body border-top'><button onclick='cart_clear()' class='btn btn-light'>Limpiar Carrito </button></div>";
					
					$('#mitabla').html(table);
					$('#btn_pago_efectivo').prop("disabled", false);
					$('#btn_delivery').prop("disabled", false);
					$('#miextra').prop("disabled", false);
					
				}
			}
		});
		$("#criterio_id").focus();
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
				$.notify(response.message);
				build_cart();
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
				$.notify(response.message);
				// console.log(user_email);
				$('#modalBox').modal('toggle');
			}
		});
	}
	

//----  load JQUERY --------------------
$(document).ready(function() {

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



	// Obteniendo Cambio---------------------------------------------------- 
	$("#btn_pago_efectivo").click(function (e) { 
		e.preventDefault();

		$.ajax({
			url: "miphp/modal_efectivo.php",
			dataType: 'html',
			contentType: 'text/html',
			data: {"box_id": box_id },
			success: function (response) {
				$('#box_body').html(response);	
				$('#modalBox').modal('show');
			}
		});
		
		
	});
	//--- Cargando Caja ---------------------------------------------------------
	$("#criterio_id").focus();
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
							table += "<tr><td><figure class='itemside'><div class='aside'><img src="+response[i].image+
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

