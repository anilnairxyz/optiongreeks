<?php include('header.php'); ?>
<?php include('functions-options.php'); ?>

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
    $opvega    =  optionvega($ulprice,$strike,$vol,$rfrate,$dvrate,$t2exp);
    $oprho     =   optionrho($ulprice,$strike,$vol,$rfrate,$dvrate,$t2exp,$iscall,$isput);
?>

<!--Option Price Page Content-->
<div id="content">
<div class="wrapper">
<h2>Calculate Option Price</h2>

<div id="compute">
<form action="opprice.php" method="post">
   <p><input type="radio"   name="optyp"      value="call" <?php if ($optyp=="call") echo "checked";?> >Call</p>
   <p><input type="radio"   name="optyp"      value="put"  <?php if ($optyp=="put")  echo "checked";?> >Put</p>
   <p><input type="text"    name="ulprice"    value="<?php echo $ulprice;?>" size="10"  maxlength="20"/>Underlying Price</p>
   <p><input type="text"    name="strike"     value="<?php echo $strike;?>"  size="10"  maxlength="20"/>Strike Price</p>
   <p><input type="text"    name="days"       value="<?php echo $days;?>"    size="10"  maxlength="20"/>Days to Expiry</p>
   <p><input type="text"    name="volatility" value="<?php echo $vol_in;?>"  size="10"  maxlength="20"/>Expected Volatility (%)</p>
   <p><input type="text"    name="rfrate"     value="<?php echo $rate_in;?>" size="10"  maxlength="20"/>Interest Rate (%)</p>
   <p><input type="text"    name="divrate"    value="<?php echo $div_in;?>"  size="10"  maxlength="20"/>Dividend Yield (%)</p>
   <p><input type="submit" value="CALCULATE"  class="submit"/></p>
</form>
</div> <!--compute-->
<div id="compute">
   <table> 
      <tr> <td><strong>Option Price</strong></td> <td> : </td> <td><strong><?php echo sprintf("%.2f", $opprice); ?></strong></td></tr>
      <tr> <td>Delta</td> <td> : </td> <td><?php echo sprintf("%.4f", $opdelta); ?> </td> </tr>
      <tr> <td>Gamma</td> <td> : </td> <td><?php echo sprintf("%.4f", $opgamma); ?> </td> </tr>
      <tr> <td>Theta</td> <td> : </td> <td><?php echo sprintf("%.4f", $optheta); ?> </td> </tr>
      <tr> <td>Vega </td> <td> : </td> <td><?php echo sprintf("%.4f", $opvega ); ?> </td> </tr>
      <tr> <td>Rho  </td> <td> : </td> <td><?php echo sprintf("%.4f", $oprho  ); ?> </td> </tr>
   </table>
</div> <!--compute-->
</div> <!--wrapper-->
</div> <!--content-->

<?php include('footer.php'); ?>
