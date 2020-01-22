<?php
session_start();
include_once 'dbconnect.php';
?>
<!doctype html>
<?php include("layouts/header.php");  ?>
<html lang="ru">

<body data-page="cart">
    <div class="container">

        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Артикул</th>
                        <th>Название</th>
                        <th>Цена</th>
                        <th>Количество</th>
                        <th>Сумма</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="cart">
                    <tr><td colspan="6"><img src="img/loading.gif" alt="" /></td></tr>
                </tbody>
            </table>
        </div>
        <div>Итого: <span id="total-cart-summa">65000</span> руб.</div>
        <a class="btn btn-info" href="order.php">Оформить заказ</a>
    </div>

    <script id="cart-template" type="text/template">
        <% _.each(goods, function(good) { %>
            <tr class="cart-item js-cart-item" data-id="<%= good.id %>">
                <td><%= good.id %></td>
                <td><%- good.name %></td>
                <td><%= good.price %> руб.</td>
                <td>
                    <span
                        class="cart-item__btn-dec-count js-change-count"
                        title="Уменьшить на 1"
                        data-id="<%= good.id %>"
                        data-delta="-1"
                    >
                        <span class="glyphicon glyphicon-minus"></span>
                    </span>
                    <span class="js-count"><%= good.count %></span>
                    <span
                        class="cart-item__btn-inc-count js-change-count"
                        title="Увеличить на 1"
                        data-id="<%= good.id %>"
                        data-delta="1"
                    >
                        <span class="glyphicon glyphicon-plus"></span>
                    </span>
                </td>
                <td><span class="js-summa"><%= good.count * good.price %></span> руб.</td>
                <td>
                    <span class="cart-item__btn-remove js-remove-from-cart" title="Удалить из корзины" data-id="<%= good.id %>">
                        <span class="glyphicon glyphicon-remove"></span>
                    </span>
                </td>
            </tr>
        <% }); %>
    </script>

    <script src="js/vendor/jquery.min.js" type="text/javascript"></script>
    <script src="js/vendor/jquery.cookie.js" type="text/javascript"></script>
    <script src="js/vendor/underscore.min.js" type="text/javascript"></script>
    <script src="js/modules/catalog.js" type="text/javascript"></script>
    <script src="js/modules/cart.js" type="text/javascript"></script>
    <script src="js/modules/compare.js" type="text/javascript"></script>
    <script src="js/modules/main.js" type="text/javascript"></script>
</body>
</html>
