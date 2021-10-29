<?php 
    require_once('../../../../wp-load.php');
    $orders = wc_get_orders(array('limit' => 100, 'orderby' => 'date'));
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
          <th scope="col">Productos</th>
          <th scope="col">Total</th>
        </tr>
      </thead>
      <tbody>
        <?php $tv = 0; $iter=0; foreach ($orders as $key) { $order = wc_get_order($key->ID); $data = $order->get_data(); if (get_post_meta( $key->ID, 'lw_accounting', true )  == 'no' && get_post_meta( $key->ID, 'wc_pos_register_id', true )  == $_GET["box_id"]  ) { ?>
          <tr>
            <td>
              #<?php $iter++; echo $iter; ?> - <a href="<?php echo admin_url('post.php?post='.$order->get_id().'&action=edit'); ?>"> <?php echo $order->get_id(); ?></a> 
              <br> 
              <?php echo $order->get_date_created()->date('Y-m-d H:i:s') ?>
              <br>
              <?php echo get_post_meta( $key->ID, 'lw_pos_type_order', true ); ?>
            </=>
            <td>
              <small><?php echo get_post_meta( $key->ID, '_billing_email', true ); ?></small>
              <br>
              <?php $items = $order->get_items(); foreach ( $items as $item ) { $extra = $item->get_meta_data(); $product = $item->get_product(); ?>
                <small>
                  <a href="<?php echo admin_url('post.php?post='.$item['product_id'].'&action=edit'); ?>"><?php echo $item['name']; ?></a>
                </small>
                <br>
                <?php for ($i=0; $i < count($extra); $i++) { ?>
                  <?php if ($extra[$i]->key == '_wc_cog_item_cost' || $extra[$i]->key == '_wc_cog_item_total_cost' ) { ?>
                    
                    <?php }else{ ?> 
                      <small><?php echo $extra[$i]->key.': '.$extra[$i]->value; ?></small><br>
                  <?php } ?> 
                <?php } ?> 
              <?php } ?>
              
            </td>
            <td>
              <?php echo $order->get_total(); $tv= $tv +  $order->get_total() ?>
              <br>
			        <button onclick="re_imprimir('<?php echo $order->get_id(); ?>', '<?php echo get_post_meta( $key->ID, 'lw_pos_type_order', true ); ?>')" type="button" class="btn btn-primary btn-sm"> Imprimir </button>
            </td>
          </tr>

        <?php } } ?>
      </tbody>
    </table>
  </div>
  <div class="modal-footer">
          <label for="">Total Bs.<?php echo $tv; ?></label>
	</div>