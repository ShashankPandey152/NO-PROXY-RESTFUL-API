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
                } else {
                    $signup = 2;
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
                } else {
                    $signup = 2;
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

    if($_GET['forgot'] == 1) {
        
        $status = 0;
        
        $query = "SELECT `id` FROM `faculty` WHERE `email` = '".mysqli_real_escape_string($link, $_GET['email'])."'";
        
        if(mysqli_num_rows(mysqli_query($link, $query)) > 0) {
            
            $to = $_GET['email'];
            $subject = "Reset password";
            $message = '

Please click this link to reset your password:
http://jncpasighat-com.stackstaging.com/vastuKosh/verify.php?email='.$mail.'

This is a system generated mail. Do not reply. 
            ';
            $headers = 'From:noreply@noproxy.com' . "\r\n"; 
            if(mail($to, $subject, $message, $headers)) {
                $status = 1;
            } else {
                $status = 0;
            }
            
        } else {
            $status = 2;
        }
        
        echo json_encode(Array("status" => $status));
        
    } else if($_GET['forgot'] == 2) {
        
        $status = 0;
        
        $query = "SELECT `id` FROM `student` WHERE `email` = '".mysqli_real_escape_string($link, $_GET['email'])."'";
        
        if(mysqli_num_rows(mysqli_query($link, $query)) > 0) {
            
            $to = $_GET['email'];
            $subject = "Reset password";
            $message = '

Please click this link to reset your password:
http://jncpasighat-com.stackstaging.com/vastuKosh/verify.php?email='.$mail.'

This is a system generated mail. Do not reply. 
            ';
            $headers = 'From:noreply@noproxy.com' . "\r\n"; 
            if(mail($to, $subject, $message, $headers)) {
                $status = 1;
            } else {
                $status = 0;
            }
            
        } else {
            $status = 2;
        }
        
        echo json_encode(Array("status" => $status));
        
    }

    if($_GET["fac"] == 1) {
        
        $status = 0;
        
        $query = "SELECT * FROM `faculty_slot` WHERE `tid` ='".mysqli_real_escape_string($link,$_GET["tid"])."' AND `scode` = '".mysqli_real_escape_string($link,$_GET["scode"])."'";
        
        $result = mysqli_query($link, $query);
        
        if(mysqli_num_rows($result) > 0) {
            $status = 0;
        } else {
            $query = "INSERT INTO `faculty_slot` (`tid`,`scode`,`batch`,`slot`,`do`)
            VALUES('".mysqli_real_escape_string($link,$_GET["tid"])."','".mysqli_real_escape_string($link,$_GET["scode"])."',
            '".mysqli_real_escape_string($link,$_GET["batch"])."','".mysqli_real_escape_string($link,$_GET["slot"])."',
            '".mysqli_real_escape_string($link,$_GET["do"])."')";
            if(mysqli_query($link, $query)) {
                $status = 1;
            }
        }
        echo json_encode(Array("status" => $status));
    } else if($_GET["fac"] == 2) {
        
        $status = 0;
        
        $query = "SELECT * FROM `student_slot` WHERE `reg` = '".mysqli_real_escape_string($link,$_GET["reg"])."' AND `sid` = 
        '".mysqli_real_escape_string($link,$_GET["sid"])."'";
        
        $result = mysqli_query($link, $query);
        
        if(mysqli_num_rows($result) > 0) {
            $status = 0;
        } else {
            $query = "INSERT INTO `student_slot`(`reg`, `slot`, `sid`, `tid`) VALUES('".mysqli_real_escape_string($link, $_GET['reg'])."', '".mysqli_real_escape_string($link, $_GET['slot'])."', '".mysqli_real_escape_string($link, $_GET['sid'])."', '".mysqli_real_escape_string($link, $_GET['tid'])."')";
            
            if(mysqli_query($link,$query)) {
                $status = 1;
            }
        }
        echo json_encode(Array("status" => $status));
    }
    
    if($_GET['allSub'] == 1) {
        
    } else if($_GET['allSub'] == 2) {
        
        $status = 0;
        $slots = Array();
        $sids = Array();
        
        $query = "SELECT * FROM `student_slot` WHERE `reg` = '".mysqli_real_escape_string($link, $_GET['reg'])."'";
        
        if($result = mysqli_query($link, $query)) {
            while($row = mysqli_fetch_array($result)) {
                
                array_push($slots, $row['slot']);
                array_push($sids, $row['sid']);
                
            }
        } 
        
        if(sizeof($slots) > 0) {
            $status = 1;
        } else {
            $status = 0;
        }
        
        for($i = 0;$i < sizeof($slots) - 1;$i++) {
            for($j = 0;$j<sizeof($slots) - i - 1;$j++) {
                if($slots[$j] > $slots[$j+1]) {
                    $temp = $slots[$j];
                    $slots[$j] = $slots[$j+1];
                    $slots[$j+1] = $temp;
                    $temp1 = $sids[$j];
                    $sids[$j] = $sids[$j+1];
                    $sids[$j+1] = $temp1;
                }
            }
        }
        
        echo json_encode(Array("slots" => $slots, "sids" => $sids, "status" => $status));
        
    }

?>