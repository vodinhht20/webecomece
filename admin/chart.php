<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/chart.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<body>
    <?php
        include('inc/header.php');
        $filepath = realpath(dirname(__FILE__));
        include_once($filepath.'/../classes/chart.php');
        $char = new chart();
    ?>

    <!-- Main -->
    <div class="main">
        <form action="" method="get" id="form_statistical">
            <div class="overview">
                <h5>Biểu đồ thống kê </h5>
                <div class="list_chart">
                    <div class="item_chart money">
                        <b>Doanh thu</b>
                        <div class="select">
                            <p>Xem theo</p>
                            <select name="revenue_type" id="revenue_type" class="filter-chart">
                                <option value="date" <?php if(isset($_GET['revenue_type']) && $_GET['revenue_type'] == 'date') echo "selected";?>>Ngày</option>
                                <option value="month" <?php if(isset($_GET['revenue_type']) && $_GET['revenue_type'] == 'month') echo "selected";?>>Tháng</option>
                                <option value="year" <?php if(isset($_GET['revenue_type']) && $_GET['revenue_type'] == 'year') echo "selected";?>>Năm</option>
                            </select>
                        </div>
                        <div id="chart_money">

                        </div>
                    </div>
                    <div class="item_chart product">
                        <b>Thống kê doanh thu</b>
                        <div class="select">
                            <div>
                                <p>Ngày từ</p>
                                <input type="date" name="date_from" class="filter-chart" value="<?php if(!empty($_GET['date_from'])) echo $_GET['date_from'];?>">
                            </div>
                            <div>
                                <p>Ngày đến</p>
                                <input type="date" name="date_to" class="filter-chart" value="<?php if(isset($_GET['date_to'])) echo $_GET['date_to'];?>">
                            </div>
                        </div>
                        <div id="chart_product">

                        </div>
                    </div>

                    <div class="item_chart money">
                        <b>Số lượng khách hàng mua nhiều trong tháng</b>
                        <div class="select">
                            <p>Chọn tháng</p>
                            <input type="month" name="month" class="filter-chart" value="<?php echo isset($_GET['month']) ?  $_GET['month'] :  date('Y-m'); ?>">
                        </div>
                        <div id="chart_customer">

                        </div>
                    </div>

                    <div class="item_chart money">
                        <b>Sản phẩm bán chạy</b>
                        <div class="select">
                            <p>Xem theo</p>
                            <select name="count_order_type" id="count_order_type" class="filter-chart">
                                <option value="date" <?php if(isset($_GET['count_order_type']) && $_GET['count_order_type'] == 'date') echo "selected";?>>Ngày</option>
                                <option value="month" <?php if(isset($_GET['count_order_type']) && $_GET['count_order_type'] == 'month') echo "selected";?>>Tháng</option>
                                <option value="year" <?php if(isset($_GET['count_order_type']) && $_GET['count_order_type'] == 'year') echo "selected";?>>Năm</option>
                            </select>
                        </div>
                        <div id="chart_order_product">

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <?php include('inc/footer.php'); ?>

    <script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        function chartOne() {
            var data = google.visualization.arrayToDataTable([
                ['Tháng', 'Doanh thu']
                <?php
                    $chartOne = $char->statistical_revenue($_GET['revenue_type'] ?? 'date');
                    foreach($chartOne as $item) {
                        echo ", ['" . $item['date'] . "'," . $item['revenue']. "]";
                    }
                    if (empty($chartTwo)) {
                        echo ", ['', 0]";
                    }
                ?>
            ]);

            var options = {
                title: 'Doanh thu cửa hàng',
                curveType: 'function',
                legend: {
                    position: 'bottom'
                }
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_money'));

            chart.draw(data, options);
        }


        function chartTwo() {
            var data = google.visualization.arrayToDataTable([
                ['Ngày', 'Doanh thu']
                <?php
                    $chartTwo = $char->statistical_revenue_by_date($_GET['date_from'] ?? null, $_GET['date_to'] ?? null);
                    foreach($chartTwo as $item) {
                        echo ", ['" . $item['date'] . "'," . $item['revenue']. "]";
                    }
                    if (empty($chartTwo)) {
                        echo ", ['', 0]";
                    }
                ?>
            ]);

            var options = {
                title: 'Doanh thu cửa hàng',
                curveType: 'function',
                legend: {
                    position: 'bottom'
                }
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_product'));

            chart.draw(data, options);
        }

        function chartThree() {
            var data = google.visualization.arrayToDataTable([
                ['Khách hàng', 'Số đơn hàng']
                <?php
                    $chartThree = $char->statistical_order_cutomer($_GET['month'] ?? date('Y-m'));
                    foreach($chartThree as $item) {
                        echo ", ['" . $item['name'] . "'," . $item['count']. "]";
                    }
                    if (empty($chartThree)) {
                        echo ", ['', 0]";
                    }
                ?>
            ]);

            var options = {
                title: 'Số lượng khách hàng mua nhiều trong tháng',
            };

            var chart = new google.visualization.BarChart(document.getElementById('chart_customer'));

            chart.draw(data, options);
        }

        function chartFour() {
            var data = google.visualization.arrayToDataTable([
                ['Sản phẩm', 'Số lượt mua']
                <?php
                    $chartThree = $char->statistical_order_product($_GET['revenue_type'] ?? 'date');
                    foreach($chartThree as $item) {
                        echo ", ['" . $item['productName'] . "'," . $item['count']. "]";
                    }
                    if (empty($chartThree)) {
                        echo ", ['', 0]";
                    }
                ?>
            ]);

            var options = {
                title: 'Sản phẩm bán chạy',
            };

            var chart = new google.visualization.BarChart(document.getElementById('chart_order_product'));

            chart.draw(data, options);
        }

        chartOne();
        chartTwo();
        chartThree();
        chartFour();

        $(".filter-chart").on('change', function () {
            $("#form_statistical").submit();
        })
    }
    </script>

</body>

</html>