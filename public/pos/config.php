<?php
session_start();

$user = 'root';
$pass = '';
$host = '127.0.0.1';
$db = 'aspoo';
$cookie_name = 'APOTEK_COOKIES';
$url = 'http://localhost:8000/pos/';
$this_url = $_SERVER['REQUEST_URI'];
$conn = new mysqli($host, $user, $pass, $db);
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

function handleError($query)
{
    global $conn;
    if (!$query) {

        echo "error" . PHP_EOL;
        echo $conn->error;
        exit();
    }
}
function handleErrorApi($query)
{
    global $conn;
    if (!$query) {
        echo json_encode([
            'error' => 1,
            'msg' => $conn->error
        ]);
        exit();
    }
}
function describe($table)
{
    global $conn;
    $rw = $conn->query("DESCRIBE $table");
    while ($p = $rw->fetch_assoc()) {
        print_r($p['Field'] . ",");
    }
}

/*
*
* $table 
* $column = Array [column search, column to show]
* $value
*
*/
function queryString($table, $column, $value)
{
    global $conn;
    $word = "SELECT * FROM $table WHERE " . $column[0] . "='$value'";
    return $conn->query($word)->fetch_assoc()[$column[1]];
}
function middleware()
{
    global $url;
    global $conn;
    global $cookie_name;
    if (isset($_COOKIE[$cookie_name])) {
        $id = encrypt_decrypt('decrypt', $_COOKIE[$cookie_name]);
        $query = $conn->query("SELECT * FROM user WHERE user_id = '$id'")->fetch_assoc();
        handleError($query);
        $_SESSION['role'] = $query['user_role'];
        $id = $query['user_id'];
        $conn->query("UPDATE user SET user_status=1 WHERE user_id='$id'");
        unset($query['user_password']);
        unset($query['user_role']);
        unset($query['user_status']);
        $_SESSION['data'] = $query;
        $cookie = encrypt_decrypt('encrypt', $id);
        setcookie($cookie_name, $cookie, time() + (86400 * 30), "/");
    }
    if (is_null($_SESSION['role'])) header("Location: " . $url . "login.php");
}

function encrypt_decrypt($action, $string)
{
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = '8MEFKfJn2d8Z2X-j';
    $secret_iv = '23wV6#2F#TXqpYW4';

    // hash
    $key = hash('sha256', $secret_key);

    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ($action == 'encrypt') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}

function query($query)
{
    global $conn;
    $query = $conn->query($query);
    handleError($query);
}
function refresh()
{
    header("Location: ./");
}
function createLog($msg)
{
    $query = "INSERT INTO log_data(log_msg) SELECT obat_stok FROM obat VALUES('$msg')";
    query($query);
}

function getData($query)
{
    global $conn;
    $rt = $conn->query($query);
    $r = array();
    while ($s = $rt->fetch_assoc()) {
        $r[] = $s;
    }
    return $r;
}

function tgl_indo($tanggal)
{
    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);

    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun

    return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];
}
