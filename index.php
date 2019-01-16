<?php $page="opprice"; ?>
<?php include('layout/header.php'); ?>
<?php include('includes/greeks.php'); ?>

<?php
    /* Parameters initialization */
    if (isset($_POST['optyp']))      { $optyp   = $_POST['optyp'];      } else { $optyp   = 'call'; }
    if (isset($_POST['ulprice']))    { $ulprice = $_POST['ulprice'];    } else { $ulprice = 9000;   }
    if (isset($_POST['strike']))     { $strike  = $_POST['strike'];     } else { $strike  = 9000;   }
    if (isset($_POST['days']))       { $days    = $_POST['days'];       } else { $days    = 30;     }
    if (isset($_POST['rfrate']))     { $rate_in = $_POST['rfrate'];     } else { $rate_in = 8;      }
    if (isset($_POST['divrate']))    { $div_in  = $_POST['divrate'];    } else { $div_in  = 0;      }
    if (isset($_POST['volatility'])) { $vol_in  = $_POST['volatility']; } else { $vol_in  = 15;     }
    $t2exp     = $days/365;
    $rfrate    = $rate_in/100;
    $dvrate    = $div_in/100;
    $vol       = $vol_in/100;

    /* Option Price calculation */
    if ($optyp=="call") { $iscall = 1; } else { $iscall = 0; }
    if ($optyp=="put")  { $isput  = 1; } else { $isput  = 0; }
    $opprice   = optionprice($ulprice,$strike,$vol,$rfrate,$dvrate,$t2exp,$iscall,$isput);
    $opdelta   = optiondelta($ulprice,$strike,$vol,$rfrate,$dvrate,$t2exp,$iscall,$isput, 0);
    $opgamma   = optiongamma($ulprice,$strike,$vol,$rfrate,$dvrate,$t2exp);
    $optheta   = optiontheta($ulprice,$strike,$vol,$rfrate,$dvrate,$t2exp,$iscall,$isput);
    $opvega    = optionvega($ulprice,$strike,$vol,$rfrate,$dvrate,$t2exp);
    $oprho     = optionrho($ulprice,$strike,$vol,$rfrate,$dvrate,$t2exp,$iscall,$isput);
?>

<!--Option Price Calculation Page Content-->
<div id="underlying">
    <h2>Calculate Option Price</h2>
    <form action="index.php" method="post">
        <?php include('includes/underlying.php'); ?>
    </form>
</div> <!--underlying-->

<div id="trade_legs">
    <?php include('includes/calculations.php'); ?>
</div> <!--trade_legs-->

<div id="chart">
</div> <!--chart-->

<?php include('layout/footer.php'); ?>
