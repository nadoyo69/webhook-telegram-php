<?php
echo "#############---------------- NADOYO ----------------############# <br>\n";

if ($_GET['auth']=="3b68b6a4f1ebeec7bae41cd0d3fab46a") {

    //koneksi Database
    include_once("database.inc");
    $db = new mysqli($db_host, $db_user, $db_pass, $db_db);
    if ($db->connect_errno) {
        echo("Connect failed: ". $mysqli->connect_error);
        exit();
    }

    //Data Data Telegram
    $update = json_decode(file_get_contents("php://input"), true);
    $chatID = $update["message"]["chat"]["id"];
    $username = $update["message"]["from"]["username"];
    $Tmessage = $update["message"]["text"];

    $_message = (explode(" ", $Tmessage));
    $akun = preg_replace("/[^a-zA-Z]/", "", $_message[0]);
    $tanggal = $_message[1];
    //query
    $sql = "SELECT * from data where accountcode='$akun' AND date='$tanggal' ";
    $qData = $db->query($sql);
    if ($qData->num_rows>0) {
        foreach ($qData as $key => $data) {
            //kirim data callback
            senTele($chatID, $akun, $username, $data['total'], $data['server']);
        }
    } else {
        //kirim data callback
        senTele($chatID, $akun, $username, "0");
    }
} else {
    echo "Salah Auth Bosku";
}

//function kirim ke telegram
function senTele($chatID, $akun, $username, $data, $server)
{
    $botToken = "TOKEN";
    $website = "https://api.telegram.org/bot" . $botToken;
    $params = [
        'chat_id' => $chatID,
        'text' => "Hi @$username
    [#] Total Call Akun $akun $data di Server $server"];

    $ch = curl_init($website . '/sendMessage');
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
}
