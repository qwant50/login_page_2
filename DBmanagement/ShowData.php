<?php
/**
 * Created by PhpStorm.
 * User: qwant
 * Date: 29.09.2015
 * Time: 23:15
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/datarec/DBmanagement/config.php';

function ShowData($mysqli, $data)
{

    $sql = "SELECT * FROM $data;";
    $res = $mysqli->query($sql);
    //Формируем HTML таблицу с результатами
    if ($res) {
        echo '<div class="panel panel-default">';
        echo "<div class='panel-heading'>Table:  $data  Результаты: загружено  $res->num_rows  записей<br/></div>";
        echo "<table class='table table-hover table-striped table-condensed'>";
        // Creating head of table
        $finfos = mysqli_fetch_fields($res);
        echo '<thead><tr>';
        foreach ($finfos as $val) {
            echo "<th> $val->name </th>";
        };
        echo '</tr></thead><tbody>';

        while ($row = mysqli_fetch_assoc($res)) {

            while (list($var, $val) = each($row)) {
                echo "<td> $val </td>";
            };
            echo '</tr>';
        };
        echo '</tbody></table>';
        echo '</div>';
    } else {
        echo "<b>Ошибка:</b> " . mysql_error() . "<br/>";
    }
    $res->close();
};

$data = $_GET['view'];
$table_names = array('countries','cities','invites','users');
echo '<div class="row"><div class="col-xs-12"><div id="MainBody"><br>';
if (in_array($data, $table_names)) ShowData($mysqli, $data);
echo '</div></div></div>';
if ($mysqli) $mysqli->close();

?>