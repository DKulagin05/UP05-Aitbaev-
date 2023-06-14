<?php session_start();
if (empty($_SESSION['name'])) {
    header('location: ../auth/login');
}

require_once './db/connect.php';

if (isset($_POST['delete_from_basket'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];

    $query = "DELETE FROM basket WHERE user_id='$user_id' AND product_id='$product_id'";
    if ($conn->query($query) === TRUE) {
        header('location: basket');
    } else {
        echo "<p class='white-text'>Ошибка</p>";
    }
}


if (isset($_POST['order_submit'])) {
    $user_phone = $_SESSION['phone'];
    
    $basket_query = "SELECT products.name FROM basket
                     JOIN products ON basket.product_id = products.id
                     WHERE basket.user_id = ".$_SESSION['user_id'];
    $basket_result = $conn->query($basket_query);
    if ($basket_result) {
        while ($row = $basket_result->fetch_assoc()) {
            $house_name = $row['name'];
            $order_query = "INSERT INTO Orders (user_phone, house_name) 
                            VALUES ('$user_phone', '$house_name')";
            $conn->query($order_query);
        }
    }
    $basket_result->free();
    $delete_query = "DELETE FROM basket WHERE user_id=".$_SESSION['user_id'];
    if ($conn->query($delete_query) === TRUE) {
        header('location: success');
    } else {
        echo "<p class='white-text'>Ошибка</p>";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="assets/js/counter.js" defer></script>
    <script src="assets/js/basketPrice.js" defer></script>
    <title>Корзина</title>
</head>

<body>
    <?php include('includes/header.php') ?>
    <main>
        <section class="basket container">
            <div class="basket-total">
                <form action="basket" method="post">
                    <div class="block-button">
                        <input type="submit" name="order_submit" value="Заказать" class="yellow-button">
                    </div>
                </form>
            </div>
            <div class="title">
                Корзина
            </div>
            <div class="basket-content">
                <?php
                require_once('./db/connect.php');
                $user_id = $_SESSION['user_id'];
                $query = "SELECT basket.id, users.name, products.id, products.name, products.price, products.photo
                FROM basket
                JOIN users ON basket.user_id = users.id
                JOIN products ON basket.product_id = products.id
                WHERE basket.user_id = $user_id";
                if ($result = $conn->query($query)) {
                    foreach ($result as $row) {
                        echo "<div class='basket-card'>";

                        echo "<div class='basket-img'>";
                        $img_src = 'data:image/jpeg;base64,' . base64_encode($row['photo']);
                        echo "<img src='" . $img_src . "' alt='#'>";
                        echo "<form action='basket' method='post'>";
                        echo "<input type='hidden' name='user_id' value='" . $_SESSION['user_id'] . "'>";
                        echo "<input type='hidden' name='product_id' value='" . $row['id'] . "'>";
                        echo "<input type='submit' name='delete_from_basket' value='Убрать из корзины' class='black-button'>";
                        echo "</form>";
                        echo "</div>";

                        echo "<div class='basket-info'>";

                        echo "<div class='basket-title'>";
                        echo "<h3 class='bold-text'>" . $row['name'] . "</h3>";
                        echo "</div>";
                        
                        echo "<div class='basket-price'>";
                        echo "<p class='white-text'>Цена: " . $row['price'] .  " руб.</p>";
                        echo "</div>";

                        echo "</div>";
                        echo "</div>";
                    }
                    $result->free();
                }
                ?>

            </div>
        </section>

    </main>
</body>

</html>
<?php mysqli_close($conn); ?>