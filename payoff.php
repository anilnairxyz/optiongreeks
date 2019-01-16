<?php $page="payoff"; ?>
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
    /* Initialize number of trade legs */
    $_SESSION['trlegs'] = ((isset($_SESSION['trlegs'])) ? $_SESSION['trlegs'] : 5);
    if (isset($_POST['addtr']) && ($_SESSION['trlegs']<10)) { $_SESSION['trlegs']++; }
    if (isset($_POST['remtr']) && ($_SESSION['trlegs']>1 )) { $_SESSION['trlegs']--; }
    $legs = $_SESSION['trlegs'];
?>
<?php 
    /* Trade Details Form initialization */
    for($i=1;$i<=$legs;$i++): 
      if (isset($_POST['trade'.$i])) { $trade[$i] = $_POST['trade'.$i]; } else { $trade[$i] = 'call'; }
      if (isset($_POST['pos'.$i]))   { $pos[$i]   = $_POST['pos'.$i];   } else { $pos[$i]   = 1;      }
      if (isset($_POST['sk'.$i]))    { $sk[$i]    = $_POST['sk'.$i];    } else { $sk[$i]    = 9000;   }
      if (isset($_POST['vm'.$i]))    { $vm[$i]    = $_POST['vm'.$i];    } else { $vm[$i]    = 25;     }
      if (isset($_POST['opr'.$i]))   { $opr[$i]   = $_POST['opr'.$i];   } else { $opr[$i]   = 200;    }
      if (isset($_POST['brk'.$i]))   { $brk[$i]   = $_POST['brk'.$i];   } else { $brk[$i]   = 0;      }
    endfor;
    if (isset($_POST['opttx'])) { $opttx = $_POST['opttx']; } else { $opttx = 'ign'; }
    if (isset($_POST['stktx'])) { $stktx = $_POST['stktx']; } else { $stktx = 'ign'; }
?>

<!--Payoff Page Content-->
<div id="underlying">
    <h2>Plot Payoff</h2>
    <form action="payoff.php" method="post">
        <?php include('includes/underlying.php'); ?>
    </form>
</div> <!--underlying-->

<div id="trade_legs">
    <h2>Trade Details</h2>
    <form action="payoff.php" method="post">
        <?php include('includes/trade_legs.php'); ?>
    </form>
</div> <!--trade_legs-->

<?php
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
    for($l=1;$l<=$legs;$l++):
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
    $steps            = ceil(sprintf("%.2f",($hrange-$lrange)/$nrows));
    /* near and far dates for plots */
    $neardt           = ceil(sprintf("%.2f",$days*4/5));
    $fardt            = ceil(sprintf("%.2f",$days*1/5));

    for($l=1;$l<=$legs;$l++):
      /* generate costs of opening trade */
      $taxst          = -($brk[$l]*$sertx)-((($trntx*$otxfl*$isopt[$l])+($stktrn*$stxfl*$isstk[$l]))*$opr[$l]*$vm[$l]);
      $sttst          = -((($sttsl*max($pos[$l],0))*$otxfl*$isopt[$l])+($stkstt*$stxfl*$isstk[$l]))*($opr[$l]*$vm[$l]);
      $brkst          = -$brk[$l];
      $prcst          = $pos[$l]*$opr[$l]*$vm[$l];

      for($i=1;$i<=$nrows;$i++):

        /* generate x-axis values */
        $xaxis[$i]    = $lrange+$steps*$i;
        
        /* generate payoff vector at expiry */
        $itmon        = max(($xaxis[$i]-$sk[$l]),0)*$iscall[$l]+max(($sk[$l]-$xaxis[$i]),0)*$isput[$l];
        $itmfl        = ($itmon>0 ? 1 : 0);
        $prcen        = (-$itmon*$isopt[$l]-$xaxis[$i]*$isstk[$l])*$pos[$l]*$vm[$l];
        $stten        = ($itmfl*min($pos[$l],0)*$sttex*$xaxis[$i]*$vm[$l])*$otxfl*$isopt[$l];
        $atexp[$i]    = $atexp[$i]+($prcen+$prcst+$taxst+$sttst+$brkst+$stten)*$isval[$l];

        /* generate payoff vector at far date */
        $itmon        = optionprice($xaxis[$i],$sk[$l],$vol,$rfrate,$dvrate,$fardt/365,$iscall[$l],$isput[$l]);
        $prcen        = (-$itmon*$isopt[$l]-$xaxis[$i]*$isstk[$l])*$pos[$l]*$vm[$l];
        $stten        = ($sttsl*$prcen*min($pos[$l],0))*$otxfl*$isopt[$l];
        $brken        = -$brk[$l]*$isopt[$l];
        $taxen        = (-($brk[$l]*$sertx)-($trntx*abs($prcen)))*$otxfl*$isopt[$l];
        $atfar[$i]    = $atfar[$i]+($prcen+$stten+$brken+$taxen+$taxst+$sttst+$prcst+$brkst)*$isval[$l];

        /* generate payoff vector at near date */
        $itmon        = optionprice($xaxis[$i],$sk[$l],$vol,$rfrate,$dvrate,$neardt/365,$iscall[$l],$isput[$l]);
        $prcen        = (-$itmon*$isopt[$l]-$xaxis[$i]*$isstk[$l])*$pos[$l]*$vm[$l];
        $stten        = ($sttsl*$prcen*min($pos[$l],0))*$otxfl*$isopt[$l];
        $brken        = -$brk[$l]*$isopt[$l];
        $taxen        = (-($brk[$l]*$sertx)-($trntx*abs($prcen)))*$otxfl*$isopt[$l];
        $atnear[$i]   = $atnear[$i]+($prcen+$stten+$brken+$taxen+$taxst+$sttst+$prcst+$brkst)*$isval[$l];

/*--===============================================================-*/
/*-- Option Greeks                                                  */
/*--===============================================================-*/
        $delta[$i]    = $delta[$i]-$pos[$l]*$vm[$l]*(optiondelta($xaxis[$i],$sk[$l],$vol,$rfrate,$dvrate,$t2exp,$iscall[$l],$isput[$l],$isstk[$l]));
        $gamma[$i]    = $gamma[$i]-$pos[$l]*$vm[$l]*(optiongamma($xaxis[$i],$sk[$l],$vol,$rfrate,$dvrate,$t2exp))*$isopt[$l];
        $theta[$i]    = $theta[$i]-$pos[$l]*$vm[$l]*(optiontheta($xaxis[$i],$sk[$l],$vol,$rfrate,$dvrate,$t2exp,$iscall[$l],$isput[$l]));
        $vega[$i]     = $vega[$i] -$pos[$l]*$vm[$l]* (optionvega($xaxis[$i],$sk[$l],$vol,$rfrate,$dvrate,$t2exp))*$isopt[$l];
        $rho[$i]      = $rho[$i]  -$pos[$l]*$vm[$l]*  (optionrho($xaxis[$i],$sk[$l],$vol,$rfrate,$dvrate,$t2exp,$iscall[$l],$isput[$l]));

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
          ['Price', '@Expiry', '@<?php echo $fardt?>days', '@<?php echo $neardt?>days', 'Delta', 'Gamma', 'Theta', 'Vega', 'Rho'],
          <?php 
            for($i=1;$i<$nrows;$i++): 
              echo "[".$xaxis[$i].",".sprintf("%.2f",$atexp[$i]).",".sprintf("%.2f",$atfar[$i]).","
                      .sprintf("%.2f",$atnear[$i]).",".sprintf("%.3f",$delta[$i]).",".sprintf("%.6f",$gamma[$i]).","
                      .sprintf("%.2f",$theta[$i]).",".sprintf("%.2f",$vega[$i]).",".sprintf("%.2f",$rho[$i])."],";
            endfor; 
              echo "[".$xaxis[$nrows].",".sprintf("%.2f",$atexp[$nrows]).",".sprintf("%.2f",$atfar[$nrows]).","
                      .sprintf("%.2f",$atnear[$nrows]).",".sprintf("%.3f",$delta[$nrows]).",".sprintf("%.6f",$gamma[$nrows]).","
                      .sprintf("%.2f",$theta[$nrows]).",".sprintf("%.2f",$vega[$nrows]).",".sprintf("%.2f",$rho[$nrows])."]";
          ?> 
        ]);

        // Identify the unique charts to be displayed with appropriate labels
        var columnsTable = new google.visualization.DataTable();
            columnsTable.addColumn('number', 'colIndex');
            columnsTable.addColumn('string', 'colLabel');
        var initState= {selectedValues: []};
            columnsTable.addRow([1, 'Payoff']);
            columnsTable.addRow([2, 'Delta' ]);
            columnsTable.addRow([3, 'Gamma' ]);
            columnsTable.addRow([4, 'Theta' ]);
            columnsTable.addRow([5, 'Vega'  ]);
            columnsTable.addRow([6, 'Rho'   ]);
            initState.selectedValues.push('Payoff');
        
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
              explorer:   {}
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
                if (row == 0) {
                  view.columns.push(1);
                  view.columns.push(2);
                  view.columns.push(3);
                } else {
                  view.columns.push(row+3);
                }
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
