<?php
    include_once 'include/DB.php';
    include_once 'include/function.php';
    include_once 'include/session.php';
    ?>
<?php
    include_once 'include/header.php'; ?>

  <?php
        function fetch_data() {
            global $con;
            $sql = "SELECT * from loan_type_master";
            $stmt = $con->query($sql);
            $output = '';
            $stmt->execute() ;
            $result = $stmt->rowCount();
            if ($result > 0) {
                while ($row = $stmt->fetch()) {
                    $output .= '
                    <tr>
                        <td>' . $row['id'] . '</td>
                        <td>' . $row['loan_type'] . '</td>
                        <td>' . $row['prefix'] . '</td>
                        <td>' . $row['min_amt'] . '</td>
                        <td>' . $row['max_amt'] . '</td>
                        <td>' . $row['interest'] . '</td>
                        <td>' . $row['status'] . '</td>
                        <td>' . $row['datetime'] . '</td>
                    </tr>
                    ';
                }
            }
            else{
                $_SESSION["error_message"] = "Record not found";
            }
            return $output;
        }

   //     if (isset($_POST["create_pdf"])) {
            require_once 'tcpdf/tcpdf.php';
            $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'utf8', false);

            $obj_pdf->SetCreator(PDF_CREATOR);
            $obj_pdf->setTitle("Loan Type Report");
            $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
            $obj_pdf->SetHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $obj_pdf->SetFooterFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            $obj_pdf->SetDefaultMonospacedFont('helvetica');
            $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);
            $obj_pdf->SetPrintHeader(false);
            $obj_pdf->SetPrintFooter(false);
            $obj_pdf->SetAutoPageBreak(TRUE, 10);
            $obj_pdf->SetFont('helvetica', '', 12);
            $obj_pdf->AddPage();
            $content = '';
            $content .= '
                  <h3 align="center">Loan Type Report Summary</h3>
                 <table class="table table-striped" border="1">
                    <tr>
                        <th>ID</th>
                        <th>Loan Type</th>
                        <th>Prefix</th>
                        <th>Minimum Amount</th>
                        <th>Maximum Amount</th>
                        <th>Interest</th>
                        <th>Status</th>
                        <th>Date/Time</th>
                    </tr>
        
        ';

            $content .= fetch_data();
            $content .= '</table>';
            $obj_pdf->writeHTML($content);
            ob_end_clean();
            $obj_pdf->Output("sample.pdf", 'I');
    //    }
    ?>
<div class="container">
    <h1 class="text-center">Account Summary Report</h1>
        <table class="table table-striped">
            <tr>
                <th>ID</th>
                <th>Loan Type</th>
                <th>Prefix</th>
                <th>Minimum Amount</th>
                <th>Maximum Amount</th>
                <th>Interest</th>
                <th>Status</th>
                <th>Date/Time</th>
            </tr>
            <tr>
                <?php echo fetch_data(); ?>
            </tr>
        </table>
        <br>
        <form method="post">
                <input type="submit" name="create_pdf" class="btn btn-danger" value="Create PDF">
        </form>
</div>

<?php
    include_once 'include/footer.php';
    ?>

