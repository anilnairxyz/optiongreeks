<?php if (($page == "opprice") || ($page == "iv-calc")) { ?>
  <div class="ul-flex-row">
    <div class="ul-flex-col1">
      <label for="optyp">Call</label>
      <input type="radio" id="optyp" name="optyp" value="call" <?php if ($optyp=="call") echo "checked";?> >
      <label for="optyp">Put</label>
      <input type="radio" id="optyp" name="optyp" value="put" <?php if ($optyp=="put") echo "checked";?> >
    </div> <!-- ul-flex-col1 -->
    <div class="ul-flex-col2">
      <p></p>
    </div> <!-- ul-flex-col2 -->
  </div> <!-- ul-flex-row -->
<?php } ?>
  <div class="ul-flex-row">
    <div class="ul-flex-col1">
      <input type="text" id="ulprice" name="ulprice" value="<?php echo $ulprice;?>" size="10" maxlength="20"/>
    </div> <!-- ul-flex-col1 -->
    <div class="ul-flex-col2">
      <label for="ulprice">Underlying Price</label>
    </div> <!-- ul-flex-col2 -->
  </div> <!-- ul-flex-row -->
<?php if (($page == "opprice") || ($page == "iv-calc")) { ?>
  <div class="ul-flex-row">
    <div class="ul-flex-col1">
      <input type="text" id="strike" name="strike" value="<?php echo $strike;?>" size="10" maxlength="20"/>
    </div> <!-- ul-flex-col1 -->
    <div class="ul-flex-col2">
      <label for="strike">Strike Price</label>
    </div> <!-- ul-flex-col2 -->
  </div> <!-- ul-flex-row -->
<?php } ?>
  <div class="ul-flex-row">
    <div class="ul-flex-col1">
      <input type="text" id="days" name="days" value="<?php echo $days;?>" size="10" maxlength="20"/>
    </div> <!-- ul-flex-col1 -->
    <div class="ul-flex-col2">
      <label for="days">Days to Expiry</label>
    </div> <!-- ul-flex-col2 -->
  </div> <!-- ul-flex-row -->
<?php if ($page != "iv-calc") { ?>
  <div class="ul-flex-row">
    <div class="ul-flex-col1">
      <input type="text" id="volatility" name="volatility" value="<?php echo $vol_in;?>" size="10" maxlength="20"/>
    </div> <!-- ul-flex-col1 -->
    <div class="ul-flex-col2">
      <label for="volatility">Volatility (%)</label>
    </div> <!-- ul-flex-col2 -->
  </div> <!-- ul-flex-row -->
<?php } ?>
  <div class="ul-flex-row">
    <div class="ul-flex-col1">
      <input type="text" id="rfrate" name="rfrate" value="<?php echo $rate_in;?>" size="10" maxlength="20"/>
    </div> <!-- ul-flex-col1 -->
    <div class="ul-flex-col2">
      <label for="rfrate">Interest Rate (%)</label>
    </div> <!-- ul-flex-col2 -->
  </div> <!-- ul-flex-row -->
  <div class="ul-flex-row">
    <div class="ul-flex-col1">
      <input type="text" id="divrate" name="divrate" value="<?php echo $div_in;?>" size="10" maxlength="20"/>
    </div> <!-- ul-flex-col1 -->
    <div class="ul-flex-col2">
      <label for="divrate">Dividend Yield (%)</label>
    </div> <!-- ul-flex-col2 -->
  </div> <!-- ul-flex-row -->
<?php if ($page == "iv-calc") { ?>
  <div class="ul-flex-row">
    <div class="ul-flex-col1">
      <input type="text" id="opprice" name="opprice" value="<?php echo $opprice;?>" size="10" maxlength="20"/>
    </div> <!-- ul-flex-col1 -->
    <div class="ul-flex-col2">
      <label for="opprice">Option Price</label>
    </div> <!-- ul-flex-col2 -->
  </div> <!-- ul-flex-row -->
<?php } ?>
<?php if (($page == "opprice") || ($page == "iv-calc")) { ?>
  <input type="submit" name="render" value="Calculate" class="submit"/>
<?php } else { ?>
  <input type="submit" name="render" value="Plot" class="submit"/>
<?php } ?>
