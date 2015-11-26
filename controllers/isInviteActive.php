<?php

include($_SERVER['DOCUMENT_ROOT'] . "/datarec/DBmanagement/config.php");

function getInvite($mysqli, $data)
{

    $sql = "SELECT invite, status, date_status_ FROM invites where invite = $data;";
    $res = $mysqli->query($sql);

    //Returning JSON result;
    if ($res) {
        $rs = $res->fetch_object();
        if ($rs) {  //invite is present
            echo trim(json_encode($rs));
            $res->close();
            return true;
        } else {
            echo '{"invite":"false","status":"0","date_status_":"0000-00-00"}';  // invite not present

        }

        //file_put_contents('log_POST.log', print_r('answer'.$json, 1), FILE_APPEND);
    } else {
        echo "<b>Error :</b> " . mysql_error() . "<br/>";
    }
    $res->close();
    return false;
}

;

function addUser($mysqli, $data)
{


    $tLogin = $data['login'];
    $tPassword = $data['password'];
    if (isset($data['phone'])) $tPhone = $data['phone'];
    else $tPhone = '';
    if (isset($data['SelectedCity']['id_city']) && isset($data['SelectedCountry']['id_country']))  $tidCity = $data['SelectedCity']['id_city'];
    else  $tidCity = 'NULL';
    $tInvite = $data['invite'];

    $sql = "UPDATE invites SET STATUS =  '1', date_status_ = CURDATE( ) WHERE invite =  $tInvite AND status = '0';";
    $res = $mysqli->query($sql);


    $sql = "INSERT INTO users values (NULL, '$tLogin', '$tPassword', '$tPhone', $tidCity , '$tInvite');";
    $res = $mysqli->query($sql);

    // file_put_contents('log_POST.log',$data['SelectedCity']['id_city'].'----'.json_encode($data), FILE_APPEND);
    file_put_contents('log_POST.log', '======== ' . $sql, FILE_APPEND);

}

;


if (file_exists('log_POST.log')) unlink('log_POST.log');
//Getting JSON request
$answer = json_decode(file_get_contents('php://input'), true);

if (isset($answer['get']) && ($answer['get'] != '')) {
    // echo json_encode($answer);
    if (getInvite($mysqli, $answer['get'])) {
        if (isset($answer['post']) && ($answer['post'] != '')) {
            // echo json_encode($answer);
            addUser($mysqli, $answer['post']);

        };
    };
};

if ($mysqli) $mysqli->close();

?>