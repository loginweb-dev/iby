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
    <table class="table table-res table-sm">
      <thead>
      <tr>
          <th scope="col">#</th>
          <!-- <th scope="col">Fecha</th> -->
          <!-- <th scope="col">Cliente</th> -->
          <th scope="col">Productos</th>
          <!-- <th scope="col">Pago</th>
          <th scope="col">Atendido</th> -->
          <th scope="col">Total</th>
        </tr>
      </thead>
      <tbody>
        <?php $tv = 0; foreach ($orders as $key) { $order = wc_get_order($key->ID); $data = $order->get_data(); if (get_post_meta( $key->ID, 'lw_accounting', true )  == 'no') {?>
          <tr>
            <th scope="row"><?php echo $order->get_id(); ?></th>
            <!-- <td><small><?php echo $order->get_date_created() ?></small></td> -->
            <!-- <td><small><?php echo get_post_meta( $key->ID, '_billing_email', true ); ?></small></td> -->
            <td>
              <?php $items = $order->get_items(); foreach ( $items as $item ) { $extra = $item->get_meta_data(); $product = $item->get_product(); ?>
                <small>
                  <?php echo $item['name']; ?>
                </small>
                <br>
                <?php for ($i=0; $i < count($extra); $i++) { ?>
                  <?php if ($extra[$i]->key == '_wc_cog_item_cost' || $extra[$i]->key == '_wc_cog_item_total_cost' ) { ?>
                    
                    <?php }else{ ?> 
                      <small><?php echo $extra[$i]->key.': '.$extra[$i]->value; ?></small>
                  <?php } ?> 
                <?php } ?> 
              <?php } ?>
              
            </td>
            <!-- <td><?php echo get_post_meta( $key->ID, '_payment_method_title', true ); ?></td>
            <td><?php echo get_post_meta( $key->ID, 'wc_pos_served_by_name', true ); ?></td> -->
            <td><?php echo $order->get_total(); $tv= $tv +  $order->get_total() ?></td>
          </tr>
        <?php } } ?>
      </tbody>
    </table>
  </div>
  <div class="modal-footer">
          <label for="">Total: <?php echo $tv; ?> Bs.</label>
			<!-- <button href="#" id="new_shop_order" onclick="new_shop_order('<?php echo $_GET['type_payment']; ?>')" type="button" class="btn btn-primary" > Guardar </button> -->
	</div>