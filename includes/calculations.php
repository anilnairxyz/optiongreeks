<?php if ($page == "opprice") { ?>
  <div class="ca-flex-row">
    <div class="ca-flex-col1">
      <p><?php echo sprintf("%.2f", $opprice); ?></p>
    </div> <!-- ca-flex-col1 -->
    <div class="ca-flex-col2">
	  <p>Option Price</p>
    </div> <!-- ca-flex-col2 -->
  </div> <!-- ca-flex-row -->
  <div class="ca-flex-row">
    <div class="ca-flex-col1">
	  <p><?php echo sprintf("%.4f", $opdelta); ?></p>
    </div> <!-- ca-flex-col1 -->
	<div class="ca-flex-col2">
	  <p>Delta</p>
    </div> <!-- ca-flex-col2 -->
  </div> <!-- ca-flex-row -->
  <div class="ca-flex-row">
    <div class="ca-flex-col1">
	  <p><?php echo sprintf("%.4f", $opgamma); ?></p>
    </div> <!-- ca-flex-col1 -->
	<div class="ca-flex-col2">
	  <p>Gamma</p>
    </div> <!-- ca-flex-col2 -->
  </div> <!-- ca-flex-row -->
  <div class="ca-flex-row">
    <div class="ca-flex-col1">
	  <p><?php echo sprintf("%.4f", $optheta); ?></p>
    </div> <!-- ca-flex-col1 -->
	<div class="ca-flex-col2">
	  <p>Theta</p>
    </div> <!-- ca-flex-col2 -->
  </div> <!-- ca-flex-row -->
  <div class="ca-flex-row">
    <div class="ca-flex-col1">
	  <p><?php echo sprintf("%.4f", $opvega ); ?></p>
    </div> <!-- ca-flex-col1 -->
	<div class="ca-flex-col2">
	  <p>Vega</p>
    </div> <!-- ca-flex-col2 -->
  </div> <!-- ca-flex-row -->
  <div class="ca-flex-row">
    <div class="ca-flex-col1">
	  <p><?php echo sprintf("%.4f", $oprho  ); ?></p>
    </div> <!-- ca-flex-col1 -->
	<div class="ca-flex-col2">
	  <p>Rho</p>
    </div> <!-- ca-flex-col2 -->
  </div> <!-- ca-flex-row -->
<?php } ?>
<?php if ($page == "iv-calc") { ?>
  <div class="ca-flex-row">
    <div class="ca-flex-col1">
      <p><?php if ($iv_value == 300) echo "&infin;"; else echo $iv_value; ?></p>
    </div> <!-- ca-flex-col1 -->
	<div class="ca-flex-col2">
	  <p>Implied Volatility</p>
    </div> <!-- ca-flex-col2 -->
  </div> <!-- ca-flex-row -->
<?php } ?>
