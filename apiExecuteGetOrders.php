<html>
<head>
    <link href="CSS/designs.css" rel="stylesheet">
</head>
</html>
<?php
require 'vendor/autoload.php';

use ShopExpress\ApiClient\ApiClient;
use ShopExpress\ApiClient\Response\ApiResponse;

$date_FROM = $_POST['dateFrom'];
$date_TO = $_POST['dateTo'];

try {
    $ApiClient = new ApiClient(
        'lNwzuV_Gb',
        'admin',
        'http://newshop.kupikupi.org/adm/api/'
    );

    $response = $ApiClient->get("orders", [
        'date_from' => $date_FROM,
        'date_to' => $date_TO
    ]);

} catch (\ShopExpress\ApiClient\Exception\NetworkException $e) {
    echo "ОШИБКА NetworkException:<br>" . $e;
} catch (\ShopExpress\ApiClient\Exception\RequestException $e) {
    echo "ОШИБКА RequestException:<br>" . $e;
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="https://momentjs.com/downloads/moment.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#data').after('<div id="nav"></div>');

        var rowsShown = 10; //Сколько вывести
        var rowsTotal = $('#data tbody tr').length; //Количество
        var numPages = rowsTotal / rowsShown; //Страницы

        for (i = 0; i < numPages; i++) {
            var pageNum = i + 1;
            $('#nav').append('<div class="pageNum"><a href="#" rel="' + i + '">' + pageNum + '</a></div>');
        }

        $('#data tbody tr').hide(); //Скрываем таблицу
        $('#data tbody tr').slice(0, rowsShown).show(); //Показываем ровно столько, сколько указали

        $('#nav a:first').addClass('active');
        $('#nav a').bind('click', function () {
            $('#nav a').removeClass('active');
            $(this).addClass('active');
            var currPage = $(this).attr('rel');
            var startItem = currPage * rowsShown;
            var endItem = startItem + rowsShown;
            $('#data tbody tr').css('opacity', '0.0').hide().slice(startItem, endItem).css('display', 'table-row').animate({opacity: 1}, 300);
        });
    });
</script>
<table id="data" class="display" style="width:100%">
    <thead>
    <tr>
        <th>ID Заказа</th>
        <th>Телефон</th>
        <th>Почта</th>
        <th>Адрес</th>
        <th>ФИО</th>
        <th>Сумма</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($response['orders'] as $order): ?>
        <tr>
            <?php
            $order_order_id = "(неизвестно)";
            $order_phone = "(неизвестно)";
            $order_email = "(неизвестно)";
            $order_address = "(неизвестно)";
            $order_fio = "(неизвестно)";
            $order_sum = "(неизвестно)";
            $order_currency = "(неизвестно)";

            if (!empty($order['order_id'])) {
                $order_order_id = $order['order_id'];
            } else {
                $order_order_id = "(неизвестно)";
            }

            if (!empty($order['phone'])) {
                $order_phone = $order['phone'];
            } else {
                $order_phone = "(неизвестно)";
            }

            if (!empty($order['email'])) {
                $order_email = $order['email'];
            } else {
                $order_email = "(неизвестно)";
            }

            if (!empty($order['address'])) {
                $order_address = $order['address'];
            } else {
                $order_address = "(неизвестно)";
            }

            if (!empty($order['fio'])) {
                $order_fio = $order['fio'];
            } else {
                $order_fio = "(неизвестно)";
            }

            if (!empty($order['summ'])) {
                $order_sum = $order['summ'];
            } else {
                $order_sum = "(неизвестно)";
            }

            if (!empty($order['currency'])) {
                $order_currency = $order['currency'];
            } else {
                $order_currency = "(неизвестно)";
            }

            ?>
            <td data-label="ID Заказа"><?= $order_order_id; ?></td>
            <td data-label="Телефон"><?= $order_phone; ?></td>
            <td data-label="Почта"><?= $order_email; ?></td>
            <td data-label="Адрес"><?= $order_address; ?></td>
            <td data-label="ФИО"><?= $order_fio; ?></td>
            <td data-label="Сумма"><?= $order_sum . " " . $order_currency; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
