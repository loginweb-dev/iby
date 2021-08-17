<?php 
require_once('../../../wp-load.php');

    $product = get_product(20067);
    $stock = $product->get_stock_quantity();
    echo $stock;
?>