<?php
    $dir = dirname(__FILE__, 2);
    include $dir . '/head.php';
?>
<?php if(!empty($chart_statistics)): ?>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawChart);
    
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data i godzina', 'Ilość wejść', 'Ilość wyjść'],
          <?php foreach($chart_statistics as $key => $row): ?>
          ['<?=$row['date'] . ' g. ' . $row['hour']?>', <?=$row['input']?>, <?=$row['output']?>],
          <?php endforeach; ?>
        ]);

        var options = {
          title: 'Ilość wejść i wyjść według daty i godziny',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

        chart.draw(data, options);
      }
      
    google.charts.setOnLoadCallback(drawChart2);
    function drawChart2() {
      var data = google.visualization.arrayToDataTable([
        ["Data i godzina", "Ilość wejść", "Ilość wyjść"],
        <?php foreach($chart_statistics as $key => $row): ?>
        ["<?=$row['date'] . ' g. ' . $row['hour']?>", <?=$row['input']?>, <?=$row['output']?>],
        <?php endforeach; ?>
      ]);

      var options = {
          chart: {
            title: 'Ilość wejść i wyjść według daty i godziny',
            subtitle: ''
          }
        };

        var chart = new google.charts.Bar(document.getElementById('chart_div2'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="chart-line-tab" data-bs-toggle="tab" data-bs-target="#chart-line" type="button" role="tab" aria-controls="chart-line" aria-selected="true">Wykres liniowy</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="chart-circle-tab" data-bs-toggle="tab" data-bs-target="#chart-circle" type="button" role="tab" aria-controls="chart-circle" aria-selected="false">Wykres kołowy</button>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="chart-line" role="tabpanel" aria-labelledby="chart-line-tab">
        <div id="chart_div"></div>
    </div>
    <div class="tab-pane fade" id="chart-circle" role="tabpanel" aria-labelledby="chart-circle-tab">
        <div id="chart_div2"></div>
    </div>
</div>
<?php endif; ?>
Kamera 1<br/><br/>
Ilość wejść: <?=$get_input_camera1['count_wejsc']?><br/>
Ilość wyjść: <?=$get_output_camera1['count_wyjsc']?><br/><br/>
Kamera 2<br/><br/>
Ilość wejść: <?=$get_input_camera2['count_wejsc']?><br/>
Ilość wyjść: <?=$get_output_camera2['count_wyjsc']?><br/><br/>

Ilość wejść globalna: <?=$get_input_global['count_wejsc']?><br/>
Ilość wyjść globalna: <?=$get_output_global['count_wyjsc']?><br/><br/>

Ilość osób na obiekcie: <?php if(!empty($get_count_persons['count_persons'])): ?><?=$get_count_persons['count_persons']?><?php else: ?>0<?php endif; ?><br/><br/>
<?php
    include $dir . '/footer.php';
?>
