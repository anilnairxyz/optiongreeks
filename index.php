<?php $page="opprice"; ?>
<?php include('layout/header.php'); ?>
<?php include('controller/greeks.php'); ?>
<?php include('controller/underlying.php'); ?>
<?php include('controller/opprice.php'); ?>

<!--Option Price Calculation Page Content-->
<div id="underlying">
    <h2>Calculate Option Price</h2>
    <form action="index.php" method="post">
        <?php include('includes/underlying.php'); ?>
    </form>
</div> <!--underlying-->

<div id="trade_legs">
    <?php include('includes/calculations.php'); ?>
</div> <!--trade_legs-->

<div id="chart">
</div> <!--chart-->

<?php include('layout/footer.php'); ?>
