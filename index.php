<?php
session_start();
include_once 'dbconnect.php';
?>
<!doctype html>
<?php include("layouts/header.php");  ?>
<html lang="ru">


<body data-page="catalog">
    <div class="container">
        <ul id="goods" class="list-unstyled">
            <img src="img/loading.gif" alt="" />
        </ul>
    </div>

    <script id="catalog-template" type="text/template">
        <% _.each(goods, function(good) { %>
            <li class="good-item row">
                <div class="col-md-4">
                    <img style="width:200px; height:200px;"class="good-item__img" src="<%- good.img %>" />
                </div>
                <div class="col-md-8">
                    <div class="good-item__id">Артикул <%= good.id %></div>
                    <div class="good-item__name"><%- good.name %></div>
                    <div class="good-item__article"><%- good.article %></div>
                    <div class="good-item__price"><%= good.price %> руб.</div>
                    <button
                        class="good-item__btn-add btn btn-info btn-sm js-add-to-cart"
                        data-id="<%= good.id %>"
                        data-name="<%- good.name %>"
                        data-price="<%= good.price %>"
                    >Добавить в корзину</button>
                </div>
            </li>
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

<?php include("layouts/footer.php");  ?>
