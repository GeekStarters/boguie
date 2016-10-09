<?php

class DB_Functions {

    private $db;

    //put your code here
    // constructor
    function __construct() {
        include_once 'db_connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }

    // destructor
    function __destruct() {
        
    }

    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($email, $gcm_regid,$user_type) {
        // insert user into database
        $result = mysql_query("INSERT INTO gcm_users(email, gcm_regid, user_type, created_at) VALUES('$email', '$gcm_regid','$user_type', NOW())");
        // check for successful store
        if ($result) {
            $json['success'] = 1;
            return $success = json_encode($json);
        } else {
            $json['success'] = 0;
            return $success = json_encode($json);
        }
    }

    public function updatePos($email, $lat, $long, $cab_type) {

        if ($cab_type == 1) {
            $cab_type = 7;
        } elseif ($cab_type == 2) {
            $cab_type = 8;
        } elseif ($cab_type == 3) {
            $cab_type = 9;
        }
        // insert user into database
        $result = mysql_query("update tbl_user set latitude='$lat' , longitude='$long' ,cab_type = '$cab_type' where email='$email'");
        // check for successful store
        if ($result) {
            //$json['success'] = 1;
            return $success = 1;
        } else {
            //$json['success'] = 0;
            return $success = 0;
        }
    }

    // update Gcm data
    public function updateDriverRegID($email, $gcm_regid,$user_type) {


        // update user into database
        $result = mysql_query("update gcm_users set gcm_regid='$gcm_regid', user_type ='$user_type' where email='$email'");
        return $result;
        // check for successful store
    }
    
    public function updateDriverStatus($email, $status) {

        mysql_query("update nearest_driver set driver_status='$status' where driver_email='$email'");

        // update user into database
        $result = mysql_query("update gcm_users set driver_status='$status' where email='$email'");
        return $result;
        // check for successful store
    }

    
       public function updateDriverPos($email, $lat, $long , $user_mail, $cab_type, $driver_status) {
      
           //delete same user enteries from nearest_driver
           //$del = mysql_query("delete from nearest_driver where user_email='$user_mail'");
        // insert user into database
            if ($cab_type == 1) {
            $cab_type = 7;
        } elseif ($cab_type == 2) {
            $cab_type = 8;
        } elseif ($cab_type == 3) {
            $cab_type = 9;
        }
        
        $result = mysql_query("insert into nearest_driver set user_email = '$user_mail', driver_email='$email' , latitude='$lat' , longitude='$long' ,cab_type ='$cab_type' ,driver_status='$driver_status' ");
        // check for successful store
        if ($result) {
            //$json['success'] = 1;
            return $success = 1;
        } else {
            //$json['success'] = 0;
            return $success = 0;
        }
    }
    /**
     * Get user by email and password
     */
    public function getUserByEmail($email) {
        $result = mysql_query("SELECT * FROM gcm_users WHERE email = '$email' LIMIT 1");
        return $result;
    }

    /**
     * Getting all users
     */
    public function getAllUsers() {
        $result = mysql_query("select * FROM gcm_users");
        return $result;
    }

    /**
     * Check user is existed or not
     */
    public function isUserExisted($email) {
        $result = mysql_query("SELECT email from gcm_users WHERE email = '$email'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // user existed
            return true;
        } else {
            // user not existed
            return false;
        }
    }

 /*function distance($lat1, $lon1, $lat2, $lon2, $unit) {

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }
}*/
    
    function distance($a, $b)
{
    list($lat1, $lon1) = $a;
    list($lat2, $lon2) = $b;

    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    return $miles;
}
    
}

?>