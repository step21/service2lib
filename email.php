<?php
function mailer ( $to, $from, $subject, $message ) 
{

    # $to      = 'nobody@example.com';
    # $subject = 'the subject';
    # $message = 'hello';
    $headers =   "From: $from" . "\r\n" .
                 "Reply-To: $from" . "\r\n" .
                 'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);

}

function remailer ($to,$from,$subject,$message,$files)
{
    // print_r($files);
    $from_pure = $from;
    // email fields: to, from, subject, and so on
    //$from = $from; 
    // $message = date("Y.m.d H:i:s")."\n".count($files)." attachments";
    // $headers = "From: $from";
    $headers =   "From: $from" . "\r\n" .
                 "Reply-To: $from" . "\r\n" .
                 'X-Mailer: PHP/' . phpversion();

    // boundary 
    $semi_rand = md5(time()); 
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

    // headers for attachment 
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 

    // multipart boundary 
    $message = "--{$mime_boundary}\n" . "Content-Type: text/plain; charset=\"iso-8859-1\"\n" .
    "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 

    // preparing attachments
    for($i=0;$i<count($files);$i++){
        if(is_file($files[$i])){
            $message .= "--{$mime_boundary}\n";
            $fp =    @fopen($files[$i],"rb");
            $data =    @fread($fp,filesize($files[$i]));
            @fclose($fp);
            $data = chunk_split(base64_encode($data));
            $message .= "Content-Type: application/octet-stream; name=\"".basename($files[$i])."\"\n" . 
            "Content-Description: ".basename($files[$i])."\n" .
            "Content-Disposition: attachment;\n" . " filename=\"".basename($files[$i])."\"; size=".filesize($files[$i]).";\n" .
            "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
        }
    }
    $message .= "--{$mime_boundary}--";
    $returnpath = "-f" . $from_pure;
    $ok = @mail($to, $subject, $message, $headers, $returnpath); 
    if($ok){ return $i; } else { return 0; }
}


/**
 * Take a file and email it to someone.
 */
function mail_file ($emailto, 
                    $emailfrom, 
                    $file )
{
    $my_subject     = 'File';
    $my_description = $my_subject;

    return remail($emailto, $emailfrom,
           $my_subject, $my_description, array($file) );
}


?>
