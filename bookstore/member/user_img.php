<?php
// 建立與數據庫的連接
$dsn = 'mysql:host=173.201.253.251;dbname=project;charset=utf8';

$username = 'admin'; //帳號
$password = 'h5MFu8ZVsRrw8PT'; //密碼

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// 查詢資料庫
$sql = "SELECT family_name FROM member";
try {
    $stmt = $pdo->query($sql);
    while ($row = $stmt->fetch()) {
        $color = stringToHslColor($row['family_name'], 50, 50);

        $initial = mb_substr($r['name'], 0, 1, "UTF-8");
        $initial = strtoupper($initial);

        // echo "<div class='user-image' style='background-color: $color;'>$initial</div>";
    }
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage();
}

function stringToHslColor($str, $s, $l)
{
    $hash = 0;
    for ($i = 0; $i < strlen($str); $i++) {
        $hash = ord($str[$i]) + (($hash << 5) - $hash);
    }

    $h = $hash % 360;
    return 'hsl(' . $h . ', ' . $s . '%, ' . $l . '%)';
}
?>
<style>
    .user-image {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1em;
        color: white;
    }
</style>