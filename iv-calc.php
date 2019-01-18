<?php $page="iv-calc"; ?>
<?php include('layout/header.php'); ?>
<?php include('controller/greeks.php'); ?>
<?php include('controller/underlying.php'); ?>
<?php include('controller/iv.php'); ?>

<!--IV Calculation Page Content-->
<div id="underlying">
    <h2>Calculate Implied Volatility</h2>
    <form action="iv-calc.php" method="post">
        <?php include('includes/underlying.php'); ?>
    </form>
</div> <!--underlying-->

<div id="trade_legs">
    <?php include('includes/calculations.php'); ?>
</div> <!--trade_legs-->

<div id="chart">
</div> <!--chart-->

<?php include('layout/footer.php'); ?>
