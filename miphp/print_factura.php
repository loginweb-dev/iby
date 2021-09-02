<?php 

    require_once('../../../../wp-load.php');
    require('pdf/fpdf.php');
    $QR_BASEDIR = dirname(__FILE__).DIRECTORY_SEPARATOR;

    require 'NumeroALetras.php';
    use Luecano\NumeroALetras\NumeroALetras;
    $formatter = new NumeroALetras();

    // get data of facturas--------------------------
    $datos_factura = get_posts( array('post_status' => 'publish', 'post_type' => 'pos_lw_setting') );

    // get order ------------------------------------
    $cod_order = $_GET["cod_order"];
    $order = wc_get_order( $cod_order );
    $items = $order->get_items();
    $data = $order->get_data();


    // creating PDF-------------------------------------------------
    $border = 0;
    $position = 1;
    $aling = 'C';
    $higth = 4;
    $size_font = 10;
    $type_font = 'Arial';
    $higth_qr = 105;

    $pdf = new FPDF('P','mm',array(80,190));
    $pdf->SetMargins(1, 8, 1, 1);
    $pdf->SetFont($type_font, '', $size_font);
    $pdf->AddPage();
    // echo $datos_factura[0]->ID;
        // Encabezado------------------------------------------
        $pdf->Image(get_post_meta($datos_factura[0]->ID, 'lw_image', true),30,0,20,20,'JPG');
        $pdf->Ln(14);
        $pdf->Cell(0, $higth, 'De: '.get_post_meta($datos_factura[0]->ID, 'lw_name_business', true), $border, $position, $aling);
        $pdf->Cell(0, $higth, get_post_meta($datos_factura[0]->ID, 'lw_direction', true), $border, $position, $aling);
        $pdf->Cell(0, $higth, 'Cel: '.get_post_meta($datos_factura[0]->ID, 'lw_movil', true), $border, $position, $aling);
        $pdf->Cell(0, $higth, get_post_meta($datos_factura[0]->ID, 'lw_city', true), $border, $position, $aling);
        $pdf->SetFont($type_font, '', $size_font - 2);
        $pdf->MultiCell(0, $higth, get_post_meta($datos_factura[0]->ID, 'lw_activity', true), $border, $aling);
    $pdf->Cell(0, 0, '', 1 , 1, 'C');
        // datos de factura------------------------------------------
        $pdf->SetFont($type_font, '', $size_font);
        $pdf->Cell(0, $higth, 'FACTURA', $border , $position, $aling);
        $pdf->SetFont($type_font, '', $size_font -1);
        $pdf->Cell(0, $higth, 'NIT: '.get_post_meta($datos_factura[0]->ID, 'lw_nit', true), $border , $position, $aling);
        $pdf->Cell(0, $higth, 'AUTORIZACION: '.$order->get_meta('lw_dosification_autoritation'), $border , $position, $aling);
        $pdf->Cell(0, $higth, 'FACTURA Nro: '.$order->get_meta('lw_number_factura'), $border , $position, $aling);
        $pdf->Cell(0, $higth, 'FECHA: '.$data['date_created']->date('Y-m-d H:i:s'), $border , $position, $aling);
    $pdf->Cell(0, 0, '', 1 , 1, 'C');
        //Cliente ------------------------------------------------------
        $pdf->SetFont($type_font, '', $size_font);  
        $pdf->Cell(0, $higth, 'CLIENTE', $border , $position, $aling);
        $pdf->SetFont($type_font, '', $size_font -1);
        $pdf->Cell(0, $higth, 'RAZON SOCIAL: '.$order->get_meta('lw_name_customer'), $border , $position, $aling);
        $pdf->Cell(0, $higth, 'NIT/CI: '.$order->get_meta('lw_nit_customer'), $border , $position, $aling);
        
    $pdf->Cell(0, 0, '', 1 , 1, 'C');
        //Detalle de la Venta ------------------------------------------------------
        $pdf->SetFont($type_font, '', $size_font);  
        $pdf->Cell(0, $higth, 'DETALLE DE COMPRA:', 0 , 1, 'L');
        $pdf->SetFont($type_font, '', $size_font-2);  
        $pdf->Cell(50, $higth, 'PRODUCTO', 0);
        $pdf->Cell(10, $higth, 'CANT', 0);
        $pdf->Cell(10, $higth, 'IMP', 0, 1, 'C');
        foreach ( $items as $item ) {
            $pdf->Cell(50, $higth, $item['name'], 0);
            $pdf->Cell(10, $higth, $item['quantity'], 0);
            $pdf->Cell(10, $higth, $item['subtotal'], 0, 1, 'C');
            $higth_qr += 4;
        }
    $pdf->Cell(0, 0, '', 1 , 1, 'C');
        // Total de la Venta---------------------------------------------
        $pdf->Cell(30, $higth, '', 0);
        $pdf->Cell(30, $higth, 'SUB TOTAL: ', 0);
        $pdf->Cell(10, $higth, $order->get_subtotal(), 0, 1, 'C');
        $pdf->Cell(30, $higth, '', 0);
        $pdf->Cell(30, $higth, 'DESCUENTO: ', 0);
        $pdf->Cell(10, $higth, $order->get_discount_total(), 0, 1, 'C');
        $pdf->Cell(30, $higth, '', 0);
        $pdf->Cell(30, $higth, 'TOTAL: ', 0);
        $pdf->Cell(10, $higth, $order->get_total(), 0, 1, 'C');

        $pdf->MultiCell(0, $higth, $formatter->toInvoice($order->get_total(), 2, 'BOLIVIANOS'), 0, 1);

    $pdf->Cell(0, 0, '', 1 , 1, 'C');
        // datos QR y dosificacion-------------------------------
        $pdf->Cell(50, $higth, 'FECHA LIMITE DE EMISION: ', 0);
        $pdf->Cell(20, $higth, $order->get_meta('lw_dosification_date_limit'), 0);
        $pdf->Ln();
        $pdf->Cell(50, $higth, 'CODIGO DE CONTROL: ', 0);
        $pdf->Cell(20, $higth, $order->get_meta('lw_codigo_control'), 0);
        
        $pdf->Image($QR_BASEDIR.'qrcode/temp/'.$order->id.'.jpg', 30, $higth_qr, 20, 20, 'JPG');
        $pdf->Ln(24);
        $pdf->MultiCell(0, $higth, get_post_meta($datos_factura[0]->ID, 'lw_legend', true), $border, $aling);
    $pdf->Cell(0, 0, '', 1 , 1, 'C');
        $pdf->Cell(0, $higth, 'ATENDIDO POR: '.$order->get_meta('wc_pos_served_by_name'), 0, 1, 'L');
        $pdf->Cell(0, $higth, 'TICKES # : '.$order->get_meta('lw_pos_tickes'), 0, 1, 'L');
        
    $pdf->Output();
?>