<?php
    // Edit this path if PHPMailer is in a different location.
    require './PHPMailer/PHPMailerAutoload.php';

    $mail = new PHPMailer;
    $mail->isSMTP();

    /*
     * Server Configuration
     */

    $mail->Host = 'smtp.gmail.com'; // Which SMTP server to use.
    $mail->Port = 587; // Which port to use, 587 is the default port for TLS security.
    $mail->SMTPAuth = true; // Whether you need to login. This is almost always required.
    $mail->SMTPSecure = false;
    $mail->Username = "TODO: USER"; // Your Gmail address.
    $mail->Password = "TODO: PASS"; // Your Gmail login password or App Specific Password.
    
    //Dectect OS and browser
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    function getOS() { 
    
        global $user_agent;
    
        $os_platform  = "Unknown OS Platform";
    
        $os_array     = array(
                              '/windows nt 10/i'      =>  'Windows 10',
                              '/windows nt 6.3/i'     =>  'Windows 8.1',
                              '/windows nt 6.2/i'     =>  'Windows 8',
                              '/windows nt 6.1/i'     =>  'Windows 7',
                              '/windows nt 6.0/i'     =>  'Windows Vista',
                              '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                              '/windows nt 5.1/i'     =>  'Windows XP',
                              '/windows xp/i'         =>  'Windows XP',
                              '/windows nt 5.0/i'     =>  'Windows 2000',
                              '/windows me/i'         =>  'Windows ME',
                              '/win98/i'              =>  'Windows 98',
                              '/win95/i'              =>  'Windows 95',
                              '/win16/i'              =>  'Windows 3.11',
                              '/macintosh|mac os x/i' =>  'Mac OS X',
                              '/mac_powerpc/i'        =>  'Mac OS 9',
                              '/linux/i'              =>  'Linux',
                              '/ubuntu/i'             =>  'Ubuntu',
                              '/iphone/i'             =>  'iPhone',
                              '/ipod/i'               =>  'iPod',
                              '/ipad/i'               =>  'iPad',
                              '/android/i'            =>  'Android',
                              '/blackberry/i'         =>  'BlackBerry',
                              '/webos/i'              =>  'Mobile'
                        );
    
        foreach ($os_array as $regex => $value)
            if (preg_match($regex, $user_agent))
                $os_platform = $value;
    
        return $os_platform;
    }
    
    function getBrowser() {
    
        global $user_agent;
    
        $browser        = "Unknown Browser";
    
        $browser_array = array(
                                '/msie/i'      => 'Internet Explorer',
                                '/firefox/i'   => 'Firefox',
                                '/safari/i'    => 'Safari',
                                '/chrome/i'    => 'Chrome',
                                '/edge/i'      => 'Edge',
                                '/opera/i'     => 'Opera',
                                '/netscape/i'  => 'Netscape',
                                '/maxthon/i'   => 'Maxthon',
                                '/konqueror/i' => 'Konqueror',
                                '/mobile/i'    => 'Handheld Browser'
                         );
    
        foreach ($browser_array as $regex => $value)
            if (preg_match($regex, $user_agent))
                $browser = $value;
    
        return $browser;
    }
    
    
    $user_os        = getOS();
    $user_browser   = getBrowser();
    
    $device_details = "Browser: ".$user_browser."\n OS: ".$user_os."";
    
    /*
    * Message Configuration
    */
    
    // Here we get all the information from the fields sent over by the form.
    $name = $_REQUEST['user-name'];
    $email = $_REQUEST['user-email'];
    $message = ( $_REQUEST['user-message'] ) ? $_REQUEST['user-message'] : '';
    $status = $_REQUEST['user-status'];
    $ip = $ip = getenv('HTTP_CLIENT_IP')?:
    getenv('HTTP_X_FORWARDED_FOR')?:
    getenv('HTTP_X_FORWARDED')?:
    getenv('HTTP_FORWARDED_FOR')?:
    getenv('HTTP_FORWARDED')?:
    getenv('REMOTE_ADDR');
    $message = $device_details."\n Name: ".$name."\n Email: ".$email."\n IP: ".$ip."\n Message: ".$message;
    $status = $_REQUEST['user-status'];

    $mail->setFrom($email, 'TODO: title email'); // Set the sender of the message.
    $mail->addAddress('TODO: email to send to', $name); // Set the recipient of the message.
    $mail->Subject = 'TODO: subject'; // The subject of the message.
    $mail->body = $message;
    
    // Choose to send either a simple text email...
    $mail->Body = $message; // Set a plain text body.
    
    if(!empty($_POST['website']) || !empty($_POST['email']) || !empty($_POST['message'])) {
        die();
    }

    if (filter_var($email, FILTER_VALIDATE_EMAIL) && !$name == "" && !$email == "") { // shis line checks that we have a valid email address
        if ($mail->send()) {
          header("Location: TODO: THANKYOU PAGE");
          die();
        } else {
            echo "Mailer Error: " . $mail->ErrorInfo;
            die();
        }
    }
    else{
        echo "Mailer Error: Please fill out the required forms";
        die();
    }

?>