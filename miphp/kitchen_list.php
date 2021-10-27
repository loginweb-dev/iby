<?php 
    require_once('../../../../wp-load.php');
  
    $setting = get_posts( array('post_status' => 'publish', 'post_type' => 'pos_lw_setting') );

    ?>
    <?php $index = 0; foreach( $categories as $category ){ ?>
        <?php 
            $args = array(
                'orderby' => 'date',
                'category'  =>  $category->name,
                'order' => 'DESC',
                'status' => 'publish'
            );
            $products = wc_get_products($args);
            // print_r($_GET["json"]);
        ?>
        
            <?php if ($category->name == get_post_meta($setting[0]->ID, 'lw_cat_default', true) ) {?>
                <div class="list-group">
                    <article class="list-group-item">
                        <header class="filter-header">
                            <a href="#" data-toggle="collapse" data-target="#micollapse" aria-expanded="true" class="">
                                <i class="icon-control fa fa-chevron-down"></i>
                                <h6 class="title"><?php echo $category->name ?></h6>
                            </a>
                        </header>
                        <div class="filter-content collapse show" id="micollapse" style="">			
                            <div class="card">
                                <div class="row">
                                    <?php foreach ($products as $key) { ?>
                                        <?php $item = wc_get_product( $key->get_id() ); if ($item->get_type() == "variable") { ?>
                                            <?php foreach ($key->get_available_variations() as $variation) { $var = wc_get_product($variation['variation_id']); ?>
                                                <div class="col-lg-4 col-sm-12 col-md-6">
                                                    <figure class="itemside">
                                                        <div class="aside"><img src="<?php echo get_the_post_thumbnail_url($key->id) ? get_the_post_thumbnail_url($key->id) : 'resources/default_product.png'; ?>" class="border img-sm"></div>
                                                        <figcaption class="info align-self-center">
                                                            <p><small><?php echo $var->name ?></small></p>
                                                            <p><?php echo $var->regular_price ?> Bs.</p>
                                                            <a href="#" onclick="product_add(<?php echo $variation['variation_id']; ?>)" class="btn btn-light text-primary btn-sm"> Agregar </a>
                                                        </figcaption>
                                                    </figure>
                                                </div>
                                            <?php } ?>
                                        <?php }else{ ?>
                                            <div class="col-lg-4 col-sm-12 col-md-6">
                                                    <figure class="itemside">
                                                        <div class="aside"><img src="<?php echo get_the_post_thumbnail_url($key->id) ? get_the_post_thumbnail_url($key->id) : 'resources/default_product.png'; ?>" class="border img-sm"></div>
                                                        <figcaption class="info align-self-center">
                                                            <p><small><?php echo $key->name ?></small></p>
                                                            <p><?php echo $key->regular_price ?> Bs.</p>
                                                            <a href="#" onclick="product_add(<?php echo $key->id ?>)" class="btn btn-light text-primary btn-sm"> Agregar </a>
                                                        </figcaption>
                                                    </figure>
                                                </div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div> 
                        </div>
                    </article>
            <?php } else{ ?>
                <article class="list-group-item">
                    <header class="filter-header">
                        <a href="#" data-toggle="collapse" data-target="#<?php echo 'collapse'.$index; ?>" class="collapsed" aria-expanded="false">
                            <i class="icon-control fa fa-chevron-down"></i>
                            <h6 class="title"><?php echo $category->name ?> </h6>
                        </a>
                    </header>
                    <div class="filter-content collapse" id="<?php echo 'collapse'.$index; ?>" style="">
                    <div class="card">
                            <div class="row">
                                <?php foreach ($products as $key) { ?>
                                    <?php $item = wc_get_product( $key->get_id() ); if ($item->get_type() == "variable") { ?>
                                        <?php foreach ($key->get_available_variations() as $variation) { $var = wc_get_product($variation['variation_id']); ?>
                                                <div class="col-lg-4 col-sm-12 col-md-6">
                                                    <figure class="itemside">
                                                        <div class="aside"><img src="<?php echo get_the_post_thumbnail_url($key->id) ? get_the_post_thumbnail_url($key->id) : 'resources/default_product.png'; ?>" class="border img-sm"></div>
                                                        <figcaption class="info align-self-center">
                                                            <p><small><?php echo $var->name ?></small></p>
                                                            <p><?php echo $var->regular_price ?> Bs.</p>
                                                            <a href="#" onclick="product_add(<?php echo $variation['variation_id']; ?>)" class="btn btn-light text-primary btn-sm"> Agregar </a>
                                                        </figcaption>
                                                    </figure>
                                                </div>
                                            <?php } ?>
                                    <?php }else{ ?>
                                        <div class="col-lg-4 col-sm-12 col-md-6">
                                            <figure class="itemside">
                                                <div class="aside"><img src="<?php echo get_the_post_thumbnail_url($key->id) ? get_the_post_thumbnail_url($key->id) : 'resources/default_product.png'; ?>" class="border img-sm"></div>
                                                <figcaption class="info align-self-center">
                                                    <p><small><?php echo $key->name ?></small></p>
                                                    <p><?php echo $key->regular_price ?> Bs.</p>
                                                    <a href="#" onclick="product_add(<?php echo $key->id ?>)" class="btn btn-light text-primary btn-sm"> Agregar </a>
                                                </figcaption>
                                            </figure>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div> 
                    </div>
                </article> 
            <?php $index++; } ?>
        
    <?php } ?>
            </div>
           
    <?php
?>