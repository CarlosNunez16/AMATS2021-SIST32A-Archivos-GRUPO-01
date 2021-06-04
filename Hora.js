function mueveReloj(){
    momentoActual = new Date()
    hora = momentoActual.getHours()
    minuto = momentoActual.getMinutes()
    segundo = momentoActual.getSeconds()

    str_segundo = new String (segundo)
    if (str_segundo.length == 1)
    segundo = '0' + segundo

    str_minuto = new String (minuto)
    if (str_minuto.length == 1)
    minuto = '0' + minuto

    str_hora = new String (hora)
    if (str_hora.length == 1)
    hora = '0' + hora

    horaImprimible = hora + ' : ' + minuto + ' : ' + segundo

    document.form_reloj.reloj.value = horaImprimible

    setTimeout('mueveReloj()',1000)
}
function abreSitio()
{ 
    var URL = "http://localhost/PROYECTO/AMATS2021-SIST32A-Archivos-GRUPO-01/Administrador/Administrador.php";
    var web = document.form1.opcion.options[document.form1.opcion.selectedIndex].value;
    window.open(URL+web, '_self', '');
}