<html>
<head>
    <link href="CSS/design.css" rel="stylesheet">
    <title>Заказы</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="https://momentjs.com/downloads/moment.js"></script>
    <script type="text/javascript">
        function getOrders() {
            dateFrom_txt = $("input[name='dateFrom']").val();
            dateTo_txt = $("input[name='dateTo']").val();
            dateFrom = new Date(dateFrom_txt);
            dateTo = new Date(dateTo_txt);
            formatDateOrder_from = moment(dateFrom).format('DD.MM.YYYY');
            formatDateOrder_to = moment(dateTo).format('DD.MM.YYYY');

            $.ajax({
                type: "POST",
                url: "apiExecuteGetOrders.php",
                data: {dateFrom: formatDateOrder_from, dateTo: formatDateOrder_to},
                success: function (data) {
                    $("#response").html(data);
                }
            });
            return false;
        }
    </script>
</head>
<div class="main">
    <div class="getOrders_block">
        <form id="dateOrdersFind" method="post">
            Дата от:<input name="dateFrom" type="date" value="2019-05-09" form="dateOrdersFind">
            Дата до:<input name="dateTo" type="date" value="2019-09-25" form="dateOrdersFind">
        </form>
        <button class="button" onClick="getOrders()">Получить заказы</button>
    </div>
    <div id="titleTable">Заказы</div>
    <div id="response"></div>
</div>
</body>
</html>
