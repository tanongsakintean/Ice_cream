<?php
require('../class/DatabaseClass.php');
$db = new DatabaseClass();
$order = $db->qty("SELECT * FROM tb_order WHERE order_id = '" . $_REQUEST['id'] . "'")->fetch_object();
$item = $db->qty("SELECT * FROM tb_order_item WHERE order_id = '" . $_REQUEST['id'] . "'")->fetch_all();

require('code128.php');

$pdf = new PDF_Code128("P", "mm", array(80, 260));
$pdf->AddFont('THSarabunPSK', '', 'THSarabun.php');
$pdf->AddFont('THSarabunPSK', 'b', 'THSarabun Bold.php'); //หนา
$pdf->AddPage();
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('THSarabunPSK', 'B', 20);

$line = 6;

$pdf->SetXY(5, 5);

$pdf->Cell(70, 10, iconv('UTF-8', 'cp874', 'ใบเสร็จรับเงิน'), 0, 0, 'C');
$pdf->SetFont('THSarabunPSK', 'B', 15);
$pdf->Ln();


$pdf->SetXY(5, $line * 3);
$pdf->Cell(40, 7, iconv('UTF-8', 'cp874', date('d/m/', strtotime($order->order_date)) . substr($order->order_date, 0, 4) + 543), 0, 0, 'L');
$pdf->Cell(40, 7, iconv('UTF-8', 'cp874', ''), 0, 0, 'L');
$pdf->Ln();


for ($i = 0; $i < count($item); $i++) {
    $pro = $db->qty("SELECT pro_name,pro_price FROM tb_product WHERE pro_id = '" . $item[$i][2] . "'")->fetch_object();
    $pdf->SetXY(5, $line * ($i + 4));
    $pdf->Cell(4, 7, iconv('UTF-8', 'cp874', $item[$i][3]), 0, 0, 'L');
    $pdf->Cell(0, 7, iconv('UTF-8', 'cp874',  $pro->pro_name), 0, 0, 'L',);
    $pdf->Cell(6, 7, iconv('UTF-8', 'cp874', number_format($item[$i][3] * $pro->pro_price) . " บาท"), 0, 0, 'R');
    $pdf->Ln();
}

$pdf->SetXY(5, $line * (count($item) + 4));
$pdf->Cell(40, 7, iconv('UTF-8', 'cp874', '............................................................................'), 0, 0, 'L');
$pdf->Ln();


$pdf->SetXY(5, $line * (count($item) + 5));
$pdf->Cell(40, 7, iconv('UTF-8', 'cp874', 'จำนวนสินค้ารวม ' . count($item) . ' รายการ'), 0, 0, 'L');
$pdf->Ln();


$pdf->SetXY(5, $line * (count($item) + 6));
$pdf->Cell(31, 7, iconv('UTF-8', 'cp874', 'ยอดรวม '), 0, 0, 'L');
$pdf->Cell(40, 7, iconv('UTF-8', 'cp874', number_format($order->order_total) . " บาท"), 0, 0, 'R');
$pdf->Ln();

$pdf->SetXY(5, $line * (count($item) + 7));
$pdf->Cell(40, 7, iconv('UTF-8', 'cp874', '............................................................................'), 0, 0, 'L');
$pdf->Ln();

if ($order->mem_id > 0) {
    $pdf->SetXY(5, $line * (count($item) + 8));
    $pdf->Cell(31, 7, iconv('UTF-8', 'cp874', 'เงินโอน'), 0, 0, 'L');
    $pdf->Cell(40, 7, iconv('UTF-8', 'cp874', number_format($order->order_total) . " บาท"), 0, 0, 'R');
    $pdf->Ln();

    $pdf->SetXY(5, $line * (count($item) + 9));
    $pdf->Cell(31, 7, iconv('UTF-8', 'cp874', 'เงินทอน'), 0, 0, 'L');
    $pdf->Cell(40, 7, iconv('UTF-8', 'cp874',  $order->money . " บาท"), 0, 0, 'R');
    $pdf->Ln();
} else {
    $pdf->SetXY(5, $line * (count($item) + 8));
    $pdf->Cell(31, 7, iconv('UTF-8', 'cp874', 'เงินสด'), 0, 0, 'L');
    $pdf->Cell(40, 7, iconv('UTF-8', 'cp874', number_format($order->money + $order->order_total) . " บาท"), 0, 0, 'R');
    $pdf->Ln();

    $pdf->SetXY(5, $line * (count($item) + 9));
    $pdf->Cell(31, 7, iconv('UTF-8', 'cp874', 'เงินทอน'), 0, 0, 'L');
    $pdf->Cell(40, 7, iconv('UTF-8', 'cp874',  number_format($order->money) . " บาท"), 0, 0, 'R');
    $pdf->Ln();
}

$pdf->SetXY(5, $line * (count($item) + 10));
$pdf->Cell(40, 7, iconv('UTF-8', 'cp874', '............................................................................'), 0, 0, 'L');
$pdf->Ln();

if ($order->mem_id > 0) {
    $mem = $db->qty("SELECT * FROM tb_member WHERE mem_id = '" . $order->mem_id . "'")->fetch_object();
    $pdf->SetXY(5, $line * (count($item) + 11));
    $pdf->Cell(31, 7, iconv('UTF-8', 'cp874', 'สมาชิก คุณ ' . $mem->mem_firstname . " " . $mem->mem_lastname), 0, 0, 'L');
    $pdf->Ln();

    $pdf->SetXY(5, $line * (count($item) + 12));
    $pdf->Cell(31, 7, iconv('UTF-8', 'cp874', 'ได้แต้ม ' . date('d/m/', strtotime($order->order_date)) . "" . substr($order->order_date, 0, 4) + 543), 0, 0, 'L');
    $pdf->Ln();

    $pdf->SetXY(5, $line * (count($item) + 13));
    $pdf->Cell(31, 7, iconv('UTF-8', 'cp874', 'แต้มสะสมคงเหลือ ' . number_format($mem->mem_point) . ' คะแนน'), 0, 0, 'L');
    $pdf->Ln();

    $pdf->SetXY(5, $line * (count($item) + 14));
    $pdf->Cell(40, 7, iconv('UTF-8', 'cp874', '............................................................................'), 0, 0, 'L');
    $pdf->Ln();

    $pdf->SetXY(5, $line * (count($item) + 15));
    $pdf->Cell(70, 7, iconv('UTF-8', 'cp874', '***** ขอบคุณที่ใช้บริการ *****'), 0, 0, 'C');
    $pdf->Ln();
} else {
    $pdf->SetXY(5, $line * (count($item) + 12));
    $pdf->Cell(70, 7, iconv('UTF-8', 'cp874', '***** ขอบคุณที่ใช้บริการ *****'), 0, 0, 'C');
    $pdf->Ln();
}


$pdf->Output();
