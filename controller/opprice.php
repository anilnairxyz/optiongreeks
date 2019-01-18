<?php
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
