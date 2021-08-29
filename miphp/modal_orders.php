<?php 
    require_once('../../../../wp-load.php');
    $orders = wc_get_orders(array('meta_query' => array('wc_pos_register_id' => $_GET["cod_box"])));
?>
  <div class="modal-header text-center">
    <h5 class="modal-title text-center" id="exampleModalLabel">Pedidos</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <table class="table table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Fecha</th>
          <th scope="col">Last</th>
          <th scope="col">Handle</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $key) { $order = wc_get_order($key->ID); $data = $order->get_data(); ?>
          <tr>
            <th scope="row"><?php echo $data['id']; echo $data['billing']['first_name']; ?></th>
            <td><?php echo $data['date_created']->date('Y-m-d H:i:s'); ?></td>
            <td><?php echo $data['billing']['first_name']; ?></td>
            <td>@mdo</td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
  <div class="modal-footer">
			<button href="#" id="new_shop_order" onclick="new_shop_order('<?php echo $_GET['type_payment']; ?>')" type="button" class="btn btn-primary" > Guardar </button>
	</div>