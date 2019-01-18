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
    for($l=1; $l<=$legs*$strats; $l++):
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
    $steps            = ceil(sprintf("%.2f", ($hrange-$lrange)/$nrows));
    /* near and far dates for plots */
    $neardt           = ceil(sprintf("%.2f", $days*4/5));
    $fardt            = ceil(sprintf("%.2f", $days*1/5));

    for($j=1; $j<=$strats; $j++): 
      for($k=1; $k<=$legs; $k++):
        $l              = $k+$legs*($j-1);
        /* generate costs of opening trade */
        $taxst          = -($brk[$l]*$sertx)-((($trntx*$otxfl*$isopt[$l])+($stktrn*$stxfl*$isstk[$l]))*$opr[$l]*$vm[$l]);
        $sttst          = -((($sttsl*max($pos[$l],0))*$otxfl*$isopt[$l])+($stkstt*$stxfl*$isstk[$l]))*($opr[$l]*$vm[$l]);
        $brkst          = -$brk[$l];
        $prcst          = $pos[$l]*$opr[$l]*$vm[$l];

        for($i=1; $i<=$nrows; $i++):

          /* generate x-axis values */
          $xaxis[$i]    = $lrange+$steps*$i;
          
          /* generate payoff vector at expiry */
          $itmon        = max(($xaxis[$i]-$sk[$l]),0)*$iscall[$l]+max(($sk[$l]-$xaxis[$i]),0)*$isput[$l];
          $itmfl        = ($itmon>0 ? 1 : 0);
          $prcen        = (-$itmon*$isopt[$l]-$xaxis[$i]*$isstk[$l])*$pos[$l]*$vm[$l];
          $stten        = ($itmfl*min($pos[$l],0)*$sttex*$xaxis[$i]*$vm[$l])*$otxfl*$isopt[$l];
          ${'atexp'.$j}[$i]    = ${'atexp'.$j}[$i]+($prcen+$prcst+$taxst+$sttst+$brkst+$stten)*$isval[$l];

          /* generate payoff vector at far date */
          $itmon        = optionprice($xaxis[$i],$sk[$l],$vol,$rfrate,$dvrate,$fardt/365,$iscall[$l],$isput[$l]);
          $prcen        = (-$itmon*$isopt[$l]-$xaxis[$i]*$isstk[$l])*$pos[$l]*$vm[$l];
          $stten        = ($sttsl*$prcen*min($pos[$l],0))*$otxfl*$isopt[$l];
          $brken        = -$brk[$l]*$isopt[$l];
          $taxen        = (-($brk[$l]*$sertx)-($trntx*abs($prcen)))*$otxfl*$isopt[$l];
          ${'atfar'.$j}[$i]    = ${'atfar'.$j}[$i]+($prcen+$stten+$brken+$taxen+$taxst+$sttst+$prcst+$brkst)*$isval[$l];

          /* generate payoff vector at near date */
          $itmon        = optionprice($xaxis[$i],$sk[$l],$vol,$rfrate,$dvrate,$neardt/365,$iscall[$l],$isput[$l]);
          $prcen        = (-$itmon*$isopt[$l]-$xaxis[$i]*$isstk[$l])*$pos[$l]*$vm[$l];
          $stten        = ($sttsl*$prcen*min($pos[$l],0))*$otxfl*$isopt[$l];
          $brken        = -$brk[$l]*$isopt[$l];
          $taxen        = (-($brk[$l]*$sertx)-($trntx*abs($prcen)))*$otxfl*$isopt[$l];
          ${'atnear'.$j}[$i]   = ${'atnear'.$j}[$i]+($prcen+$stten+$brken+$taxen+$taxst+$sttst+$prcst+$brkst)*$isval[$l];

/*--===============================================================-*/
/*-- Option Greeks                                                  */
/*--===============================================================-*/
          ${'delta'.$j}[$i]    = ${'delta'.$j}[$i]-$pos[$l]*$vm[$l]*(optiondelta($xaxis[$i],$sk[$l],$vol,$rfrate,$dvrate,$t2exp,$iscall[$l],$isput[$l],$isstk[$l]));
          ${'gamma'.$j}[$i]    = ${'gamma'.$j}[$i]-$pos[$l]*$vm[$l]*(optiongamma($xaxis[$i],$sk[$l],$vol,$rfrate,$dvrate,$t2exp))*$isopt[$l];
          ${'theta'.$j}[$i]    = ${'theta'.$j}[$i]-$pos[$l]*$vm[$l]*(optiontheta($xaxis[$i],$sk[$l],$vol,$rfrate,$dvrate,$t2exp,$iscall[$l],$isput[$l]));
          ${'vega'.$j}[$i]     = ${'vega'.$j}[$i]-$pos[$l]*$vm[$l]*(optionvega($xaxis[$i],$sk[$l],$vol,$rfrate,$dvrate,$t2exp))*$isopt[$l];
          ${'rho'.$j}[$i]      = ${'rho'.$j}[$i]-$pos[$l]*$vm[$l]*(optionrho($xaxis[$i],$sk[$l],$vol,$rfrate,$dvrate,$t2exp,$iscall[$l],$isput[$l]));
        endfor; 

      endfor; 
    endfor; 
?>
