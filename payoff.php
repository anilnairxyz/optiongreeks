<?php $page="payoff"; ?>
<?php include('layout/header.php'); ?>
<?php include('controller/greeks.php'); ?>
<?php include('controller/underlying.php'); ?>
<?php include('controller/payoff_legs.php'); ?>

<!--Payoff Page Content-->
<div id="underlying">
    <h2>Plot Payoff</h2>
    <form action="payoff.php" method="post">
    <?php include('includes/underlying.php'); ?>
</div> <!--underlying-->

<div id="trade_legs">
    <h2>Trade Details</h2>
    <?php include('includes/trade_legs.php'); ?>
    </form>
</div> <!--trade_legs-->

<?php include('controller/payoff_calc.php'); ?>
<?php include('chart/chart_data.php'); ?>
<div id="chart">
    <?php include('chart/chart_render.php'); ?>
</div> <!--chart-->
<?php include('layout/footer.php'); ?>
