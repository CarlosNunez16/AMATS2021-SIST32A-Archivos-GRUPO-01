<?php
require_once("../Connect.php");
$obj=new ClsConnection();

$sql="SELECT (SELECT COUNT(*)
FROM inventario INNER JOIN mantenimientos ON (inventario.idActivo = mantenimientos.idActivo_FK2) 
WHERE calidad_nueva = 'Sin revisar') AS Mantenimiento, 

(SELECT COUNT(*)
FROM inventario INNER JOIN prestamo ON (inventario.idActivo = prestamo.idActivo_FK) 
WHERE estado = 'En préstamo' OR estado = 'No entregó') AS Prestamo, 

(SELECT COUNT(*) 
FROM inventario 
WHERE (SELECT COUNT(*) FROM prestamo WHERE inventario.idActivo = prestamo.idActivo_FK AND estado = 'En préstamo' OR estado = 'No entregó')=0
AND (SELECT COUNT(*) FROM mantenimientos WHERE inventario.idActivo = mantenimientos.idActivo_FK2 AND calidad_nueva = 'Sin revisar')=0) AS Disponibles";
$rs=$obj->ejecutaSQL($sql);
$fila=$rs->fetch_assoc();

$datos=implode(",",$fila);
?>

	<script src="../chart/Chart.min.js"></script>
	<script src="../chart/samples/utils.js"></script>
	<h1 class="text-center m-3 fs-2">ESTADO DE ACTIVOS FIJOS</h1>
	<div class="m-3" id="canvas-holder" style="width:50%">
	<canvas id="chart-area"></canvas>
	</div>
	
	<script>
		var config = 
			{	
				type: 'pie', data:
			{ 
				 datasets: [		 
			{
				 data: [<?php echo $datos;?>,],

						backgroundColor: [
						window.chartColors.blue,
						window.chartColors.red,
						window.chartColors.orange,],
					
					label: 'Dataset 1'}],
				
				labels: 
				[
				'Mantenimiento',
                'Prestamo',
				'Disponibles']
			},
				options: {
				responsive: true
			}
		};
		

		window.onload = function() {
			var ctx = document.getElementById('chart-area').getContext('2d');
			window.myPie = new Chart(ctx, config);
		};

		document.getElementById('randomizeData').addEventListener('click', function() {
			config.data.datasets.forEach(function(dataset) {
				dataset.data = dataset.data.map(function() {
					return randomScalingFactor();
				});
			});

			window.myPie.update();
		});

		var colorNames = Object.keys(window.chartColors);
		document.getElementById('addDataset').addEventListener('click', function() {
			var newDataset = {
				backgroundColor: [],
				data: [],
				label: 'New dataset ' + config.data.datasets.length,
			};

			for (var index = 0; index < config.data.labels.length; ++index) {
				newDataset.data.push(randomScalingFactor());

				var colorName = colorNames[index % colorNames.length];
				var newColor = window.chartColors[colorName];
				newDataset.backgroundColor.push(newColor);
			}

			config.data.datasets.push(newDataset);
			window.myPie.update();
		});

		document.getElementById('removeDataset').addEventListener('click', function() {
			config.data.datasets.splice(0, 1);
			window.myPie.update();
		});
	</script>
</body>

</html>
