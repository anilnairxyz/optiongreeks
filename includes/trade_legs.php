<?php for($i=1;$i<$legs;$i++):?> 
<div class="legs">
    <p><select name="trade<?php echo $i?>">
    <option   value="call"  <?php if ($trade[$i]=="call")  echo "selected"?> >Call</option>
    <option   value="put"   <?php if ($trade[$i]=="put")   echo "selected"?> >Put</option>
    <option   value="stock" <?php if ($trade[$i]=="stock") echo "selected"?> >Stock</option>
    <option   value="none"  <?php if ($trade[$i]=="none")  echo "selected"?> >None</option>
    </select></p>
    <p><select name="pos<?php echo $i?>">
    <option   value="-1" <?php if ($pos[$i]=="-1") echo "selected"?> >Long</option>
    <option   value="1"  <?php if ($pos[$i]=="1")  echo "selected"?> >Short</option>
    </select></p>
    <p><input  name="sk<?php  echo $i?>" type="text" value=<?php echo $sk[$i];?>  size="7" maxlength="10"></p>
    <p><input  name="vm<?php  echo $i?>" type="text" value=<?php echo $vm[$i];?>  size="7" maxlength="10"></p>
    <p><input  name="opr<?php echo $i?>" type="text" value=<?php echo $opr[$i];?> size="7" maxlength="10"></p>
    <p><input  name="brk<?php echo $i?>" type="text" value=<?php echo $brk[$i];?> size="7" maxlength="10"></p>
</div> <!--legs-->
<?php endfor;?>
<div class="legs">
    <p><select name="trade<?php echo $legs?>">
    <option   value="call"  <?php if ($trade[$legs]=="call")  echo "selected"?> >Call</option>
    <option   value="put"   <?php if ($trade[$legs]=="put")   echo "selected"?> >Put</option>
    <option   value="stock" <?php if ($trade[$legs]=="stock") echo "selected"?> >Stock</option>
    <option   value="none"  <?php if ($trade[$legs]=="none")  echo "selected"?> >None</option>
    </select>Type</p>
    <p><select name="pos<?php echo $legs?>">
    <option   value="-1" <?php if ($pos[$legs]=="-1") echo "selected"?> >Long</option>
    <option   value="1"  <?php if ($pos[$legs]=="1")  echo "selected"?> >Short</option>
    </select>Position</p>
    <p><input  name="sk<?php  echo $legs?>" type="text" value=<?php echo $sk[$legs];?>  size="7" maxlength="10">Strike Price</p>
    <p><input  name="vm<?php  echo $legs?>" type="text" value=<?php echo $vm[$legs];?>  size="7" maxlength="10">Volume</p>
    <p><input  name="opr<?php echo $legs?>" type="text" value=<?php echo $opr[$legs];?> size="7" maxlength="10">Trade Price</p>
    <p><input  name="brk<?php echo $legs?>" type="text" value=<?php echo $brk[$legs];?> size="7" maxlength="10">Brokerage</p>
</div> <!--legs-->

<div class="keys">
    <p><input  name="addtr" type="submit" value="ADD" class="adjust"/></p>
    <p><input  name="remtr" type="submit" value="REMOVE" class="adjust"/></p>
    <p>For Options</p>
    <p><input  type="radio" name="opttx" value="use" <?php if ($opttx=="use") echo "checked";?> >Compute Taxes</p>
    <p><input  type="radio" name="opttx" value="ign" <?php if ($opttx=="ign") echo "checked";?> >Ignore Taxes</p>
    <p>For Stocks</p>
    <p><input  type="radio" name="stktx" value="use" <?php if ($stktx=="use") echo "checked";?> >Compute Taxes</p>
    <p><input  type="radio" name="stktx" value="ign" <?php if ($stktx=="ign") echo "checked";?> >Ignore Taxes</p>
</div> <!--keys-->
