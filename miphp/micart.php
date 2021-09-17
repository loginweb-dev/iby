<?php 

    require_once('../../../../wp-load.php');

    // Include core Cart library ------------------------------------------
    require_once 'class.Cart.php';
    $cart = new Cart([
        'cartMaxItem'      => 0,
        'itemMaxQuantity'  => 99,
        'useCookie'        => false,
    ]);

    require 'NumeroALetras.php';
    use Luecano\NumeroALetras\NumeroALetras;
    $formatter = new NumeroALetras();

    //--------------------------------------------------
    if ($_GET["add"]) {
        
        $item = wc_get_product( $_GET["add"] );
        if (get_post_meta($_GET["add"], "_manage_stock", true) == "no") {
            $cart->add(bin2hex(random_bytes(18)), $_GET["stock"], [
                "product_id" => $_GET["add"],
                "order" => count($cart->getItems()) + 1,
                "name" => $item->name,
                "description" => $item->description, 
                "price" => $item->price,  
                "sku" => $item->sku, 
                "image" => get_the_post_thumbnail_url($item->id)
            ]);         
            echo json_encode(array("message" => "Producto Agredado Correctamente."));   
        } else {
            if ($_GET["stock"] > $item->get_stock_quantity()) {
                # code...
                echo json_encode(array("message" => "La cantidad solicitada supera el STOCK."));
            } else {
                # code...
                $cart->add(bin2hex(random_bytes(18)), $_GET["stock"], [
                    "product_id" => $_GET["add"],
                    "order" => count($cart->getItems()) + 1,
                    "name" => $item->name,
                    "description" => $item->description, 
                    "price" => $item->price,  
                    "sku" => $item->sku, 
                    "image" => get_the_post_thumbnail_url($item->id)
                ]);
                echo json_encode(array("message" => "Producto Agredado Correctamente."));
            }
        }
        
       
    } elseif ($_GET["extra"]){
        $mistock = $_GET["quantity"] ? $_GET["quantity"] : 1;
        $cart->add(bin2hex(random_bytes(18)), $mistock, [
            "product_id" => $_GET["id"],
            "order" => count($cart->getItems()) + 1,
            "name" => $_GET["title"],
            "description" => "", 
            "price" => $_GET["price"],  
            "sku" => "extra", 
            "image" => "resources/extra.png"
        ]);
        echo json_encode(array("message" => "Extra registrado correctamente.."));
       
    } elseif ($_GET["linea"]){
        $cart->add(bin2hex(random_bytes(18)), $mistock, [
            "product_id" => 0,
            "order" => count($cart->getItems()) + 1,
            "name" => "Linea",
            "description" => "", 
            "price" => 0,  
            "sku" => "linea", 
            "image" => "resources/extra.png"
        ]);
        echo json_encode(array("message" => "Linea registrado correctamente.."));

    } elseif ($_GET["descuento"]){
        $post = get_post( $_GET["cupon_id"] );
        $cart->add(bin2hex(random_bytes(18)), 1, [
            "product_id" => $_GET["cupon_id"],
            "order" => count($cart->getItems()) + 1,
            "name" => "Cupon",
            "description" => $post->post_content, 
            "price" => get_post_meta($post->ID, 'coupon_amount', true) * -1,  
            "sku" => "descuento", 
            "image" => "resources/descuento.png"
        ]);
        echo json_encode(array("message" => "Descuento Aplicado correctamente.."));
    } elseif ($_GET["clear"]){
        $cart->clear();
        echo json_encode(array("message" => "Carrito Vacio."));
    } elseif ($_GET["remove"]){
        $theItem = $cart->getItem($_GET["remove"]);
        $cart->remove($theItem['id'], [
            "product_id" => $theItem['attributes']['product_id'],
            "order" => $theItem['attributes']['order'],
            "name" => $theItem['attributes']['name'],
            "description" => $theItem['attributes']['description'], 
            "price" => $theItem['attributes']['price'], 
            "sku" => $theItem['attributes']['sku'], 
            "image" => $theItem['attributes']['image']
          ]);
          echo json_encode(array("message" => "Producto Eliminado.."));
    } elseif ($_GET["update_sum"]){
        $theItem = $cart->getItem(strval($_GET["update_sum"]));
        $cart->update($theItem['id'], $theItem['quantity'] + 1, [
            "product_id" => $theItem['attributes']['product_id'],
            "order" => $theItem['attributes']['order'],
            "name" => $theItem['attributes']['name'],
            "description" => $theItem['attributes']['description'], 
            "price" => $theItem['attributes']['price'], 
            "sku" => $theItem['attributes']['sku'], 
            "image" => $theItem['attributes']['image']
        ]);
        echo json_encode(array("message" => "Producto Actualizado Correctamente."));
    }
    elseif ($_GET["update_rest"]){
        $theItem = $cart->getItem($_GET["update_rest"]);
        $cart->update($theItem['id'], $theItem['quantity'] - 1, [
            "product_id" => $theItem['attributes']['product_id'],
            "order" => $theItem['attributes']['order'],
            "name" => $theItem['attributes']['name'],
            "description" => $theItem['attributes']['description'], 
            "price" => $theItem['attributes']['price'], 
            "sku" => $theItem['attributes']['sku'], 
            "image" => $theItem['attributes']['image']
        ]);
        echo json_encode(array("message" => "Cantidad Reducida.."));
    }elseif ($_GET["get_totals"]){
        $json = array(
            "total_numeral" => $cart->getAttributeTotal('price'),
            "total_literal" => $formatter->toInvoice($cart->getAttributeTotal('price'), 2, 'BOB'), 
            "cant_items" => $cart->getTotalQuantity(),
        );
        echo json_encode($json);
    } else{
        $allItems = $cart->getItems();
        $json = array();
        $count=0;
        foreach ($allItems as $items) {
            foreach ($items as $item) {
                    array_push($json, array(
                        "id" => $item['id'],
                        "quantity" => $item['quantity'], 
                        "product_id" => $item['attributes']['product_id'],
                        "order" => $item['attributes']['order'],
                        "name" => $item['attributes']['name'],
                        "description" => $item['attributes']['description'], 
                        "price" => $item['attributes']['price'], 
                        "sku" => $item['attributes']['sku'], 
                        "image" => $item['attributes']['image'] ? $item['attributes']['image'] : 'resources/default_product.png'
                    ));
            }
        }
        foreach ($json as $key => $row) {
            $aux[$key] = $row['order'];
        }
        array_multisort($aux, SORT_ASC, $json);
        echo json_encode($json);
    }
?>