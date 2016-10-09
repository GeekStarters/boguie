<?php 

include ($dirroot_path.'includes/database_connection.php');



class database {

    function insert($data, $table) {
        $li = sizeof($data);
        $saperator = "";
        $str_field = "";
        $str_data = "";
        $result = "0";
        for ($i = 0; $i < $li; $i++) {
            $str_field .=$saperator . $data[$i]["field"];
            $str_data .=$saperator . "'" . $data[$i]["value"] . "'";
            $saperator = ",";
        }
     $str = "INSERT INTO $table($str_field)VALUES($str_data)";
        try {
            $result = mysql_query($str);
        } catch (Exception $e) {
            
        }
        return mysql_affected_rows();
    }

    function update($data, $condition, $table) {
        $li = sizeof($data);
        $saperator = "";
        $str_field = "SET ";
        $str_data = "";
        $result = "0";
        if ($condition != "")
            $condition = "WHERE " . $condition;
        for ($i = 0; $i < $li; $i++) {
            $str_field .="$saperator" . $data[$i]['field'] . "='" . $data[$i]['value'] . "'";
            $saperator = ",";
        }
        $str = "UPDATE $table $str_field $condition";
        try {
            $result = mysql_query($str);
        } catch (Exception $e) {
            
        }
        return mysql_affected_rows();
    }
    
    function select($data, $condition, $table) {
        if ($condition != "")
            $condition = "WHERE " . $condition;
       $str = "SELECT $data FROM $table $condition";
        try {
            $result = mysql_query($str);
            $rows = array();
            while ($row = mysql_fetch_array($result)) {
                $rows[] = $row;
            }
        } catch (Exception $e) {
            return $e;
        }
        return $rows;
    }

    function query_exec($query)
   {
       return mysql_query($query);
   }
   function query_exec_no($fetch_data)
   {
        $total_record = mysql_num_rows($fetch_data);
        return $total_record ;
   }
   public static function fetch($results)
    {
       $row=mysql_fetch_array($results);
       return $row;
    }

    

}

?>