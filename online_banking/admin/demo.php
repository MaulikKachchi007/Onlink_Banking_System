<?php
include_once 'include/DB.php';
include_once 'include/function.php';
include_once 'include/session.php';
?>
<select name="fd_type" class="form-control">
    <option value="Select" selected>Select</option>
    <?php
    global $con;
    $q = "SELECT * FROM fixed_deposite WHERE status='active'";
    $stmt = $con->query($q);
    while ($row = $stmt->fetch()){
        $fid = $row['f_id'];
        $d_type = $row['d_type'];
        ?>
        <option value="<?php echo $fid;?>"><?php echo $d_type;?></option>
        <?php
    }
    ?>

</select>