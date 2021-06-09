<?php
    if (isset($_POST["Confirmar"]))
    {
        $datos[]= $_GET["id"];
        $datos[]= $_GET["User"];
        $datos[]= $_POST["refacciones"];

        $tabla = "refacciones";
        $campos = array('idMantenimiento_FK','carnet_FK4','refacciones');

        $rs = $objeto -> SQL_insert($tabla, $campos, $datos);
        echo "<script>alert('Mantenimiento registrado')</script>";
    }
?>


<div class="row d-flex justify-content-center">
    <div class="col-3 m-3 s-1 p-3 border border-dark rounded-3 d-block" style="background-color:#F5F5F5">
        <form class="row g-3 needs-validation" method="post">
            <label class="form-label" for="refacciones">¿Se agregaron refacciones? </label>
            <div class="col-md-4">
                <select class="form-select" name="refacciones">
                    <Option value='Si'>Si</Option>
                    <Option value='No'>No</Option>
                </select> 
            </div>
            <div class="col-6">
                <input class="btn btn-secondary" type="submit" name="Confirmar" value="Confirmar">
            </div>
        </form>
    </div>
</div>