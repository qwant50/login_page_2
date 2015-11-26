<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/datarec/DBmanagement/config.php';

function SQLSelect($mysqli,$table)
{

    $sql = "SELECT * FROM $table;";
    $res = $mysqli->query($sql);

    //Returning JSON result;
    if ($res) {
        $outp = array();
        while ($rs = $res->fetch_array(MYSQLI_ASSOC)) $outp[] = $rs;
        $json = '"'.$table.'":' . json_encode($outp);
        $res->close();
        return $json;
         //file_put_contents('log_POST.log', print_r('answer'.$json, 1), FILE_APPEND);
    } else {
        echo "<b>Ошибка:</b> " . mysql_error() . "<br/>";
    }
}

;

function Logged($message)
{
    //  $serverTime = Date('YmdHis');
    //   $logFile = "result/log".$serverTime.".html";

    //  $logFileHandle = fopen($logFile, 'a');
    //  $messageReceived = trim($message);
    //  fwrite($logFileHandle, $message."\r\n");
    file_put_contents('log_POST.log', print_r('POST: ' . $_POST, 1), FILE_APPEND);
    file_put_contents('log_POST.log', print_r('answer' . $message, 1), FILE_APPEND);
    //   fclose($logFileHandle);

}

;

//Getting JSON request
//$answer = json_decode(file_get_contents('php://input'), true);

//echo (serialize($_POST));

//if (isset($answer['view']) && ($answer['view'] == 'cities')) {
    // echo json_encode($answer);
    echo('{'.SQLSelect($mysqli,'countries'));
    echo(','.SQLSelect($mysqli,'cities').'}');
    //file_put_contents('log_POST.log', print_r('answer:'.SQLSelect($mysqli,'countries').SQLSelect($mysqli,'cities'), 1), FILE_APPEND);
//};

if ($mysqli) $mysqli->close();


?>