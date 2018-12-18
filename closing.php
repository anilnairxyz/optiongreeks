<?php include('header.php'); ?>
<?php include('functions-options.php'); ?>
<?php 
echo 'Current PHP version: ' . phpversion();
?>

<!--Closing prices chart-->
<div id="content">
<div class="wrapper">
<h2>Daily Closing Prices</h2>

</div> <!--wrapper-->
</div> <!--content-->

<!--===============================================================-->
<!-- Plot -->
<!--===============================================================-->

<div id="charts">
<div class="wrapper">
    <!--Chart JavaScript-->
    <script type="text/javascript"
            src="https://www.google.com/jsapi?autoload={ 'modules':[{
            'name':'visualization', 'version':'1', 'packages':['corechart'] }] }">
    </script>

    <script type="text/javascript">
      google.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          <?php

            $user="root";
            $password="anil123";
            $database="NSEUL";
            $server="localhost";
            $sql = new mysqli($server,$user,$password,$database);
            if (mysqli_connect_errno()) {
              printf("Connect failed: %s\n", mysqli_connect_error());
              exit;
            }
            $query="SELECT TIMESTAMP, CLOSE FROM NIFTY";
            $result = $sql->query($query);     
            if (!$result) {
              printf("Query failed: %s\n", $mysqli->error);
              exit;
            }      
            
            // printing table headers
            echo "['TIMESTAMP','CLOSE'],";

            // printing table rows
            while($row = $result->fetch_row())
            {
                echo "[";
            
                for($i=0; $i<sizeof($row); $i++)
                {
                    if ($i == sizeof($row)-1) {
                      echo "$row[$i]";
                    }
                    else {
                      preg_match('/(\d{4})-(\d{2})-(\d{2})/', $row[$i], $match);
                      $year = (int) $match[1];
                      $month = (int) $match[2] - 1; // convert to zero-index to match javascript's dates
                      $day = (int) $match[3];
                      echo "new Date($year, $month, $day),";
                    }
                }
            
                echo "],";
            }
            $result->close();
            $sql->close();
          ?>
          [new Date(2015, 11, 29), 7926]
        ]);

        var options = {
          title: 'Nifty Performance',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

        chart.draw(data, options);
      }
    </script>


<div id="chart_div"></div>
</div> <!--wrapper-->
</div> <!--charts-->


<?php include('footer.php'); ?>
