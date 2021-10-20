<?php
session_start();
include("functions.php");
check_session_id();
$pdo = connect_to_db();
$user_id = $_SESSION['user_id'];

$brand_name = $_POST['brand_name'];
$kinds = $_POST['kinds'];


if (
    !isset($_POST['kinds']) || $_POST['kinds'] == NULL
) {
    exit('種類が選択されていません');
}

try {
    $sql = 'SELECT * FROM item_master_table WHERE kinds=:kinds';

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':kinds', $kinds, PDO::PARAM_STR);
    $status = $stmt->execute();
} catch (Exception $e) {
    var_dump($e);
    exit();
}
if ($status == false) {
    $error = $stmt->errorInfo();
    exit('sqlError:' . $error[2]);
} else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $item_output .= '<form action="result_serch2.php" method="POST">';
        $item_output .= "<img src='{$result['item_image']}'width='375px'>";
        $item_output .= "<div>商品名:{$result["item_name"]}</div>";
        $item_output .= '<div>商品状態</div>';
        $item_output .= '<select name="item_status">';
        $item_output .=  '<option value="">-</option>';
        $item_output .= '<option value="新品">新品</option>';
        $item_output .= '<option value="中古">中古</option>';
        $item_output .= '</select><br>';
        $item_output .= '<div>サイズ</div>';
        $item_output .= '<select name="size">';
        $item_output .=  '<option value="">-</option>';
        $item_output .=     '<option value="23.0">23.0</option>';
        $item_output .=   '<option value="23.5">23.5</option>';
        $item_output .=      '<option value="24.0">24.0</option>';
        $item_output .=    '<option value="24.5">24.5</option>';
        $item_output .=   '<option value="25.0">25.0</option>';
        $item_output .= '<option value="25.5">25.5</option>';
        $item_output .=  '<option value="26.0">26.0</option>';
        $item_output .=  '<option value="26.5">26.5</option>';
        $item_output .=  '<option value="27.0">27.0</option>';
        $item_output .=  '<option value="27.5">27.5</option>';
        $item_output .=  '<option value="28.0">28.0</option>';
        $item_output .= '<option value="28.5">28.5</option>';
        $item_output .=  '<option value="29.0">29.0</option>';
        $item_output .=  '<option value="29.5">29.5</option>';
        $item_output .=  '<option value="30.0">30.0</option>';
        $item_output .= '</select><br>';
        $item_output .= "<input type='hidden' name='item_color' value='{$result["item_color"]}'>";
        $item_output .= "<input type='hidden' name='item_image' value='{$result["item_image"]}'>";
        $item_output .= "<input type='hidden' name='item_name' value='{$result["item_name"]}'>";
        $item_output .= "<input type='hidden' name='brand_name' value='{$result["brand_name"]}'>";
        $item_output .= "<input type='hidden' name='kinds' value='{$result["kinds"]}'>";
        $item_output .= "<input type='hidden' name='item_id' value='{$result["id"]}'>";
        $item_output .= "<button type=submit>検索</button>";
        $item_output .= "</form>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>検索</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form action="index2.php" method="POST" class="back">
        <input type="image" name="back" alt="back" src="img/iconmonstr-arrow-left-circle-thin.png" width="50px" height="50px" style="margin-top: 20px;">
    </form>
    <h2>商品名</h2>

    <?= $item_output ?>
    <!-- 
    <form action="" method="POST">
        <?= $item_output ?>
        <button value="">トレード</button>
    </form> -->

    <form action="contact2.php" method="POST" class="contact">
        <label>商品がない場合はこちら</label> <br>
        <input type="image" name="contact" alt="contact" src="img/iconmonstr-speech-bubble-thin.png" width="50px" height="50px">
    </form>
    <div class="sub-top">
        <a href="index2.php"><img alt="market" src="img/iconmonstr-shopping-cart-thin.png" width="50px" height="50px"> <br> マーケット</a> <br>

        <a href="media2.php"><img alt="media" src="img/safari_logo_icon_144917.png" width="50px" height="50px"> <br> メディア</a> <br>

        <a href="post_status.php"><img alt="post_status" src="img/iconmonstr-plus-circle-thin.png" width="50px" height="50px"> <br> 出品</a> <br>

        <a href="like.php"><img alt="like" src="img/iconmonstr-heart-thin.png" width="50px" height="50px"> <br> お気に入り</a> <br>

        <a href="my_page.php"><img alt="my_page" src="img/iconmonstr-user-male-thin.png" width="50px" height="50px"> <br>マイページ</a> <br>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script>
        $(function() {
            $('.menu-btn').on('click', function() {
                $('.menu').toggleClass('is-active');
            });
        }());

        // const fm = document.getElementById('fm');

        // function fm1() {
        //     fm.method = "post";
        //     fm.action = "post_check.php"
        // }

        // function fm2() {
        //     fm.method = "post";
        //     fm.action = "post_check.php"

        // }
    </script>
</body>

</html>