<?php 
    $legs      = 5;
    $strats    = 2;
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

