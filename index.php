<?php session_start();

require_once './db/connect.php';

if (isset($_POST['free_order_submit'])) {
    $name = "Белый шоколад с клубникой";
    $phone = $_SESSION['phone'];
    $order_time = date("Y-m-d H:i:s");
    $query = "INSERT INTO orders (chocolate_name, user_phone, order_time) VALUES ('$name', '$phone', '$order_time')";
    mysqli_query($conn, $query);
    header('Location: success');
    exit();
}

if (isset($_POST['order_submit'])) {
    $chocolate_name = $_POST['chocolate'];
    $name = $chocolate_name;
    $phone = $_POST['phone'];
    $index = $_POST['index'];
    $order_time = date("Y-m-d H:i:s");
    if (empty($name) || empty($phone) || empty($index)) {
        echo "<p class='white-text'>Заполните все поля</p>";
    } else {
        $query = "INSERT INTO orders (chocolate_name, user_phone, order_time) VALUES ('house_name', '$phone', '$order_time')";
        mysqli_query($conn, $query);
        header('Location: success');
        exit();
    }
}
?>

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="assets/js/switchLight.js" defer></script>
    <script src="assets/js/formValid.js" defer></script>
    <script src="assets/js/scroll.js" defer></script>
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>Главная</title>
</head>

<body>
    <?php include('includes/header.php') ?>

    <main>
        <section class="production" style="background: linear-gradient(0deg, rgb(0,0,0) 0%, rgba(0,0,0,0.5) 53%, rgba(0,0,0,0) 100%), url('/assets/img/production/test3.jpg'); background-repeat: no-repeat; background-size: cover">
            <div class="container">
                <p class="white-text" id="text1">Качественная работа</p>
                <p class="white-text" id="text2">Быстро найдем вам дом!</p>
                <div class="block-button">
                    <button class="black-button" id="catalog-button">
                        Перейти в каталог
                    </button>
                    <script>
                        document.getElementById("catalog-button").addEventListener("click", function() {
                            window.location.href = "/products";
                        });
                    </script>
                </div>
            </div>
        </section>

        <section class="recommend container">
            <div class="title">
                Рекомендуемые предложения
            </div>
            <div class="recommend-content">
                <?php
                require_once './db/connect.php';
                $query = "SELECT * FROM products WHERE is_recommend = 1";
                if ($result = $conn->query($query)) {
                    foreach ($result as $row) {
                        echo "<div class='recommend-elem'>";

                        $img_src = 'data:image/jpeg;base64,' . base64_encode($row['photo']);
                        echo "<img src='" . $img_src . "' alt='#'>";

                        echo "<div class='recommend-elem-title'>";
                        echo "<h3 class='bold-text'>" . $row['name'] . "</h3>";
                        echo "<p class='white-text'>Цена: " . $row['price'] . " руб.</p>";
                        echo "</div>";

                        echo "<div class='recommend-elem-description'>";
                        echo "<p class='small-text'> " . $row['description'] . " </p>";
                        echo "</div>";

                        echo "<div class='block-button'>";
                        echo "<a href='/products' class='yellow-button'>Посмотреть</a>";
                        echo "</div>";

                        echo "</div>";
                    }
                }
                ?>
            </div>
        </section>

        <section class="news container">
            <div class="news-content">
                <div class="news-img">
                    <div class="title">
                        Скоро в продаже!
                    </div>
                    <img src="./assets/img/news/house7.jpg" alt="">
                </div>
                <div class="news-text">
                    <h3 class="bold-text">
                        Эксклюзивный участок!
                    </h3>
                    <p class="gray-text">
                        У нас есть отличная возможность предложить вам привлекательный участок в аренду, <br>
                         который может стать идеальным местом для ваших планов и проектов.<br>
                        Наш участок в аренду предлагает вам простор и свободу для реализации ваших идей.  <br>
                        то участок с прекрасным расположением в живописном районе, окруженном природой и красивыми пейзажами.
                       Он обладает удобным доступом к основным дорогам и инфраструктуре, <br> что делает его идеальным местом для различных видов деятельности. <br>
                        Наш участок в аренду имеет достаточное пространство для размещения различных объектов или структур, таких как склады,  <br> или спокойного вечера
                        в кругу семьи и друзей.
                    </p>
                    <p class="small-text">
                        У вас есть возможность заявить о предложении первым!
                        <br> После нажатия на кнопку, мы ответим  в течение 3 дней.
                    </p>
                    <form method="POST" action="/">
                        <input type="submit" class="yellow-button" name="free_order_submit" value="Оставить заявку">
                    </form>
                </div>
            </div>
        </section>

        <section class="about container">
            <div class="about-content">
                <div class="about-text">
                    <div class="title">
                        Как работает RestateDom?
                    </div>
                    <p class="gray-text">
                        Наша компания по недвижимости предлагает полный спектр услуг, <br>
                        связанных с покупкой, продажей, арендой и управлением недвижимости. <br>
                        Мы стремимся обеспечить нашим клиентам эффективное и
                        <br> профессиональное взаимодействие на каждом этапе процесса.
                    </p>
                    <p class="gray-text">
                       Консультации и оценка: Наша команда экспертов готова предоставить вам консультации и <br>
                        руководство по всем вопросам, связанным с недвижимостью. <br>
                         Мы поможем вам разобраться в текущем рынке, проведем оценку вашей собственности и <br>
                          дадим рекомендации по цене и стратегии продажи или аренды.
                          <br>
                       Маркетинг и продвижение: Мы разрабатываем комплексные маркетинговые стратегии, <br>
                        чтобы ваша недвижимость была максимально видимой и привлекательной для потенциальных покупателей или арендаторов. <br>
                        Мы используем различные каналы, включая наш веб-сайт,  <br>
                        социальные сети, онлайн-площадки и сеть партнеров, чтобы достичь наибольшей охватности. <br>
                        Просмотры и переговоры: Мы организуем просмотры недвижимости для заинтересованных покупателей или арендаторов, <br>
                        обеспечивая полную информацию о объекте. Мы ведем переговоры с потенциальными клиентами,  <br>
                        представляем ваши интересы и работаем на достижение наилучших условий сделки. <br>
                    </p>
                </div>
                <div class="about-img">
                    <img src="./assets/img/production/test2.jpg" alt="#">
                </div>

            </div>
        </section>

        <section class="order container">
            <div class="title">
                Оставьте заявку!
            </div>
            <div class="order-content">
                <div class="order-text">
                    <p class="gray-text">
                        Для того, чтобы мы приняли Ваш заказ, <br>
                        нужно заполнить форму.
                        <br>
                       Звонки работают по всей России в течение 3-ёх дней
                    </p>
                    <p class="white-text">
                        Если хотите забронировать недвижимость, <br>
                        Вам нужно зарегестрироваться
                    </p>
                    <div class="block-button">
                        <a href="../auth/register" class="yellow-button">Зарегестрироваться</a>
                    </div>
                </div>
        </section>
    </main>
</body>

</html>
<?php mysqli_close($conn); ?>