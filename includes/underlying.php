<ul class="underlying-flex">
  <? if (($page == "opprice") || ($page == "iv-calc")) { ?>
  <li>
    <input type="radio" id="optyp" name="optyp" value="call" <?php if ($optyp=="call") echo "checked";?> >
    <label for="optyp">Call</label>
    <input type="radio" id="optyp" name="optyp" value="put" <?php if ($optyp=="put") echo "checked";?> >
    <label for="optyp">Put</label>
  </li>
  <? } ?>
  <li>
    <label for="ulprice">Underlying Price</label>
    <input type="text" id="ulprice" name="ulprice" value="<?php echo $ulprice;?>" size="10" maxlength="20"/>
  </li>
  <? if (($page == "opprice") || ($page == "iv-calc")) { ?>
  <li>
    <label for="strike">Strike Price</label>
    <input type="text" id="strike" name="strike" value="<?php echo $strike;?>" size="10" maxlength="20"/>
  </li>
  <? } ?>
  <li>
    <label for="days">Days to Expiry</label>
    <input type="text" id="days" name="days" value="<?php echo $days;?>" size="10" maxlength="20"/>
  </li>
  <? if ($page != "iv-calc") { ?>
  <li>
    <label for="volatility">Volatility (%)</label>
    <input type="text" id="volatility" name="volatility" value="<?php echo $vol_in;?>" size="10" maxlength="20"/>
  </li>
  <? } ?>
  <li>
    <label for="rfrate">Interest Rate (%)</label>
    <input type="text" id="rfrate" name="rfrate" value="<?php echo $rate_in;?>" size="10" maxlength="20"/>
  </li>
  <li>
    <label for="divrate">Dividend Yield (%)</label>
    <input type="text" id="divrate" name="divrate" value="<?php echo $div_in;?>" size="10" maxlength="20"/>
  </li>
  <? if ($page == "iv-calc") { ?>
  <li>
    <label for="opprice">Option Price</label>
    <input type="text" id="opprice" name="opprice" value="<?php echo $opprice;?>" size="10" maxlength="20"/>
  </li>
  <? } ?>
  <? if (($page == "opprice") || ($page == "iv-calc")) { ?>
  <li>
    <input type="submit" name="render" value="Calculate" class="submit"/>
  </li>
  <? } else { ?>
  <li>
    <input type="submit" name="render" value="Plot" class="submit"/>
  </li>
  <? } ?>
</ul>
