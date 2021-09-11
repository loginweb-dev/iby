<?php 

    require_once('../../../../wp-load.php');
    // print_r($_GET["json"])
    $rows = $_GET["json"];
    // print_r($rows);
    // echo count($rows);
    require_once 'class.Cart.php';
    $cart = new Cart([
        'cartMaxItem'      => 0,
        'itemMaxQuantity'  => 99,
        'useCookie'        => false,
    ]);
    $allItems = $cart->getItems();
    ?>
<section class="section-content">
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <table class="table table-borderless table-shopping-cart">
                    <thead class="text-muted">
                        <tr class="small text-uppercase">
                        <th scope="col" width="350">Producto</th>
                        <th scope="col" width="120">Cant</th>
                        <th scope="col" width="120">Precio</th>
                        <!-- <th scope="col" class="text-right" width="40"> </th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php  foreach ($allItems as $items) { foreach ($items as $item) { ?>
                            <tr>
                                <td>
                                    <figure class="itemside">
                                        <div class="aside"><img src="<?php echo $item['attributes']['image'] ? $item['attributes']['image'] : 'resources/default_product.png';?>" class="img-sm"></div>
                                        <figcaption class="info">
                                            <a href="#" class="title text-dark"><?php echo $item['attributes']['name'] ?></a>
                                            <p class="text-muted small">ID: <?php echo $item['attributes']['product_id'] ?> <br> SKU: <?php echo $item['attributes']['sku'] ?></p>
                                            <p class="text-muted small">Info: <?php echo $item['attributes']['description'] ?></p>

                                        </figcaption>
                                    </figure>
                                </td>
                                <td> 
                                    <div class="input-group text-center">
                                        <!-- <div class="input-group-prepend"> -->
                                            <a href="#" onclick="update_rest('<?php echo $item['id'];  ?>')" class="btn btn-light btn-sm"> - </a>
                                        <!-- </div> -->
                                        
                                            <h4 class="m-1"> <?php echo $item['quantity'];  ?></h4>
                                     
                                        <!-- <div class="input-group-append"> -->
                                            <a href="#" onclick="update_sum('<?php echo $item['id'];  ?>')" class="btn btn-light btn-sm"> + </a>
                                        <!-- </div> -->
                                    <div>
                                        
                                    <!-- <select class="form-control">
                                        <option>1</option>
                                        <option>2</option>	
                                        <option>3</option>	
                                        <option>4</option>	
                                    </select>  -->
                                </td>
                                <td> 
                                    <div class="price-wrap"> 
                                        <var class="price"><?php echo $item['attributes']['price'] ?> Bs</var> 
                                        <!-- <small class="text-muted"> $315.20 each </small>  -->
                                        <br>
                                        <a href="#" onclick="remove('<?php echo $item['id'];  ?>')" class="btn btn-light btn-sm"> Quitar</a>
                                    </div> <!-- price-wrap .// -->
                                </td>
                                
                            </tr>


                        <?php } } ?>
                    </tbody>
                </table>
                <div class="card-body border-top">
                    <!-- <a href="#" class="btn btn-primary float-md-right" onclick='cart_clear()'> Limpiar<i class="fa fa-chevron-right"></i> </a> -->
                    <a href="#" class="btn btn-light btn-sm" onclick='cart_clear()'>  Limpiar </a>
                </div>	
            </div> 
            <!-- <div class="alert alert-success mt-3">
                <p class="icontext"><i class="icon text-success fa fa-truck"></i> Free Delivery within 1-2 weeks</p>
            </div> -->
        </div>
    </div>
</section>