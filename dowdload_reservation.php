<?php
if(isset($_POST['formato'])){
    require_once("includes/main.inc.php");
    $formato = $_POST['formato'];
    $sql = $_POST['sql'];
    $bad_chars ="\\";
    $sql = str_replace($bad_chars, "", $sql);
    $result = mysql_query($sql);
    //print_r($sql);
}else{
    exit();
}
?>
<html>
    <head>
        <title>Reservaciones</title>
        <script type=""></script>
        <!-- DataTables CSS -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
        
        <!-- jQuery -->
        <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- DataTables -->
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" charset="utf8" src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
        <script type="text/javascript" charset="utf8" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
        <script type="text/javascript" charset="utf8" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
        <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/buttons/1.0.3/js/buttons.html5.min.js"></script>
    
        <script type="text/javascript">
            $(document).ready(function() {
                $('#example').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                    ]
                } );
                <?php
                if($formato == "pdf"){
                    ?>
                    $(".buttons-pdf").click();
                    <?php
                }else{
                    ?>
                    $(".buttons-excel").click();
                    <?php
                }
                ?>
            });
        </script>
    </head>
    <body style="opacity: 0;">
        <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
                <tr>
                    <th>id </th>
                    <th>Conductor</th>
                    <th>Pasajero</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado reserva</th>
                    <th>Estado carrera</th>
                </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th>id </th>
                <th>Conductor</th>
                <th>Pasajero</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Estado reserva</th>
                <th>Estado carrera</th>
            </tr>
        </tfoot>
        <tbody>
        <?php
        while ($line_raw = mysql_fetch_array($result, MYSQL_ASSOC)) {
                                    $cnt++;
                                ?>
                                
                                    <tr>
                                        <td><?= $line_raw['id']; ?></td>
                                        <td><?php $driver = $line_raw['driver']; $result_driver = mysql_query("SELECT `fullname` FROM tbl_user WHERE id = '$driver'") or die(mysql_error()); while($row = mysql_fetch_assoc($result_driver)){ echo $row['fullname']; } ?></td>
                                        <td><?php $passenger = $line_raw['passenger']; $result_passenger = mysql_query("SELECT `fullname` FROM tbl_user WHERE id = '$passenger'") or die(mysql_error()); while($row = mysql_fetch_assoc($result_passenger)){ echo $row['fullname']; } ?></td>
                                        <td><?= $line_raw['pickup_date']; ?></td>
                                        <td><?= $line_raw['pickup_time']; ?></td>
                                        <td><?php
                                        if ($line_raw['ride_status'] == 'pending') {
                                            echo "Pendiente";
                                        }elseif ($line_raw['ride_status'] == 'canceled') {
                                            echo "Cancelada";
                                        }else{
                                            echo "Confirmada";
                                            }
                                        ?></td>
                                        <td><?php
                                        if ($line_raw['status'] == 0) {
                                             echo "Pendiente";
                                         }else{
                                            echo "Completada";
                                            }  ?></td>
                                    </tr>
                                    
                            <?php }?>
                                    </tbody>
    </table>
    </body>
</html>
