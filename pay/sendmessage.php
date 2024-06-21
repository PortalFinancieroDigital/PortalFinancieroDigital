<?php
    $content = '';
    foreach($_POST as $key => $value) {
        if($value){
            $content .= "<b>$key</b>: <i>$value</i>\n";
        }
    }
    if(trim($content)) {
        $content = "<b>Message from site: </b>\n".$content;

        $apiToken = "6815852505:AAEjo5-qL2gqnO5q_Z9_FohaA11CVhxLPBk";
        $data = [
            'chat_id' => '@SoloparaMensajesBOtssss',
            'text' => $content,
            'parse_mode' => 'HTML'
        ];
        $response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?".http_build_query($data));
    }
?>