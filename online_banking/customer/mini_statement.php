<?php
require_once 'tcpdf/tcpdf.php';
include('include/DB.php');
include('include/session.php');
include('include/function.php');
class MYPDF extends TCPDF {
    // Load table data from file
//    private $_password;
    public function LoadData() {
        // Read file lines
        $get_id = $_SESSION['c_id'];
        global $con;
        $sql = "SELECT * FROM transaction 
                INNER JOIN accounts ON transaction.to_account_no=accounts.account_no WHERE
                accounts.c_id='$get_id' and accounts.account_type='Saving Account' or accounts.account_type='Current Account' AND (transaction.payment_status='Active' OR transaction.payment_status='Approved')  ORDER BY transaction.trans_id DESC LIMIT  10";
        $stmt = $con->query($sql);
        $row = $stmt->fetchALL();
        return $row;
    }
    public function data() {
        // Read file lines
        $get_id = $_SESSION['c_id'];
        global $con;
        $output='';
        $sql = "SELECT * FROM accounts 
                INNER JOIN customers_master ON customers_master.c_id=accounts.c_id WHERE
                accounts.c_id='$get_id' and accounts.account_status='Active' and (accounts.account_type='Saving Account' or accounts.account_type='Current Account')";
        $stmt = $con->query($sql);
        while ($row = $stmt->fetch()) {
            $f_name = $row['f_name'];
            $l_name = $row['l_name'];
            $account_no = $row['account_no'];
            $date = date('Y-m-d');
            $account_type = $row['account_type'];
            $account_balance = $row['account_balance'];
        }
        $output .= "
           <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' integrity='sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh' crossorigin='anonymous'>
            <h1>Mr.$f_name $l_name</h1>
            <p>Your Account Statement as on $date</p>
            <p><b>A Summary of your relationship with us</b></p>
            <hr><br> 
            <table class='table table-bordered table-striped table-condensed table-responsive'>
                <tr>
                    <th>Account Type</th>
                    <th>Account Number</th>
                    <th>Currency</th>
                    <th>Account Balance</th>
                   
                </tr>
                 <tr>
                     <th>$account_type</th>
                    <th>$account_no</th>
                    <th>INR</th>
                    <th>$account_balance</th>
                </tr>
            </table>
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
        $w = array(30,40,60,30,30);
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
            $this->Cell($w[0], 6, substr($row['trans_date_time'],0,10), 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row['account_no'], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, $row['particulars'], 'LR', 0, 'L', $fill);
            $this->Cell($w[4], 6, $row['transaction_type'], 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, number_format($row['amount']), 'LR', 0, 'L', $fill);
            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}
// create new PDF document
$pdf = new MYPDF('A4', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// Protection data
$pdf->SetProtection(array('print', 'copy','modify'),$_GET['birthdate'], null, 0, null);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Admin');
$pdf->SetTitle('OctoPrime E-Banking');
$pdf->SetSubject('Mini Reports');
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
$header = array('Date','Account Number','Particulars','Transaction','Amount');

// Set some content to print
//$html = <<<EOD
/*<h1>Mr.<?php echo $rowdata[f_name]; ?></h1>*/
//<i>This is the first example of TCPDF library.</i>
//<p>Please check the source code documentation and other examples for further information.</p>
//EOD;
$dataoutput = $pdf->data();

// Print text using writeHTMLCell()
$pdf->writeHTML($dataoutput);

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
$pdf->Output('mini_statement.pdf', 'D');

//============================================================+
// END OF FILE
//============================================================+
?>