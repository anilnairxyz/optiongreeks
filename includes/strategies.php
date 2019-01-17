<?php for($j=1; $j<=$strats; $j++):?> 
<h2>Details: Strategy <?php echo $j?></h2>
<div class="tl-flex-row">
  <div class="tl-flex-col0">
     <p>Trade Type</p>
  </div> <!-- tl-flex-col0 -->
  <?php for($i=1; $i<=$legs; $i++):?> 
    <div class="tl-flex-col">
      <select name="trade<?php echo $i.'_'.$j?>">
        <option   value="call"  <?php if ($trade[$i+$legs*($j-1)]=="call")  echo "selected"?> >Call</option>
        <option   value="put"   <?php if ($trade[$i+$legs*($j-1)]=="put")   echo "selected"?> >Put</option>
        <option   value="stock" <?php if ($trade[$i+$legs*($j-1)]=="stock") echo "selected"?> >Stock</option>
        <option   value="none"  <?php if ($trade[$i+$legs*($j-1)]=="none")  echo "selected"?> >None</option>
      </select>
    </div> <!-- tl-flex-col> -->
  <?php endfor;?>
</div> <!-- tl-flex-row -->
<div class="tl-flex-row">
  <div class="tl-flex-col0">
    <p>Position</p>
  </div> <!-- tl-flex-col0 -->
  <?php for($i=1; $i<=$legs; $i++):?> 
    <div class="tl-flex-col">
      <select name="pos<?php echo $i.'_'.$j?>">
        <option   value="-1" <?php if ($pos[$i+$legs*($j-1)]=="-1") echo "selected"?> >Long</option>
        <option   value="1"  <?php if ($pos[$i+$legs*($j-1)]=="1")  echo "selected"?> >Short</option>
      </select>
    </div> <!-- tl-flex-col -->
  <?php endfor;?>
</div> <!-- tl-flex-row -->
<div class="tl-flex-row">
  <div class="tl-flex-col0">
    <p>Trade Price</p>
  </div> <!-- tl-flex-col0 -->
  <?php for($i=1; $i<=$legs; $i++):?> 
    <div class="tl-flex-col">
      <input  name="opr<?php echo $i.'_'.$j?>" type="text" value=<?php echo $opr[$i+$legs*($j-1)];?> size="7" maxlength="10">
    </div> <!-- tl-flex-col -->
  <?php endfor;?>
</div> <!-- tl-flex-row -->
<div class="tl-flex-row">
  <div class="tl-flex-col0">
    <p>Strike Price</p>
  </div> <!-- tl-flex-col0 -->
  <?php for($i=1; $i<=$legs; $i++):?> 
    <div class="tl-flex-col">
      <input  name="sk<?php  echo $i.'_'.$j?>" type="text" value=<?php echo $sk[$i+$legs*($j-1)];?>  size="7" maxlength="10">
    </div> <!-- tl-flex-col -->
  <?php endfor;?>
</div> <!-- tl-flex-row -->
<div class="tl-flex-row">
  <div class="tl-flex-col0">
    <p>Volume</p>
  </div> <!-- tl-flex-col0 -->
  <?php for($i=1; $i<=$legs; $i++):?> 
    <div class="tl-flex-col">
      <input  name="vm<?php  echo $i.'_'.$j?>" type="text" value=<?php echo $vm[$i+$legs*($j-1)];?>  size="7" maxlength="10">
    </div> <!-- tl-flex-col -->
  <?php endfor;?>
</div> <!-- tl-flex-row -->
<div class="tl-flex-row">
  <div class="tl-flex-col0">
    <p>Overheads</p>
  </div> <!-- tl-flex-col0 -->
  <?php for($i=1; $i<=$legs; $i++):?> 
    <div class="tl-flex-col">
      <input  name="brk<?php echo $i.'_'.$j?>" type="text" value=<?php echo $brk[$i+$legs*($j-1)];?> size="7" maxlength="10">
    </div> <!-- tl-flex-col -->
  <?php endfor;?>
</div> <!-- tl-flex-row -->
<?php endfor;?>
