<?php
session_start();

define('SITE_NAME', 'PerpusKU');

$conn = mysqli_connect('localhost', 'root', '', 'perpustakaan') or die(mysqli_connect_error());

function alert($url, $msg)
{
    echo "<script>
            alert('$msg');
            location.href = '$url'
         </script>";
}

function requireLogin()
{
    if (!isset($_SESSION['user_id'])) {
        alert('login.php', 'Silahkan login terlebih dahulu');
    }
}

function currentUser($id)
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM `user` WHERE id = $id");
    return mysqli_fetch_assoc($result);
}

function flash($name, $message = "", $class = "success")
{
    if (!empty($message) && !isset($_SESSION[$name . '_flash'])) {
        $_SESSION[$name . '_flash'] = $message;
        $_SESSION[$name . '_class'] = $class;
    } else if (empty($message) && isset($_SESSION[$name . '_flash'])) {
        $class = $_SESSION[$name . '_class'];
        $flash = $_SESSION[$name . '_flash'];
        echo '<div class="alert alert-' . $class . '" role="alert">' . $flash . '</div>';
        unset($_SESSION[$name . '_flash']);
        unset($_SESSION[$name . '_class']);
    }
}

function old($key)
{
    if (isset($_POST[$key])) {
        return $_POST[$key];
    } else if (isset($_GET[$key])) {
        return $_GET[$key];
    }
}
