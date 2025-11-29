<?php
require('../../vendor/autoload.php');
include "../../koneksiDB.php";

$user_id = $_GET['user_id'];

$q = mysqli_query($conn,"
    SELECT tr_orders.*, menu.nama, roles.username
    FROM tr_orders
    JOIN menu ON menu.id = tr_orders.menu_id
    JOIN roles ON roles.id = tr_orders.order_by_user_id
    WHERE order_by_user_id='$user_id' AND status='done'
");

$data = [];
$total = 0;
$username = "";
$date = date("d-m-Y H:i");

while($row = mysqli_fetch_assoc($q)) {
    $total += $row['total_price'];
    $username = $row['username'];
    $data[] = $row;
}

use FPDF\FPDF;

class PDF extends FPDF {
    function FancyTitle(){
        $this->SetFont('Arial','B',26);
        $this->SetTextColor(215,255,0);
        $this->Cell(0,12,'Westo',0,1,'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(0,0,0);
$pdf->SetDrawColor(215,255,0);
$pdf->Rect(0,0,220,300,'F');

$pdf->FancyTitle();
$pdf->Ln(2);

$pdf->SetFont('Arial','',12);
$pdf->Cell(0,7,"Nama: $username",0,1,'C');
$pdf->Cell(0,7,"Tanggal: $date",0,1,'C');

$pdf->Ln(4);
$pdf->Cell(0,0,'','T');
$pdf->Ln(5);

$pdf->SetFont('Arial','',12);
foreach($data as $d){
    $pdf->Cell(0,7,"- ".$d['nama']." x".$d['quantity']."  Rp ".number_format($d['total_price'],0,',','.'),0,1);
}

$pdf->Ln(4);
$pdf->SetFont('Arial','B',14);
$pdf->SetTextColor(215,255,0);
$pdf->Cell(0,10,'Total: Rp '.number_format($total,0,',','.'),0,1,'R');

$pdf->Output();
?>
