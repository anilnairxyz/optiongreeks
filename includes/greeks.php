<?php
/* PHP functions */
/*======================================*/
    /* Cumulative Normdist */
    /*==================================*/
    function normdist($x, $m, $s) { 
      $b1        = 0.319381530;
      $b2        = -0.356563782;
      $b3        = 1.781477937;
      $b4        = -1.821255978;
      $b5        = 1.330274429;
      $p         = 0.2316419;
      $c         = 0.39894228;
      if($x >= 0) {
      $t         = 1/(1 + $p * $x);
      $nd        = (1-$c*exp(-$x*$x/2)*$t*($t*($t*($t*($t*$b5+$b4)+$b3)+$b2)+$b1));
      } else {
      $t         = 1/(1 - $p * $x);
      $nd        = ($c*exp(-$x*$x/2)*$t*($t*($t*($t*($t*$b5+$b4)+$b3)+$b2)+$b1));
      }
      return $nd;
    }
    /*==================================*/
    /* Option Price */
    /*==================================*/
    function optionprice($ul, $k, $v, $r, $d, $t, $iscall, $isput) { 
      $d1        = (log($ul/$k) + $t*($r-$d+$v*$v/2))/(sqrt($t)*$v);
      $d2        = $d1-(sqrt($t)*$v);
      $nd1       = normdist($d1, 0, 1);
      $nd2       = normdist($d2, 0, 1);
      $nmd1      = normdist(-$d1, 0, 1);
      $nmd2      = normdist(-$d2, 0, 1);
      $callprice = ($ul*exp(-$d*$t)*$nd1)-($k*exp(-$r*$t)*$nd2);
      $putprice  = ($k*exp(-$r*$t)*$nmd2)-($ul*exp(-$d*$t)*$nmd1);
      $optionp   = $callprice*$iscall + $putprice*$isput;
      return $optionp;
    }
    /*==================================*/
    /* Option Delta */
    /*==================================*/
    function optiondelta($ul, $k, $v, $r, $d, $t, $iscall, $isput, $isstk) { 
      $d1        = (log($ul/$k) + $t*($r-$d+$v*$v/2))/(sqrt($t)*$v);
      $nd1       = normdist($d1, 0, 1);
      $calldelta = exp(-$d*$t)*$nd1; 
      $putdelta  = exp(-$d*$t)*($nd1-1);
      $delta     = $calldelta*$iscall + $putdelta*$isput + $isstk;
      return $delta;
    }
    /*==================================*/
    /* Option Gamma */
    /*==================================*/
    function optiongamma($ul, $k, $v, $r, $d, $t) { 
      $d1        = (log($ul/$k) + $t*($r-$d+$v*$v/2))/(sqrt($t)*$v);
      $ndd1      = exp(-($d1*$d1/2))/sqrt(2*pi());
      $gamma     = exp(-$d*$t)*$ndd1/($ul*$v*sqrt($t));
      return $gamma;
    }
    /*==================================*/
    /* Option Theta */
    /*==================================*/
    function optiontheta($ul, $k, $v, $r, $d, $t, $iscall, $isput) { 
      $d1        = (log($ul/$k) + $t*($r-$d+$v*$v/2))/(sqrt($t)*$v);
      $d2        = $d1-(sqrt($t)*$v);
      $nd1       = normdist($d1, 0, 1);
      $nd2       = normdist($d2, 0, 1);
      $nmd1      = normdist(-$d1, 0, 1);
      $nmd2      = normdist(-$d2, 0, 1);
      $ndd1      = exp(-($d1*$d1/2))/sqrt(2*pi());
      $calltheta = (-($ul*$v*exp(-$d*$t)*$ndd1/(2*sqrt($t))) - ($r*$k*exp(-$r*$t)*$nd2)  + ($d*$ul*exp(-$d*$t)*$nd1))/365; 
      $puttheta  = (-($ul*$v*exp(-$d*$t)*$ndd1/(2*sqrt($t))) + ($r*$k*exp(-$r*$t)*$nmd2) - ($d*$ul*exp(-$d*$t)*$nmd1))/365; 
      $theta     = $calltheta*$iscall + $puttheta*$isput;
      return $theta;
    }
    /*==================================*/
    /* Option Vega */
    /*==================================*/
    function optionvega($ul, $k, $v, $r, $d, $t) { 
      $d1        = (log($ul/$k) + $t*($r-$d+$v*$v/2))/(sqrt($t)*$v);
      $ndd1      = exp(-($d1*$d1/2))/sqrt(2*pi());
      $vega      = $ul*sqrt($t)*exp(-$d*$t)*$ndd1/100;
      return $vega;
    }
    /*==================================*/
    /* Option Rho */
    /*==================================*/
    function optionrho($ul, $k, $v, $r, $d, $t, $iscall, $isput) { 
      $d2        = $d1-(sqrt($t)*$v);
      $nd2       = normdist($d2, 0, 1);
      $nmd2      = normdist(-$d2, 0, 1);
      $callrho   = $k*$t*exp(-$r*$t)*$nd2/100; 
      $putrho    = $k*$t*exp(-$r*$t)*$nmd2/100; 
      $rho       = $callrho*$iscall + $putrho*$isput;
      return $rho;
    }

/* end PHP Functions */
?>
