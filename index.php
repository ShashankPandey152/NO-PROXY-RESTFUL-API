<?php

    $link = mysqli_connect("shareddb-g.hosting.stackcp.net","interconnect-3237e9c9","password98@","interconnect-3237e9c9");

    if($_GET["log"] == 1) {
     
        $signup = 0;
        
        if($_GET["sign"] == 1) {

            $query = "SELECT * FROM `faculty` WHERE `tid` = '".mysqli_real_escape_string($link,$_GET['tid'])."' OR `email` = '".mysqli_real_escape_string($link, $_GET['email'])."'";

            if(mysqli_num_rows(mysqli_query($link,$query))>0) {
                $signup = 0;
            }else {
                $query = "INSERT INTO `faculty` (`tid`,`name`,`email`,`password`) 
                VALUES('".mysqli_real_escape_string($link,$_GET["tid"])."','".mysqli_real_escape_string($link,$_GET["name"])."',
                '".mysqli_real_escape_string($link,$_GET["email"])."','".mysqli_real_escape_string($link,hash('sha512',$_GET['password']))."')";

                if(mysqli_query($link,$query)) {
                    $signup = 1;
                } 
                
            }
            
            echo json_encode(Array("signup" => $signup));

        } else if($_GET["sign"] = 2) {

            $query = "SELECT * FROM `student` WHERE reg = '".mysqli_real_escape_string($link,$_GET["reg"])."' OR `email` = '".mysqli_real_escape_string($link, $_GET['email'])."'";

            if(mysqli_num_rows(mysqli_query($link,$query))>0) {
                $signup = 0;
            } else {
                $query = "INSERT INTO `student` (`reg`,`name`,`email`,`password`) 
                VALUES('".mysqli_real_escape_string($link,$_GET["reg"])."','".mysqli_real_escape_string($link,$_GET["name"])."',
                '".mysqli_real_escape_string($link,$_GET["email"])."','".mysqli_real_escape_string($link,hash('sha512',$_GET["password"]))."')";

                if(mysqli_query($link,$query)) {
                    $signup = 1;
                } 

            }
            
            echo json_encode(Array("signup" => $signup));
        }
    } else if($_GET["log"] == 2) {
        
        $logStatus = 0;
        
        if($_GET["login"] == 1) {
            
            $query = "SELECT * FROM `faculty` WHERE `email` = '".mysqli_real_escape_string($link,$_GET['email'])."'";
            
            if(mysqli_num_rows(mysqli_query($link,$query)) == 0) {
                $logStatus = 0;
            }else {
                $row = mysqli_fetch_array(mysqli_query($link,$query));
                
                if(hash(sha512,$_GET["password"]) == $row["password"]) {
                    $logStatus = 1;
                }
            }
            
            echo json_encode(Array("logStatus" => $logStatus, "tid" => $row['tid']));
            
        } else if($_GET["login"] == 2) {
            
            $query  = "SELECT * FROM `student` WHERE `email` = '".mysqli_real_escape_string($link,$_GET['email'])."'";
            
            if(mysqli_num_rows(mysqli_query($link,$query)) == 0) {
                $logStatus = 0;
            }else {
                $row = mysqli_fetch_array(mysqli_query($link,$query));
                
                if(hash(sha512,$_GET["password"]) == $row["password"]) {
                    $logStatus = 1;
                }
            }
            
            echo json_encode(Array("logStatus" => $logStatus, "reg" => $row['reg'])); 
                
        }
    }


    if($_GET["fac"] == 1) {

        $query = "SELECT * FROM `faculty_slot` WHERE `tid` ='".mysqli_real_escape_string($link,$_GET["tid"])."' AND `scode` = '".mysqli_real_escape_string($link,$_GE["scode"])."'";

        $row = mysqli_fetch_array(mysqli_query($link,$query));

        if($_GET["tid"] == $row["tid"] && $_GET["scode"] == $row["scode"]) {
            $status = 0;
        } else {
            $query = "INSERT INTO `faculty_slot` (`tid`,`scode`,`batch`,`slot`,`do`)
            VALUES('".mysqli_real_escape_string($link,$_GET["tid"])."','".mysqli_real_escape_string($link,$_GET["scode"])."',
            '".mysqli_real_escape_string($link,$_GET["batch"])."','".mysqli_real_escape_string($link,$_GET["slot"])."',
            '".mysqli_real_escape_string($link,$_GET["do"])."')";

            if(mysqli_query($link.$query)) {
                $status = 1;
            }
        }

        echo json_encode(Array("tid" => tid, "scode" => scode));
    }

    if($_GET["fac"] == 2) {

        $query = "SELECT * FROM `student_slot` WHERE `reg` = '".mysqli_real_escape_string($link,$_GET["reg"])."' AND `sid` = 
        '".mysqli_real_escape_string($link,$_GET["sid"])."'";

        $row = mysqli_fetch_array(mysqli_query($link,$query));

        if($_GET["reg"] == $row["reg"] && $_GET["sid"] == $row["sid"]) {
            $status = 0;
        } else {
            $query = "INSERT INTO `student_slot(`reg`,`sid`,`tid`) 
            VALUES('".mysqli_real_escape_string($link,$_GET["reg"])."','".mysqli_real_escape_string($link,$_GET["sid"])."',
            '".mysqli_real_escape_string($link,$_GET["tid"])."')";

            if(mysqli_query($link,$query)) {
                $status = 1;
            }
        }

        echo json_encode(Array("reg" => reg, "sid" => sid));
    }

?>