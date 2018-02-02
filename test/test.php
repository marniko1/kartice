<!-- <html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales'],
          ['2013',  1000],
          ['2014',  1170],
          ['2015',  660],
          ['2016',  1030]
        ]);

        var options = {
          title: 'Company Performance',
          hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 100%; height: 500px;"></div>
  </body>
</html> -->

<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  <form action="" method="post">
    <input type="checkbox" name="test[]" value="kralj">
    <input type="checkbox" name="test[]" value="car">
    <input type="checkbox" name="test[]" value="knez">
    <input type="checkbox" name="test[]" value="vojvoda">
    <input type="submit" name="submit">
  </form>
  <?php 
    if (isset($_POST['submit'])) {
      print_r ($_POST['test']);
    }
  ?>
</body>
</html>