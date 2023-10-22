<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set("Asia/Taipei");

try
{
    $dsn = "mysql:host=localhost;dbname=network;charset=utf8";
    $conn = new PDO($dsn,'root','immgt');
    
    $sql = 'select * from board order by date desc';
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
    if(isset($result[0])) {
        $count = get_message_count($conn);

        foreach ($result as $key => $row) {
            foreach ($count as $c) {
                if($row['id'] == $c['message_id']) {
                    $result[$key]['count'] = $c['like'];
                }
                else {
                    $result[$key]['count'] = 0;
                }
            }
        }

        echo json_encode($result);
    }
    else {
        echo '';
    }

}
catch(Exception $e) {

}

function get_message_count($conn) {
    $sql = 'select `message_id`, `like` from message_like ';
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}