<?php
if (isset($_POST['note'])){
    if ($_POST['note'] != ''){
        $filename = 'notes/'.uniqid().'.txt';
        $myfile = fopen($filename, 'w');
        $contents = date("Y-m-d H:i:s").PHP_EOL.$_POST['ip'].PHP_EOL.$_POST['note'];
        fwrite($myfile, $contents);
        fclose($myfile);

        $headers = 'From: noreply@hogwild.uk'.'\r\n'.'Reply-To: noreply@hogwild.uk'.'\r\n'.'X-Mailer: PHP/'.phpversion().'Content-type: text/html; charset=utf-8'.'\r\n';
        mail('rory@hogwild.uk', 'hogwild chinese note', 'new note', $headers,'-f noreply@hogwild.uk');

        echo '<h1>谢谢</h1>';
    } else {
        echo '<h1>你忘記添加你的訊息了！</h1>';
    }
}
?>
