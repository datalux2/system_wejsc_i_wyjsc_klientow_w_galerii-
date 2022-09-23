<?php
    $dir = dirname(__FILE__, 2);
    include $dir . '/head.php';
?>
<?php if(!empty($days)): ?>
<div id="select_day">
    <label>Wybierz dzień:</label>
    <select id="select_day_selector">
        <option value="0"></option>
        <?php foreach ($days as $row): ?>
        <option value="<?= $row['date'] ?>"><?= $row['day'] ?></option>
        <?php endforeach; ?>
    </select>
    <img src="<?= base_url() ?>/img/loading.gif" id="loader" />
</div>
<script type="text/javascript">
    $('#select_day_selector').change(function() {
        var day = $(this).val();
        
        if (day != '0')
        {
            $.ajax({
                url: '<?= base_url() ?>/pobierz-statystyki-wykresu-dzien',
                method: 'POST',
                data: {day: day},
                dataType: 'json',
                error: function(jqXHR, errorThrown) {
                    $('#loader').hide();
                    alert('Błąd połączenia z siecią');
                },
                beforeSend: function(jqXHR, settings) {
                    $('#loader').show();
                },
                success: function(chart_statistics, textStatus, jqXHR) {
                    if ($.isArray(chart_statistics))
                    {
                        if(chart_statistics.length != 0)
                        {
                            var data_array = [];
                            data_array.push(['Data i godzina', 'Ilość wejść', 'Ilość wyjść']);
                            $.each(chart_statistics, function (index, value) {
                                data_array.push(['g. ' + value['hour'], parseInt(value['input']), parseInt(value['output'])]); 
                            });
                            
                            google.charts.load('current', {'packages':['corechart', 'bar']});
                            google.charts.setOnLoadCallback(function() {drawChart(data_array, day);});

                            google.charts.setOnLoadCallback(function() {drawChart2(data_array, day);});
                            
                            $('#myTab').css('display', 'flex');
                            $('#myTabContent').show();
                        }
                        else
                        {
                            $('#myTab').hide();
                            $('#myTabContent').hide();
                            alert('Brak danych');
                        }
                    }
                    else
                    {
                        $('#myTab').hide();
                        $('#myTabContent').hide();
                        alert('Brak danych');
                    }
                    $('#loader').hide();
                }
            });
        }
        else
        {
            $('#myTab').hide();
            $('#myTabContent').hide();
            alert('Wybierz datę');
        }
    });
    
    function drawChart(data_array, day)
    {
        var data = google.visualization.arrayToDataTable(data_array);
        
        var dateAr = day.split('-');
        var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0];

        var options = {
          title: 'Ilość wejść i wyjść według godziny dla daty ' + newDate,
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

        chart.draw(data, options);
    }
    
    function drawChart2(data_array, day)
    {
        var data = google.visualization.arrayToDataTable(data_array);
        
        var dateAr = day.split('-');
        var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0];

        var options = {
            chart: {
              title: 'Ilość wejść i wyjść według godziny dla daty ' + newDate,
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
    <button class="nav-link" id="chart-circle-tab" data-bs-toggle="tab" data-bs-target="#chart-circle" type="button" role="tab" aria-controls="chart-circle" aria-selected="false">Wykres słupkowy</button>
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
