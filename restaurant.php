<?php 

@include("header.php");
@include('api/common/connection.php');

$query = '
	SELECT name, description, price, type
	FROM foods
';

$menu = [
	'starters' => [],
	'salads' => [],
	'sandwiches' => [],
	'burgers' => [],
	'platters' => [],
	'desserts' => [],
	'drinks' => []
];

foreach ($connection->query($query) as $row) {
	array_push($menu[$row['type']], $row);
}

?>
<div id="restaurant-container" class="container-fluid">
	<div class="row">
		<div id="restaurant-menu" class="col-sm-offset-1 col-sm-10">
			<div id="menu-content">
				<?php foreach ($menu as $key => $value) { ?>
				<div class="pull-left menu-type">
					<?=ucfirst($key)?>
				</div>
				<div class="clearfix"></div>
				<?php foreach ($value as $val) { ?>
				<div class="menu-element">
					<div class="col-sm-10">
						<b><?=$val['name']?></b>
						<p><?=$val['description']?></p>
					</div>
					<div class="col-sm-2 menu-price">
						<b>$ <?=$val['price']?></b>
					</div>
				</div>
				<?php } ?>
				<div class="clearfix"></div>
				<?php } ?>
			</div>
			<div id="restaurant-title">For Reservation Call 134-2322-8492</div>
		</div>
	</div>
</div>
<?php include("footer.php") ?>