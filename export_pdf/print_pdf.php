<?php
require('../class/DatabaseClass.php');
$db = new DatabaseClass();
require('code128.php');
if (isset($_REQUEST['start']) && isset($_REQUEST['end'])) {
    $sort_order = $db->qty("SELECT * FROM tb_order WHERE pay_status = 1 AND order_date BETWEEN '" . $_REQUEST['start'] . "' AND '" . $_REQUEST['end'] . "' ORDER BY order_date DESC")->fetch_all();
} else {
    $sort_order = $db->qty("SELECT * FROM tb_order ")->fetch_all();
}

$sum_total = 0;

$pdf = new PDF_Code128('L', 'mm', 'A4');
$pdf->AddFont('THSarabunPSK', '', 'THSarabun.php');
$pdf->AddFont('THSarabunPSK', 'b', 'THSarabun Bold.php'); //หนา
$pdf->AddPage();
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('THSarabunPSK', 'B', 23);


if (isset($_REQUEST['start'])) {
    $pdf->SetXY(140, 5);
    $pdf->Cell(15, 7, iconv('UTF-8', 'cp874', 'ข้อมูลรายงานยอดขาย ' . date('d/m/', strtotime($_REQUEST['start'])) . substr($_REQUEST['start'], 0, 4) + 543  . ' - ' . date('d/m/', strtotime($_REQUEST['end'])) . substr($_REQUEST['end'], 0, 4) + 543), 0, 0, 'C');
    $pdf->SetFont('THSarabunPSK', '', 14);
    $pdf->Ln(12);
} else {
    $pdf->SetXY(140, 5);
    $pdf->Cell(15, 7, iconv('UTF-8', 'cp874', 'ข้อมูลรายงานยอดขาย ' . date('d/m/Y')), 0, 0, 'C');
    $pdf->SetFont('THSarabunPSK', '', 14);
    $pdf->Ln(12);
}
$pdf->SetFont('THSarabunPSK', 'B', 14);
$pdf->Cell(20, 7, iconv('UTF-8', 'cp874', 'ลำดับ'), 1, 0, 'C');
$pdf->Cell(70, 7, iconv('UTF-8', 'cp874', 'ชื่อผู้สั่งซื้อ'), 1, 0, 'C');
$pdf->Cell(60, 7, iconv('UTF-8', 'cp874', 'จำนวน'), 1, 0, 'C');
$pdf->Cell(50, 7, iconv('UTF-8', 'cp874', 'วันที่ชำระ'), 1, 0, 'C');
$pdf->Cell(70, 7, iconv('UTF-8', 'cp874', 'ราคารวมทั้งหมด'), 1, 0, 'C');
$pdf->Ln(7);


$pdf->SetFont('THSarabunPSK', '', 14);
for ($i = 0; $i < count($sort_order); $i++) {
    $sum_order = $db->qty("SELECT SUM(item_qty) FROM tb_order_item WHERE order_id = '" . $sort_order[$i][0] . "'")->fetch_array();
    $user = $db->qty("SELECT * FROM tb_member WHERE mem_id = '" . $sort_order[$i][1] . "'")->fetch_object();
    $sum_amount = $db->qty("SELECT SUM(item_qty) FROM tb_order_item WHERE order_id = '" . $sort_order[$i][0] . "'")->fetch_array();
    $pdf->Cell(20, 7, iconv('UTF-8', 'cp874', ($i + 1)), 1, 0, 'C');
    if ($user->mem_title == 1) {
        $pdf->Cell(70, 7, iconv('UTF-8', 'cp874', 'นาย ' . $user->mem_firstname . ' ' . $user->mem_lastname), 1, 0, 'C');
    } else if ($user->mem_title == 2) {
        $pdf->Cell(70, 7, iconv('UTF-8', 'cp874', 'นาง ' . $user->mem_firstname . ' ' . $user->mem_lastname), 1, 0, 'C');
    } else if ($user->mem_title == 3) {
        $pdf->Cell(70, 7, iconv('UTF-8', 'cp874', 'นางสาว ' . $user->mem_firstname . ' ' . $user->mem_lastname), 1, 0, 'C');
    } else {
        $pdf->Cell(70, 7, iconv('UTF-8', 'cp874', 'ลูกค้าทั่วไป'), 1, 0, 'C');
    }
    $pdf->Cell(60, 7, iconv('UTF-8', 'cp874', $sum_order[0]), 1, 0, 'C');
    $pdf->Cell(50, 7, iconv('UTF-8', 'cp874', date('d/m/', strtotime($sort_order[$i][2])) . substr($sort_order[$i][2], 0, 4) + 543), 1, 0, 'C');
    $pdf->Cell(70, 7, iconv('UTF-8', 'cp874', number_format($sort_order[$i][4]) . ' บาท'), 1, 0, 'C');
    $pdf->Ln(7);
    $sum_total += $sort_order[$i][4];
}

$pdf->SetFont('THSarabunPSK', 'B', 14);
$pdf->SetX(160);
$pdf->Cell(50, 7, iconv('UTF-8', 'cp874', 'รวม'), 1, 0, 'C');
$pdf->SetFont('THSarabunPSK', '', 14);
$pdf->Cell(70, 7, iconv('UTF-8', 'cp874', number_format($sum_total) . ' บาท'), 1, 0, 'C');
$pdf->Ln(7);


$pdf->Output();
