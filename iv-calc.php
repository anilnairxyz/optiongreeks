<?php $page="iv-calc"; ?>
<?php include('layout/header.php'); ?>
<?php include('includes/greeks.php'); ?>

<?php
    /* Parameters initialization */
    if (isset($_POST['optyp']))   { $optyp   = $_POST['optyp'];   } else { $optyp   = 'call'; }
    if (isset($_POST['ulprice'])) { $ulprice = $_POST['ulprice']; } else { $ulprice = 9000;   }
    if (isset($_POST['strike']))  { $strike  = $_POST['strike'];  } else { $strike  = 9000;   }
    if (isset($_POST['days']))    { $days    = $_POST['days'];    } else { $days    = 30;     }
    if (isset($_POST['rfrate']))  { $rate_in = $_POST['rfrate'];  } else { $rate_in = 8;      }
    if (isset($_POST['divrate'])) { $div_in  = $_POST['divrate']; } else { $div_in  = 0;      }
    if (isset($_POST['opprice'])) { $opprice = $_POST['opprice']; } else { $opprice = 200;    }
    $t2exp       = $days/365;
    $rfrate      = $rate_in/100;
    $dvrate      = $div_in/100;
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

<!--IV Calculation Page Content-->
<div id="underlying">
    <h2>Calculate Implied Volatility</h2>
    <form action="iv-calc.php" method="post">
        <?php include('includes/underlying.php'); ?>
    </form>
</div> <!--underlying-->

<div id="trade_legs">
    <p><strong>Implied Volatility <?php if ($iv_value == 300) echo "> "; else echo "= "; echo $iv_value; ?> %</strong></p>
</div> <!--trade_legs-->

<div id="chart">
</div> <!--chart-->

<?php include('layout/footer.php'); ?>
