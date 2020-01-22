<?php
session_start();
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8"/>
  <title>Админ-панель</title>
  <link href="css/main.css" rel="stylesheet" type="text/css">
</head>
<body>
  <?php   if (isset($_SESSION['usr_id'])) { ?>
  <?php
    $host = 'localhost';  // Хост, у нас все локально
    $user = 'root';    // Имя созданного вами пользователя
    $pass = ''; // Установленный вами пароль пользователю
    $db_name = 'db_kanctovari';   // Имя базы данных
    $link = mysqli_connect($host, $user, $pass, $db_name); // Соединяемся с базой

    // Ругаемся, если соединение установить не удалось
    if (!$link) {
      echo 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
      exit;
    }

    //Если переменная Name передана
    if (isset($_POST["Name"])) {
      //Если это запрос на обновление, то обновляем
      if (isset($_GET['red_id'])) {
          $sql = mysqli_query($link, "UPDATE `users` SET `name` = '{$_POST['Name']}', `email` = '{$_POST['Email']}',`password` = '{$_POST['Password']}' WHERE `id`={$_GET['red_id']}");
      } else {
          //Иначе вставляем данные, подставляя их в запрос
          $sql = mysqli_query($link, "INSERT INTO `users` (`name`, `email`,`password`)
           VALUES ('{$_POST['Name']}',
             '{$_POST['Email']}',
             '{$_POST['Password']}')");
      }

      //Если вставка прошла успешно
      if ($sql) {
        echo '<p>Успешно!</p>';
      } else {
        echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
      }
    }

    if (isset($_GET['del_id'])) { //проверяем, есть ли переменная
      //удаляем строку из таблицы
      $sql = mysqli_query($link, "DELETE FROM `users` WHERE `id` = {$_GET['del_id']}");
      if ($sql) {
        echo "<p> удален.</p>";
      } else {
        echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
      }
    }

    //Если передана переменная red_id, то надо обновлять данные. Для начала достанем их из БД
    if (isset($_GET['red_id'])) {
      $sql = mysqli_query($link, "SELECT `id`, `name`, `email`,`password` FROM `users` WHERE `id`={$_GET['red_id']}");
      $product = mysqli_fetch_array($sql);
    }
  ?>
  <div class="col-md-12">
  <div class="admins col-md-3">
  <h3>Пользователи</h3>
  <form name="one" action="" method="post">
    <table>
      <tr>
        <td>Имя:</td>
        <td><input type="text" name="Name" value="<?= isset($_GET['red_id']) ? $product['Name'] : ''; ?>"></td>
      </tr>
      <tr>
        <td>Почта:</td>
        <td><input type="text" name="Email"  value="<?= isset($_GET['red_id']) ? $product['Email'] : ''; ?>"> </td>
      </tr>
      <tr>
        <td>Пароль:</td>
        <td><input type="text" name="Password"  value="<?= isset($_GET['red_id']) ? $product['Password'] : ''; ?>"></td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" value="OK"></td>
      </tr>
    </table>
  </form>
  <table border='1'>
    <tr>
      <td>Имя</td>
      <td>Почта</td>
      <td>Пароль</td>
      <td>Удаление</td>
      <td>Редактирование</td>
    </tr>
    <?php
      $sql = mysqli_query($link, 'SELECT `id`, `name`, `email`,`password` FROM `users`');
      while ($result = mysqli_fetch_array($sql)) {
        echo '<tr>' .
             "<td>{$result['name']}</td>" .
             "<td>{$result['email']}</td>" .
             "<td>{$result['password']} </td>" .
             "<td><a href='?del_id={$result['id']}'>Удалить</a></td>" .
             "<td><a href='?red_id={$result['id']}'>Изменить</a></td>" .
             '</tr>';
      }
    ?>
  </table>
  <p><a href="?add=new">Добавить</a></p>
</div>
<?php

  //Если переменная Name передана

  if (isset($_POST["Good"])) {
    //Если это запрос на обновление, то обновляем
    if (isset($_GET['red_id2'])) {
        $sql = mysqli_query($link, "UPDATE `goods` SET `good` = '{$_POST['Good']}',
          `category_id` = '{$_POST['Category_id']}',`brand_id` = '{$_POST['Brand_id']}',`price` = '{$_POST['Price']}',`rating` = '{$_POST['Rating']}',`photo` = '{$_POST['Photo']}'
          WHERE `id`={$_GET['red_id2']}");
    } else {
        //Иначе вставляем данные, подставляя их в запрос
        $sql = mysqli_query($link, "INSERT INTO `goods` (`good`, `category_id`,`brand_id`,`price`,`rating`,`photo`)
         VALUES ('{$_POST['Good']}','{$_POST['Category_id']}','{$_POST['Brand_id']}','{$_POST['Price']}','{$_POST['Rating']}'
           '{$_POST['Photo']}')");
    }

    //Если вставка прошла успешно
    if ($sql) {
      echo '<p>Успешно!</p>';
    } else {
      echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
    }
  }

  if (isset($_GET['del_id2'])) { //проверяем, есть ли переменная
    //удаляем строку из таблицы
    $sql = mysqli_query($link, "DELETE FROM `goods` WHERE `id` = {$_GET['del_id2']}");
    if ($sql) {
      echo "<p>Товар удален.</p>";
    } else {
      echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
    }
  }

  //Если передана переменная red_id, то надо обновлять данные. Для начала достанем их из БД
  if (isset($_GET['red_id2'])) {
    $sql = mysqli_query($link, "SELECT `id`, `good`, `category_id`,`brand_id`,`price`,`rating`,`photo` FROM `goods` WHERE `id`={$_GET['red_id2']}");
    $product = mysqli_fetch_array($sql);
  }
?>
<div class="article_servise_taxi col-md-9 ">
  <h3>Товары</h3>
<form name="two" action="" method="post">

  <table>
    <tr>
      <td>Название:</td>
      <td><input type="text" name="Good" value="<?= isset($_GET['red_id2']) ? $product['Good'] : ''; ?>"></td>
    </tr>
    <tr>
      <td>Категория_№:</td>
      <td><input type="text" name="Category_id" value="<?= isset($_GET['red_id2']) ? $product['Category_id'] : ''; ?>"></td>
    </tr>
    <tr>
      <td>Брэнд_№:</td>
      <td><input type="text" name="Brand_id" value="<?= isset($_GET['red_id2']) ? $product['Brand_id'] : ''; ?>"></td>
    </tr>
    <tr>
      <td>Цена:</td>
      <td><input type="text" name="Price"  value="<?= isset($_GET['red_id2']) ? $product['Price'] : ''; ?>"> </td>
    </tr>
    <tr>
      <td>Описание:</td>
      <td><input type="text" name="Rating"  value="<?= isset($_GET['red_id2']) ? $product['Rating'] : ''; ?>"> </td>
    </tr>
    <tr>
      <td>Фото:</td>
      <td><input type="text" name="Photo"  value="<?= isset($_GET['red_id2']) ? $product['Photo'] : ''; ?>"> </td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" value="OK"></td>
    </tr>
  </table>
</form>
<table border='1'>
  <tr>
    <td>Название:</td>
    <td>Категория_№:</td>
    <td>Брэнд_№:</td>
    <td>Цена:</td>
    <td>Описание:</td>
    <td>Фото:</td>
    <td>Удаление</td>
    <td>Редактирование</td>
  </tr>
  <?php
    $sql = mysqli_query($link, 'SELECT `id`, `good`, `category_id`,`brand_id`,`price`,`rating`,`photo` FROM `goods`');
    while ($result = mysqli_fetch_array($sql)) {
      echo '<tr>' .
           "<td>{$result['good']}</td>" .
           "<td>{$result['category_id']}</td>" .
           "<td>{$result['brand_id']}</td>" .
           "<td>{$result['price']}</td>" .
           "<td>{$result['rating']}</td>" .
           "<td>{$result['photo']}</td>" .
           "<td><a href='?del_id2={$result['id']}'>Удалить</a></td>" .
           "<td><a href='?red_id2={$result['id']}'>Изменить</a></td>" .
           '</tr>';
    }
  ?>
</table>
<p><a href="?add2=new">Добавить</a></p>
</div>
</div>
<div class="col-md-12">
<div class="clients col-md-3">
<h3>Клиенты</h3>
<table border='1'>
<tr>
  <td>Имя</td>
  <td>Почта</td>
  <td>Телефон</td>
  <td>Дата</td>
  <td>Удаление</td>
</tr>
<?php
  $sql = mysqli_query($link, 'SELECT `id`, `name`, `email`,`phone`,`dt_added` FROM `clients`');
  while ($result = mysqli_fetch_array($sql)) {
    echo '<tr>' .
         "<td>{$result['name']}</td>" .
         "<td>{$result['email']}</td>" .
         "<td>{$result['phone']} </td>" .
         "<td>{$result['dt_added']} </td>" .
         "<td><a href='?del_id3={$result['id']}'>Удалить</a></td>" .
         '</tr>';
  }
  if (isset($_GET['del_id3'])) { //проверяем, есть ли переменная
    //удаляем строку из таблицы
    $sql = mysqli_query($link, "DELETE FROM `goods` WHERE `id` = {$_GET['del_id3']}");
    if ($sql) {
      echo "<p>Товар удален.</p>";
    } else {
      echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
    }
  }
?>
</table>
</div>
<div class="details col-md-3">
<h3>Подробности</h3>
<table border='1'>
<tr>
  <td>Заказ_ID</td>
  <td>Товар_ID</td>
  <td>Товар</td>
  <td>Цена</td>
  <td>Количество</td>
  <td>Удаление</td>
</tr>
<?php
  $sql = mysqli_query($link, 'SELECT `good_id`, `order_id`, `good`, `price`,`count` FROM `details`');
  while ($result = mysqli_fetch_array($sql)) {
    echo '<tr>' .
         "<td>{$result['good_id']}</td>" .
         "<td>{$result['order_id']}</td>" .
         "<td>{$result['good']} </td>" .
         "<td>{$result['price']} </td>" .
         "<td>{$result['count']} </td>" .
         "<td><a href='?del_id4={$result['good_id']}'>Удалить</a></td>" .
         '</tr>';
  }
  if (isset($_GET['del_id4'])) { //проверяем, есть ли переменная
    //удаляем строку из таблицы
    $sql = mysqli_query($link, "DELETE FROM `goods` WHERE `id` = {$_GET['del_id4']}");
    if ($sql) {
      echo "<p>Товар удален.</p>";
    } else {
      echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
    }
  }
?>
</table>
</div>
<div class="orders col-md-2">
<h3>Заказ</h3>
<table border='1'>
<tr>
  <td>Клиент_ID</td>
  <td>Адрес</td>
  <td>Сообщение</td>
  <td>Дата</td>
  <td>Удаление</td>
</tr>
<?php
  $sql = mysqli_query($link, 'SELECT `id`, `client_id`, `address`,`message`,`dt_added` FROM `orders`');
  while ($result = mysqli_fetch_array($sql)) {
    echo '<tr>' .
         "<td>{$result['client_id']}</td>" .
         "<td>{$result['address']}</td>" .
         "<td>{$result['message']} </td>" .
         "<td>{$result['dt_added']} </td>" .
         "<td><a href='?del_id5={$result['id']}'>Удалить</a></td>" .
         '</tr>';
  }
  if (isset($_GET['del_id5'])) { //проверяем, есть ли переменная
    //удаляем строку из таблицы
    $sql = mysqli_query($link, "DELETE FROM `goods` WHERE `id` = {$_GET['del_id5']}");
    if ($sql) {
      echo "<p>Товар удален.</p>";
    } else {
      echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
    }
  }
?>
</table>
</div>
</div>
<?php } else echo "НЕТ ПРАВ ДОСТУПА!"; ?>
</body>
</html>
