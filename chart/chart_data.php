<!--===============================================================-->
<!-- Chart Data -->
<!--===============================================================-->
<?php
if ($page != "compare") {

    $chart_data = "['Price', '@Expiry', '@".$fardt."days', '@".$neardt."days', 'Delta', 'Gamma', 'Theta', 'Vega', 'Rho'],";
    for($i=1; $i<$nrows; $i++): 
      $chart_data .= "[".$xaxis[$i].",".sprintf("%.2f",$atexp[$i]).",".sprintf("%.2f",$atfar[$i]).","
                     .sprintf("%.2f",$atnear[$i]).",".sprintf("%.3f",$delta[$i]).",".sprintf("%.6f",$gamma[$i]).","
                     .sprintf("%.2f",$theta[$i]).",".sprintf("%.2f",$vega[$i]).",".sprintf("%.2f",$rho[$i])."],";
    endfor; 
      $chart_data .= "[".$xaxis[$nrows].",".sprintf("%.2f",$atexp[$nrows]).",".sprintf("%.2f",$atfar[$nrows]).","
                     .sprintf("%.2f",$atnear[$nrows]).",".sprintf("%.3f",$delta[$nrows]).",".sprintf("%.6f",$gamma[$nrows]).","
                     .sprintf("%.2f",$theta[$nrows]).",".sprintf("%.2f",$vega[$nrows]).",".sprintf("%.2f",$rho[$nrows])."]";

    $chart_column  = "columnsTable.addRow([1, 'Payoff']);";
    $chart_column .= "columnsTable.addRow([2, 'Delta' ]);";
    $chart_column .= "columnsTable.addRow([3, 'Gamma' ]);";
    $chart_column .= "columnsTable.addRow([4, 'Theta' ]);";
    $chart_column .= "columnsTable.addRow([5, 'Vega'  ]);";
    $chart_column .= "columnsTable.addRow([6, 'Rho'   ]);";
    $chart_column .= "initState.selectedValues.push('Payoff');";

	$chart_views   = "if (row == 0) {";
	$chart_views  .= "  view.columns.push(1);";
	$chart_views  .= "  view.columns.push(2);";
	$chart_views  .= "  view.columns.push(3);";
	$chart_views  .= "} else {";
	$chart_views  .= "  view.columns.push(row+3);";
	$chart_views  .= "}";

} else { /* Compare Page */

    $chart_data = "['Price'";
    for($j=1; $j<=$strats; $j++): 
      $chart_data .= ",'Strategy ".$j." @Expiry', 'Strategy ".$j." @".$fardt."days', 'Strategy ".$j." @".$neardt."days'
                      ,'Strategy ".$j." Delta', 'Strategy ".$j." Gamma', 'Strategy ".$j." Theta', 'Strategy ".$j." Vega' 
                      ,'Strategy ".$j." Rho'";
    endfor; 
    $chart_data .= "],";
    for($i=1; $i<$nrows; $i++): 
      $chart_data .= "[".$xaxis[$i].",";
      for($j=1; $j<=$strats; $j++): 
        $chart_data .= sprintf("%.2f",${'atexp'.$j}[$i]).",".sprintf("%.2f",${'atfar'.$j}[$i]).","
                      .sprintf("%.2f",${'atnear'.$j}[$i]).",".sprintf("%.3f",${'delta'.$j}[$i]).",".sprintf("%.6f",${'gamma'.$j}[$i]).","
                      .sprintf("%.2f",${'theta'.$j}[$i]).",".sprintf("%.2f",${'vega'.$j}[$i]).",".sprintf("%.2f",${'rho'.$j}[$i]).",";
      endfor; 
      $chart_data .= "],";
    endfor; 
    $chart_data .= "[".$xaxis[$nrows].",";
    for($j=1; $j<=$strats; $j++): 
      $chart_data .= sprintf("%.2f",${'atexp'.$j}[$nrows]).",".sprintf("%.2f",${'atfar'.$j}[$nrows]).","
                    .sprintf("%.2f",${'atnear'.$j}[$nrows]).",".sprintf("%.3f",${'delta'.$j}[$nrows]).",".sprintf("%.6f",${'gamma'.$j}[$nrows]).","
                    .sprintf("%.2f",${'theta'.$j}[$nrows]).",".sprintf("%.2f",${'vega'.$j}[$nrows]).",".sprintf("%.2f",${'rho'.$j}[$nrows]).",";
    endfor; 
    $chart_data .= "]";

    $chart_column  = "columnsTable.addRow([1, 'Payoff @Expiry']);";
    $chart_column .= "columnsTable.addRow([2, 'Payoff @".$fardt."days']);";
    $chart_column .= "columnsTable.addRow([3, 'Payoff @".$neardt."days']);";
    $chart_column .= "columnsTable.addRow([4, 'Delta' ]);";
    $chart_column .= "columnsTable.addRow([5, 'Gamma' ]);";
    $chart_column .= "columnsTable.addRow([6, 'Theta' ]);";
    $chart_column .= "columnsTable.addRow([7, 'Vega'  ]);";
    $chart_column .= "columnsTable.addRow([8, 'Rho'   ]);";
    $chart_column .= "initState.selectedValues.push('Payoff @Expiry');";

    $chart_views   = "view.columns.push(row+1);";
    $chart_views  .= "view.columns.push(row+9);";
}
?> 
