$(document).ready(function(){
   
   var btnDictamen = $('#btnDictaminar');
   var btnCorreccion = $('#btnCorreccion');
   var slcCatDictamen = $('#slcCatDictamen');
//   var txtObservaciones = $('#txtObservaciones');
   
    // Activa y desactiva los botones de dictaminar y enviar a correción según la opción en select de dictamen
    slcCatDictamen.change(function(){
       var selected = $('#slcCatDictamen option:selected').val();
       console.log("opcion seleccionada" + selected );
       if(selected === '1'){ // <- la opción uno es No aprobado.
            btnCorreccion.removeAttr('disabled');
            btnDictamen.attr('disabled', 'disabled');
       }else{
           btnCorreccion.attr('disabled', 'disabled');
           btnDictamen.removeAttr('disabled');
       }
   });
  
  
    btnCorreccion.click(function(){
        $('modalCorreccion').modal();
    });
    
});


