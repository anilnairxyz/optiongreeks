<?php $page="compare"; ?>
<?php include('layout/header.php'); ?>
<?php include('controller/greeks.php'); ?>
<?php include('controller/underlying.php'); ?>
<?php include('controller/strategy_legs.php'); ?>

<!--Compare Page Content-->
<div id="underlying">
    <h2>Plot Comparison</h2>
    <form action="compare.php" method="post">
    <?php include('includes/underlying.php'); ?>
</div> <!--underlying-->

<div id="trade_legs">
    <?php include('includes/strategies.php'); ?>
    </form>
</div> <!--trade_legs-->

<?php include('controller/strategy_calc.php'); ?>
<?php include('chart/chart_data.php'); ?>
<div id="chart">
    <?php include('chart/chart_render.php'); ?>
</div> <!--chart-->
<?php include('layout/footer.php'); ?>
