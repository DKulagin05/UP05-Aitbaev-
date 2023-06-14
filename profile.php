<?php
session_start();
if ($_SESSION['name'] === false || empty($_SESSION['name'])) {
    header('location: /');
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>Мой профиль</title>
</head>

<body>
    <?php include('includes/header.php') ?>
    <main>
        <section class="date container">
            <div class="white-text">Мои данные</div>
            <div class="date-content">
                <?php
                $phone = $_SESSION['phone'];
                $name = $_SESSION['name'];
                echo "<p class='gray-text'>Номер телефона: " . $phone . "</p>";
                echo "<p class='gray-text'>Номер заказа: " . $name . "</p>";
                ?>
            </div>
        </section>
        <section class="orders container">
            <div class="title">Мои заказы</div>
            <div class="orders-content">
                <?php
                require_once('./db/connect.php');

                $phone = $_SESSION['phone'];

                $query = "SELECT * FROM orders WHERE user_phone = '$phone' ORDER BY id DESC";
                if ($result = $conn->query($query)) {
                    foreach ($result as $row) {
                        echo "<div class='orders-elem'>";
                        echo "<div class='orders-elem-info'>";
                        echo "<h3 class='white-text'>" . $row['order_time'] . "</h3>";
                        echo "<p class='gray-text'>Номер заказа: " . $row['id'] . "</p>";
                        echo "<p class='gray-text'>Номер телефона: " . $row['user_phone'] . "</p>";
                        echo "<p class='gray-text'>Номер дома: " . $row['house_name'] . "</p>";
                        echo "</div>";
                        echo "</div>";
                    }
                    $result->free();
                } else {
                    echo "Ошибка";
                }
                ?>
            </div>
        </section>
    </main>
</body>

</html>

<?php mysqli_close($conn); ?>