<?php $page="compare"; ?>
<?php include('layout/header.php'); ?>
<?php include('includes/greeks.php'); ?>

<?php
/*--===============================================================-*/
/*--Form Initialization -->                                         */
/*--===============================================================-*/
    /* General Parameters Form initialization */
    if (isset($_POST['ulprice']))    { $ulprice = $_POST['ulprice'];   } else { $ulprice = 9000; }
    if (isset($_POST['days']))       { $days = $_POST['days'];         } else { $days = 30;      }
    if (isset($_POST['rfrate']))     { $rate_in = $_POST['rfrate'];    } else { $rate_in = 8;    }
    if (isset($_POST['divrate']))    { $div_in = $_POST['divrate'];    } else { $div_in = 0;     }
    if (isset($_POST['volatility'])) { $vol_in = $_POST['volatility']; } else { $vol_in = 15;    }
    $t2exp     = $days/365;
    $rfrate    = $rate_in/100;
    $dvrate    = $div_in/100;
    $vol       = $vol_in/100;
?>
<?php 
    $legs      = 5;
    $strats    = 2;
?>
<?php 
    /* Trade Details Form initialization */
    for($j=1; $j<=$strats; $j++): 
      if ($j%2==1) { $typi = 'call'; } else { $typi = 'put'; }
      for($i=1; $i<=$legs; $i++): 
        if ($i!=1) { $typi = 'none'; }
        if (isset($_POST['trade'.$i.'_'.$j])) { $trade[$i+$legs*($j-1)] = $_POST['trade'.$i.'_'.$j]; } else { $trade[$i+$legs*($j-1)] = $typi; }
        if (isset($_POST['pos'.$i.'_'.$j]))   { $pos[$i+$legs*($j-1)]   = $_POST['pos'.$i.'_'.$j];   } else { $pos[$i+$legs*($j-1)]   = 1;      }
        if (isset($_POST['sk'.$i.'_'.$j]))    { $sk[$i+$legs*($j-1)]    = $_POST['sk'.$i.'_'.$j];    } else { $sk[$i+$legs*($j-1)]    = 9000;   }
        if (isset($_POST['vm'.$i.'_'.$j]))    { $vm[$i+$legs*($j-1)]    = $_POST['vm'.$i.'_'.$j];    } else { $vm[$i+$legs*($j-1)]    = 25;     }
        if (isset($_POST['opr'.$i.'_'.$j]))   { $opr[$i+$legs*($j-1)]   = $_POST['opr'.$i.'_'.$j];   } else { $opr[$i+$legs*($j-1)]   = 200;    }
        if (isset($_POST['brk'.$i.'_'.$j]))   { $brk[$i+$legs*($j-1)]   = $_POST['brk'.$i.'_'.$j];   } else { $brk[$i+$legs*($j-1)]   = 0;      }
      endfor;
    endfor;
	/*
    if (isset($_POST['opttx'])) { $opttx = $_POST['opttx']; } else { $opttx = 'ign'; }
    if (isset($_POST['stktx'])) { $stktx = $_POST['stktx']; } else { $stktx = 'ign'; }
	 */
    $opttx = 'ign';
    $stktx = 'ign';
?>

<!--Compare Page Content-->
<div id="underlying">
    <h2>Plot Comparison</h2>
    <form action="compare.php" method="post">
    <?php include('includes/underlying.php'); ?>
</div> <!--underlying-->

<div id="trade_legs">
    <?php include('includes/strategies.php'); ?>
    </form>
</div> <!--trade_legs-->

<?php
/*--===============================================================-*/
/*-- Data Generation --                                             */
/*--===============================================================-*/
/*--===============================================================-*/
/*-- Payoff data generation                                         */
/*--===============================================================-*/
    /* Tax rate constants */
    $trntx            = 0.07062/100;   // transaction tax + stamp (OPTIONS)
    $sertx            = 14/100;        // service tax
    $sttsl            = 0.017/100;     // STT on sale of options
    $sttex            = 0.125/100;     // STT on expiry of options
    $stkstt           = 0.1/100;       // STT on stock (buy / sell)
    $stktrn           = 0.013905/100;  // transaction tax + stamp (STOCKS)

    /* flags for type of trade and computing taxes */
    for($l=1; $l<=$legs*$strats; $l++):
      if ($trade[$l]=='none') { $samps[$l] = $ulprice; } else { $samps[$l] = $sk[$l]; }
      if ($trade[$l]=='stock') { $isstk[$l] = 1; $samps[$l] = $opr[$l]; } else { $isstk[$l] = 0; }
      if ($trade[$l]=='call') { $iscall[$l] = 1; } else { $iscall[$l] = 0; }
      if ($trade[$l]=='put')  { $isput[$l] = 1; } else { $isput[$l] = 0; }
      $isopt[$l]      = $isput[$l] + $iscall[$l];
      $isval[$l]      = $isopt[$l] + $isstk[$l];
    endfor;
    if ($opttx=="use") { $otxfl = 1; } else { $otxfl = 0; }
    if ($stktx=="use") { $stxfl = 1; } else { $stxfl = 0; }

    /* range and steps for x-axis */
    $lrange           = round(min(min($samps),$ulprice) * 0.85);
    $hrange           = round(max(max($samps),$ulprice) * 1.15);
    $nrows            = 100;
    $steps            = ceil(sprintf("%.2f", ($hrange-$lrange)/$nrows));
    /* near and far dates for plots */
    $neardt           = ceil(sprintf("%.2f", $days*4/5));
    $fardt            = ceil(sprintf("%.2f", $days*1/5));

    for($j=1; $j<=$strats; $j++): 
      for($k=1; $k<=$legs; $k++):
        $l              = $k+$legs*($j-1);
        /* generate costs of opening trade */
        $taxst          = -($brk[$l]*$sertx)-((($trntx*$otxfl*$isopt[$l])+($stktrn*$stxfl*$isstk[$l]))*$opr[$l]*$vm[$l]);
        $sttst          = -((($sttsl*max($pos[$l],0))*$otxfl*$isopt[$l])+($stkstt*$stxfl*$isstk[$l]))*($opr[$l]*$vm[$l]);
        $brkst          = -$brk[$l];
        $prcst          = $pos[$l]*$opr[$l]*$vm[$l];

        for($i=1; $i<=$nrows; $i++):

          /* generate x-axis values */
          $xaxis[$i]    = $lrange+$steps*$i;
          
          /* generate payoff vector at expiry */
          $itmon        = max(($xaxis[$i]-$sk[$l]),0)*$iscall[$l]+max(($sk[$l]-$xaxis[$i]),0)*$isput[$l];
          $itmfl        = ($itmon>0 ? 1 : 0);
          $prcen        = (-$itmon*$isopt[$l]-$xaxis[$i]*$isstk[$l])*$pos[$l]*$vm[$l];
          $stten        = ($itmfl*min($pos[$l],0)*$sttex*$xaxis[$i]*$vm[$l])*$otxfl*$isopt[$l];
          ${'atexp'.$j}[$i]    = ${'atexp'.$j}[$i]+($prcen+$prcst+$taxst+$sttst+$brkst+$stten)*$isval[$l];

          /* generate payoff vector at far date */
          $itmon        = optionprice($xaxis[$i],$sk[$l],$vol,$rfrate,$dvrate,$fardt/365,$iscall[$l],$isput[$l]);
          $prcen        = (-$itmon*$isopt[$l]-$xaxis[$i]*$isstk[$l])*$pos[$l]*$vm[$l];
          $stten        = ($sttsl*$prcen*min($pos[$l],0))*$otxfl*$isopt[$l];
          $brken        = -$brk[$l]*$isopt[$l];
          $taxen        = (-($brk[$l]*$sertx)-($trntx*abs($prcen)))*$otxfl*$isopt[$l];
          ${'atfar'.$j}[$i]    = ${'atfar'.$j}[$i]+($prcen+$stten+$brken+$taxen+$taxst+$sttst+$prcst+$brkst)*$isval[$l];

          /* generate payoff vector at near date */
          $itmon        = optionprice($xaxis[$i],$sk[$l],$vol,$rfrate,$dvrate,$neardt/365,$iscall[$l],$isput[$l]);
          $prcen        = (-$itmon*$isopt[$l]-$xaxis[$i]*$isstk[$l])*$pos[$l]*$vm[$l];
          $stten        = ($sttsl*$prcen*min($pos[$l],0))*$otxfl*$isopt[$l];
          $brken        = -$brk[$l]*$isopt[$l];
          $taxen        = (-($brk[$l]*$sertx)-($trntx*abs($prcen)))*$otxfl*$isopt[$l];
          ${'atnear'.$j}[$i]   = ${'atnear'.$j}[$i]+($prcen+$stten+$brken+$taxen+$taxst+$sttst+$prcst+$brkst)*$isval[$l];

/*--===============================================================-*/
/*-- Option Greeks                                                  */
/*--===============================================================-*/
          ${'delta'.$j}[$i]    = ${'delta'.$j}[$i]-$pos[$l]*$vm[$l]*(optiondelta($xaxis[$i],$sk[$l],$vol,$rfrate,$dvrate,$t2exp,$iscall[$l],$isput[$l],$isstk[$l]));
          ${'gamma'.$j}[$i]    = ${'gamma'.$j}[$i]-$pos[$l]*$vm[$l]*(optiongamma($xaxis[$i],$sk[$l],$vol,$rfrate,$dvrate,$t2exp))*$isopt[$l];
          ${'theta'.$j}[$i]    = ${'theta'.$j}[$i]-$pos[$l]*$vm[$l]*(optiontheta($xaxis[$i],$sk[$l],$vol,$rfrate,$dvrate,$t2exp,$iscall[$l],$isput[$l]));
          ${'vega'.$j}[$i]     = ${'vega'.$j}[$i]-$pos[$l]*$vm[$l]*(optionvega($xaxis[$i],$sk[$l],$vol,$rfrate,$dvrate,$t2exp))*$isopt[$l];
          ${'rho'.$j}[$i]      = ${'rho'.$j}[$i]-$pos[$l]*$vm[$l]*(optionrho($xaxis[$i],$sk[$l],$vol,$rfrate,$dvrate,$t2exp,$iscall[$l],$isput[$l]));
        endfor; 

      endfor; 
    endfor; 
?>
<!--===============================================================-->
<!-- Plot -->
<!--===============================================================-->

<div id="chart">
    <!--Chart JavaScript-->
    <script type="text/javascript"
            src="https://www.google.com/jsapi?autoload={ 'modules':[{
            'name':'visualization', 'version':'1', 'packages':['corechart', 'controls'] }] }">
    </script>

    <script type="text/javascript">
      google.setOnLoadCallback(drawChart);

      function drawChart() {

        // Create the data table with data for all the charts
        var data = new google.visualization.arrayToDataTable([
          <?php 
            echo "['Price'";
            for($j=1; $j<=$strats; $j++): 
                echo ",'Strategy ".$j." @Expiry', 'Strategy ".$j." @".$fardt."days', 'Strategy ".$j." @".$neardt."days'
                      ,'Strategy ".$j." Delta', 'Strategy ".$j." Gamma', 'Strategy ".$j." Theta', 'Strategy ".$j." Vega', 'Strategy ".$j." Rho'";
            endfor; 
                echo "],";
            for($i=1; $i<$nrows; $i++): 
                echo "[".$xaxis[$i].",";
              for($j=1; $j<=$strats; $j++): 
                echo   sprintf("%.2f",${'atexp'.$j}[$i]).",".sprintf("%.2f",${'atfar'.$j}[$i]).","
                      .sprintf("%.2f",${'atnear'.$j}[$i]).",".sprintf("%.3f",${'delta'.$j}[$i]).",".sprintf("%.6f",${'gamma'.$j}[$i]).","
                      .sprintf("%.2f",${'theta'.$j}[$i]).",".sprintf("%.2f",${'vega'.$j}[$i]).",".sprintf("%.2f",${'rho'.$j}[$i]).",";
              endfor; 
                echo "],";
            endfor; 
                echo "[".$xaxis[$nrows].",";
              for($j=1; $j<=$strats; $j++): 
                echo   sprintf("%.2f",${'atexp'.$j}[$nrows]).",".sprintf("%.2f",${'atfar'.$j}[$nrows]).","
                      .sprintf("%.2f",${'atnear'.$j}[$nrows]).",".sprintf("%.3f",${'delta'.$j}[$nrows]).",".sprintf("%.6f",${'gamma'.$j}[$nrows]).","
                      .sprintf("%.2f",${'theta'.$j}[$nrows]).",".sprintf("%.2f",${'vega'.$j}[$nrows]).",".sprintf("%.2f",${'rho'.$j}[$nrows]).",";
              endfor; 
                echo "]";
          ?> 
        ]);

        // Identify the unique charts to be displayed with appropriate labels
        var columnsTable = new google.visualization.DataTable();
            columnsTable.addColumn('number', 'colIndex');
            columnsTable.addColumn('string', 'colLabel');
        var initState= {selectedValues: []};
            columnsTable.addRow([1, 'Payoff @Expiry']);
            columnsTable.addRow([2, 'Payoff @<?php echo $fardt?>days']);
            columnsTable.addRow([3, 'Payoff @<?php echo $neardt?>days']);
            columnsTable.addRow([4, 'Delta' ]);
            columnsTable.addRow([5, 'Gamma' ]);
            columnsTable.addRow([6, 'Theta' ]);
            columnsTable.addRow([7, 'Vega'  ]);
            columnsTable.addRow([8, 'Rho'   ]);
            initState.selectedValues.push('Payoff @Expiry');
        
        // Chart Options
        var chart = new google.visualization.ChartWrapper({
            chartType:    'LineChart',
            containerId:  'chart_div',
            dataTable:     data,
            options: {
              title:      '',
              curveType:  'function',
              legend:     { position: 'top' },
              chartArea:  { width: '80%', height: '80%' },
              hAxis:      { textStyle: { fontSize: '10' } },
              vAxis:      { textStyle: { fontSize: '10' } },
			  explorer: { actions: ['dragToZoom', 'rightClickToReset']}
            }
        });
        
        var columnFilter = new google.visualization.ControlWrapper({
            controlType:   'CategoryFilter',
            containerId:   'colFilter',
            dataTable:      columnsTable,
            options: {
                filterColumnLabel: 'colLabel',
                ui: {
                    label:         'Chart :  ',
                    allowTyping:   false,
                    allowMultiple: false,
                    allowNone:     false,
                    sortValues:    false,
                    selectedValuesLayout: 'belowStacked'
                }
            },
            state: initState
        });
        
        function setChartView () {
            var state = columnFilter.getState();
            var row;
            var view = {
                columns: [0]
            };
            for (var i = 0; i < state.selectedValues.length; i++) {
                row = columnsTable.getFilteredRows([{column: 1, value: state.selectedValues[i]}])[0];
                view.columns.push(row+1);
                view.columns.push(row+9);
            }
            chart.setView(view);
            chart.draw();
        }
        google.visualization.events.addListener(columnFilter, 'statechange', setChartView);
        
        setChartView();
        columnFilter.draw();

      }
    </script>

<div id="colFilter"></div>
<div id="chart_div"></div>
</div> <!--chart-->

<?php include('layout/footer.php'); ?>
