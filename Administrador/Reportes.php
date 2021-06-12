<?php


$consulta = $objeto -> SQL_consulta("inventario", "*");
$inventario = array();
$n=0;
while($r=$consulta->fetch_object())
{ 
    $inventario[]=$r; 
    $n++;
}
?>

<script>
    $("#GenerarMysql").click(function(){
    var pdf = new jsPDF();
    pdf.text(20,20,"Mostrando una Tabla con PHP y MySQL");

    var columns = ["ID", "Grupo", "Subgrupo", "Nombre", "Marca", "Modelo", "Color", "Número de serie", "Usuario", "Ubicación", "Fecha de asignación", "Calidad"];
    var data = [

        <?php foreach($clientes as $c):?>
        [<?php echo $n; ?>, "<?php echo $c->idActivo; ?>", "<?php echo $c->idGrupo_FK2; ?>", "<?php echo $c->idSubgrupo_FK; ?>", "<?php echo $c->nombre; ?>", "<?php echo $c->marca; ?>", "<?php echo $c->modelo; ?>", "<?php echo $c->color; ?>", "<?php echo $c->numero_serie; ?>", "<?php echo $c->carnet_FK; ?>", "<?php echo $c->ubicacion; ?>", "<?php echo $c->fecha_asignacion; ?>", "<?php echo $c->calidad; ?>"],
        <?php endforeach; ?>  
        ];

    pdf.autoTable(columns,data,
        { margin:{ top: 25  }}
    );

    pdf.save('MiTabla.pdf');

    });
</script>