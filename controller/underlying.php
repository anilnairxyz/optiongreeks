<?php
    /* Underlying parameters initialization */
if (($page == "opprice") || ($page == "iv-calc")) {
    if (isset($_POST['optyp']))      { $optyp   = $_POST['optyp'];      } else { $optyp   = 'call'; }
    if (isset($_POST['strike']))     { $strike  = $_POST['strike'];     } else { $strike  = 9000;   }
}
    if (isset($_POST['ulprice']))    { $ulprice = $_POST['ulprice'];    } else { $ulprice = 9000;   }
    if (isset($_POST['days']))       { $days    = $_POST['days'];       } else { $days    = 30;     }
    if (isset($_POST['rfrate']))     { $rate_in = $_POST['rfrate'];     } else { $rate_in = 8;      }
    if (isset($_POST['divrate']))    { $div_in  = $_POST['divrate'];    } else { $div_in  = 0;      }
if ($page != "iv-calc") { 
    if (isset($_POST['volatility'])) { $vol_in  = $_POST['volatility']; } else { $vol_in  = 15;     }
} else {
    if (isset($_POST['opprice']))    { $opprice = $_POST['opprice'];    } else { $opprice = 200;    }
}
    $t2exp     = $days/365;
    $rfrate    = $rate_in/100;
    $dvrate    = $div_in/100;
if ($page != "iv-calc") { 
    $vol       = $vol_in/100;
}
?>
