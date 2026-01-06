<?php
if (isset($_POST['note'])){
    if ($_POST['note'] != ''){
        $filename = 'notes/'.uniqid().'.txt';
        $myfile = fopen($filename, 'w');
        $contents = date("Y-m-d H:i:s").PHP_EOL.$_POST['ip'].PHP_EOL.$_POST['note'];
        fwrite($myfile, $contents);
        fclose($myfile);

        $headers = "From: rory@hogwild.uk\r\n";
        $headers .= "Reply-To: rory@hogwild.uk\r\n";
        $headers .= "Return-Path: rory@hogwild.uk\r\n";
        $headers .= "Organization: The Wild Hogs\r\n";
        $headers .= "X-Mailer: PHP".phpversion()."\r\n";
        $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
        $headers .= "X-Priority: 3\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        
        mail('rory@hogwild.uk', 'hogwild chinese note', $contents, $headers, '-f noreply@hogwild.uk');

        echo '<h1>谢谢</h1>';
    } else {
        echo '<h1>你忘記添加你的訊息了！</h1>';
    }
}
?>
