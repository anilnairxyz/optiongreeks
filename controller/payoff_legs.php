<?php 
    /* Initialize number of trade legs */
	/*
    $_SESSION['trlegs'] = ((isset($_SESSION['trlegs'])) ? $_SESSION['trlegs'] : 5);
    if (isset($_POST['addtr']) && ($_SESSION['trlegs']<10)) { $_SESSION['trlegs']++; }
    if (isset($_POST['remtr']) && ($_SESSION['trlegs']>1 )) { $_SESSION['trlegs']--; }
    $legs = $_SESSION['trlegs'];
	*/
    $legs = 5;

    /* Trade Details Form initialization */
    for($i=1; $i<=$legs; $i++): 
	  if ($i == 1) {
      	if (isset($_POST['trade'.$i])) { $trade[$i] = $_POST['trade'.$i]; } else { $trade[$i] = 'call'; }
	  } else {
      	if (isset($_POST['trade'.$i])) { $trade[$i] = $_POST['trade'.$i]; } else { $trade[$i] = 'none'; }
	  }
      if (isset($_POST['pos'.$i]))   { $pos[$i]   = $_POST['pos'.$i];   } else { $pos[$i]   = 1;      }
      if (isset($_POST['sk'.$i]))    { $sk[$i]    = $_POST['sk'.$i];    } else { $sk[$i]    = 9000;   }
      if (isset($_POST['vm'.$i]))    { $vm[$i]    = $_POST['vm'.$i];    } else { $vm[$i]    = 25;     }
      if (isset($_POST['opr'.$i]))   { $opr[$i]   = $_POST['opr'.$i];   } else { $opr[$i]   = 200;    }
      if (isset($_POST['brk'.$i]))   { $brk[$i]   = $_POST['brk'.$i];   } else { $brk[$i]   = 0;      }
    endfor;
	/*
    if (isset($_POST['opttx'])) { $opttx = $_POST['opttx']; } else { $opttx = 'ign'; }
    if (isset($_POST['stktx'])) { $stktx = $_POST['stktx']; } else { $stktx = 'ign'; }
	 */
    $opttx = 'ign';
    $stktx = 'ign';
?>
