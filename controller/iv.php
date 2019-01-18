<?php
    if ($optyp=="call") { $iscall = 1; } else { $iscall = 0; }
    if ($optyp=="put")  { $isput  = 1; } else { $isput  = 0; }

    /* Implied Volatiliy calculation */
    $vol_fl      = 0;
    $vol_ce      = 3.0001;
    $vol         = sprintf("%.4f",($vol_ce + $vol_fl)/2);

    while ($vol-$vol_fl > 0.0001) {
      $thprice   = optionprice($ulprice,$strike,$vol,$rfrate,$dvrate,$t2exp,$iscall,$isput);
      if ($thprice > $opprice) {
        $vol_ce  = $vol;
      } else {
        $vol_fl  = $vol;
      }
      $vol       = sprintf("%.5f",($vol_ce + $vol_fl)/2);
    }
    $iv_value    = sprintf("%.2f",$vol*100);
?>
