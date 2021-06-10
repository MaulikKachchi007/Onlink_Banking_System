<?php
require_once 'tcpdf/tcpdf.php';
include('include/DB.php');
include('include/session.php');
include('include/function.php');
class MYPDF extends TCPDF {
    // Load table data from file
    public function LoadData() {
        // Read file lines
        global $con;
        global $con;
        $fromDate = $_GET['fromDate'];
        $toDate = $_GET['toDate'];
        $sql = "SELECT * FROM transaction 
                WHERE trans_date_time BETWEEN '$fromDate' AND '$toDate'";
        $stmt = $con->query($sql);
        $row = $stmt->fetchALL();
        return $row;
    }
    public function Data() {
        $date = date("Y-m-d");
        $output = "";
        $output .= "
                    <h2>Transactions Reports</h2>
                    <p>Your Transactions Reports Date $date</p>
        
                    ";
        return $output;
    }
    // Colored table
    public function ColoredTable($header,$data) {
        // Colors, line width and bold font
        $this->SetFillColor(255, 102, 51);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
            $w = array(30,35,35,30,85,30,35);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach($data as $row) {
            $this->Cell($w[0], 6, $row['trans_id'], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row['trans_date_time'], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, $row['to_account_no'], 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, $row['amount'], 'LR', 0, 'R', $fill);
            $this->Cell($w[4], 6, $row['particulars'], 'LR', 0, 'L', $fill);
            $this->Cell($w[5], 6, $row['transaction_type'], 'LR', 0, 'L', $fill);
            $this->Cell($w[6], 6, $row['payment_status'], 'LR', 0, 'L', $fill);
            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}
// create new PDF document
$pdf = new MYPDF('A4', PDF_UNIT, 'A3' , true, 'UTF-8', false);
// Protection data
$pdf->SetProtection(array('print', 'copy','modify'),'admin', 'admin', 0, null);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Admin');
$pdf->SetTitle('OctoPrime E-Banking');
$pdf->SetSubject('Customers Reports');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetFont('helvetica', '', 12);

// set margins
$pdf->SetMargins('4', PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 10);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 12);

// add a page
$pdf->AddPage();

// column titles
$header = array('Transaction ID','Date','Account Number','Amount (Rs.)','Particulars','Transaction','Payment Status');


// Set some content to print
//$html = <<<EOD
/*<h1>Mr.<?php echo $rowdata[f_name]; ?></h1>*/
//<i>This is the first example of TCPDF library.</i>
//<p>Please check the source code documentation and other examples for further information.</p>
//EOD;
$dataoutput = $pdf->data();

// Print text using writeHTMLCell()
$pdf->writeHTML($dataoutput);
// Print text using writeHTMLCell()


// data loading
$data = $pdf->LoadData();
//$data = $pdf->data();
//print_r($data); exit;
// print colored table
//$data = $pdf->data();
$pdf->ColoredTable($header, $data);

// ---------------------------------------------------------

// close and output PDF document
// ob_end_clean();
$pdf->Output('admin_statement_report.pdf', 'D');

//============================================================+
// END OF FILE
//============================================================+
?>