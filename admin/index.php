<?php 
  include('inc/header.php');

  $filepath = realpath(dirname(__FILE__));
  include_once($filepath.'/../classes/cart.php');
?>
<?php 
  $ct = new cart();
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<div class="panel-header">
    <div class="header text-center">
        <h2 class="title">Thống kê</h2>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <canvas id="myChart" style="width:100%;max-width:800px"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var xValues = [
    <?php 
          for($i=0;$i<=31;$i++){
              echo $i.',';
          } 
      ?>
];

new Chart("myChart", {
    type: "line",
    data: {
        labels: xValues,
        datasets: [{
            data: [
                <?php
            $month_order = date('m');
            $year_order = date('Y');          
            for($i=0;$i<=31;$i++){
              $sum  = 0;
              $get_order = $ct->get_order_chart($i,$month_order,$year_order); 
              if($get_order){
                while($result = $get_order->fetch_assoc()){
                  $sum = $sum+$result['price'];
                }
              } 
              echo $sum.','; 
            }           
          ?>
            ],
            borderColor: "#f96332",
            fill: false
        }]
    },
    options: {
        legend: {
            display: false
        }
    }
});
</script>
<?php include('inc/footer.php'); ?>