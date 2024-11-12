function Moneda(amount) {
    var val = parseFloat(amount);
    if (isNaN(val))
    { 
        return "0.00"; 
    }
    if (val <= 0) 
    { 
        return "0.00"; 
    }
    val += "";
    
    if (val.indexOf('.') == -1) 
    { 
        return val+".00"; 
    }
    else 
    { 
        val = val.substring(0,val.indexOf('.')+3); 
    }
    
    val = (val == Math.floor(val)) ? val + '.00' : ((val*10 == Math.floor(val*10)) ? val + '0' : val);
    
    return val;
}
function round_my(num)
{
    var n = Math.trunc(parseFloat(num)*10)/10;
    
    return Moneda(n);  
}
function round2(num)
{
    var n = Math.round(parseFloat(num)*100)/100; 
    
    return Moneda(n);  
}
function trunc2(num)
{
    return Moneda(Math.trunc(num));
}
function showObs() {
    elemento1 = document.getElementById("vehiculo");
    element = document.getElementById("obs");
    detalle_salida = document.getElementById("detalle_salida");
    hora_h = document.getElementById("hora_h");
    
    hora_hasta = document.getElementById("hora_hasta");
    hora_desde = document.getElementById("hora_desde");
    check = document.getElementById("tipo_salida2");
    check2 = document.getElementById("tipo_salida1");
    check4 = document.getElementById("tipo_salida4");
    if (check.checked) {
        element.style.display='block';
        elemento1.style.display='none';
        hora_hasta.value =hora_desde.value 
        jQuery('#hora_hasta').attr('readonly', false);
        calculardif();
        detalle_salida.style.display='block';
        hora_h.style.display='block';
    }
    else if(check2.checked){
        elemento1.style.display='block';
        element.style.display='none';
        hora_hasta.value =hora_desde.value
        jQuery('#hora_hasta').attr('readonly', false);
        calculardif();
        detalle_salida.style.display='block';
        hora_h.style.display='block';
    }
    else if(check4.checked){
        let hora_split = hora_desde.value.split(':')
        hora_regreso = parseInt(hora_split[0]) + 1;
        hora_hasta.value = hora_regreso + ":" + hora_split[1]
        elemento1.style.display='none';
        element.style.display='none';
        detalle_salida.style.display='none';
        hora_h.style.display='none';
        jQuery('#hora_hasta').attr('readonly', true);
        document.getElementById("horas_justificacion_real").value = "01:00";
    }
    else{
        element.style.display='none';
        elemento1.style.display='none';
        detalle_salida.style.display='block';
        hora_h.style.display='block';
        hora_hasta.value =hora_desde.value
        jQuery('#hora_hasta').attr('readonly', false);
        calculardif();
    }
}
function calculardif(){
    var hora_inicio = document.getElementById("hora_desde").value
    var hora_final = document.getElementById("hora_hasta").value
    check2 = document.getElementById("tipo_salida2");
    
    // Expresión regular para comprobar formato
    var formatohora = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
    
    // Si algún valor no tiene formato correcto sale
    if (!(hora_inicio.match(formatohora)
          && hora_final.match(formatohora))){
      return;
    }
    
    // Calcula los minutos de cada hora
    var minutos_inicio = hora_inicio.split(':')
      .reduce((p, c) => parseInt(p) * 60 + parseInt(c));
    var minutos_final = hora_final.split(':')
      .reduce((p, c) => parseInt(p) * 60 + parseInt(c));
    
    // Si la hora final es anterior a la hora inicial sale
    if (minutos_final < minutos_inicio) return;
    
    // Diferencia de minutos
    var diferencia = minutos_final - minutos_inicio;
    
    // Cálculo de horas y minutos de la diferencia
    var horas = Math.floor(diferencia / 60);
    var minutos = diferencia % 60;
    
    // $('#horas_justificacion_real').val(horas + ':'
    //   + (minutos < 10 ? '0' : '') + minutos);  
    if(check2.checked){
        console.log("ENTRO");
        if(horas<=1 && minutos !=0)
        {
            horas = '0';
            document.getElementById("horas_justificacion_real").value = horas + ':' + (minutos < 10 ? '0' : '') + minutos;
            document.getElementById("horas_justificacion_real").style.borderColor ='';
        }
        else if(horas>1 && minutos>=0)
        {
            horas = '1';
            minutos="0";
            document.getElementById("horas_justificacion_real").value = horas + ':' + (minutos < 10 ? '0' : '') + minutos;
            document.getElementById("horas_justificacion_real").style.borderColor ='red';
        }
        else{
            document.getElementById("horas_justificacion_real").value = horas + ':' + (minutos < 10 ? '0' : '') + minutos;
            document.getElementById("horas_justificacion_real").style.borderColor ='red';
        }
    }
    else
    {
        document.getElementById("horas_justificacion_real").style.borderColor ='';
        console.log("ENTRO 1");
        document.getElementById("horas_justificacion_real").value = horas + ':' + (minutos < 10 ? '0' : '') + minutos;
    }
  }

jQuery(document).ready(function($){
    $("#menu").click(function(e){
       e.preventDefault();
       $.post("vista/paginas/cambiar_menu.php",{},function(data){}); 
    });
    
   jQuery("a.accion").live("click",function(e){
        e.preventDefault();
        var dir = $(this).attr("href");
        jConfirm("Esta seguro de esta acci&oacute;n?","Mensaje",function(resp){
           if(resp)
           {
                $.post(dir,{},function(data){
                    jAlert(data,"Mensaje",function(){
                        if(data.indexOf("error")>=0 || data.indexOf("Error")>=0){}
                        else
                            window.location.reload(); 
                    });
                });
           } 
        });
   });
   
   jQuery("a.update").live("click",function(e){
        e.preventDefault();
        var dir = $(this).attr("href");
        jConfirm("Esta seguro de esta acci&oacute;n?","Mensaje",function(resp){
           if(resp){
                show_loading_bar({
					pct: 80,
                    delay: 5,
                    before: function(pct){                        
						$.post(dir,{},function(data){
						    show_loading_bar({
                                wait: .5,
                                pct: 100
    						});  
                            jAlert(data,"Mensaje",function(){
                                if(data.indexOf("error")>=0 || data.indexOf("Error")>=0){                            
                                }else{                                    
                                    window.location.reload();
                                }
                            });
                        });
					}
				});
           } 
        });
   });
   
   jQuery("a.ordenar").live("click",function(e){
        e.preventDefault();
        var dir = $(this).attr("href");
        jConfirm("Esta seguro de esta acci&oacute;n?","Mensaje",function(resp){
           if(resp)
           {
                 $.post(dir,{},function(data){
                    window.location.reload();
                });
           } 
        });
       
   });
   
   jQuery("a.salir").live("click",function(e){
        e.preventDefault();
        var dir = $(this).attr("href");
        jConfirm("Esta seguro de salir?","Mensaje",function(resp){
           if(resp)
           {
                 $.post(dir,{},function(data){
                   jAlert(data,"Mensaje",function(){});
                   
                   window.location.href = 'index.php';
                                     
                });
           } 
        });
       
   });
   
   jQuery(".cancelar").live("click",function(e){
        window.history.back();        
   });
   
   jQuery(".cancelar2").live("click",function(e){
        window.history.go(-2);        
   });
   
   /*  
   $("[type=reset]").click(function(e){
       e.preventDefault(); 
       jConfirm("Esta seguro de borrar todos los datos llenados?","Mensaje",function(res){
          if(res){
             $(".validate").resetForm();
          }  
       });            
   });
   */
    
    $(".enteros").Enteros();
    $(".decimales").Decimales(2);
    $(".decimales3").Decimales(3);
    $(".decimales4").Decimales(4);
    $(".ufv").Decimales(5);
    $(".solotexto").SoloTexto();
    $(".alfanumerico").Alfanumerico();
    
    $(".lector_codigo").keydown(function(e){
        var key = e.which;         
        if(key == 13){
            return false;
        }
    });   
    
    $("input.form-control").keyup(function(e){
        $(this).val($(this).val().toUpperCase());        
    });
    
    jQuery(".modal_ajax").live("click",function(e){
        e.preventDefault();
        var param = $(this).attr('href');
        var dir = "modal_index_ajax.php" + param;
        jQuery('#modal-ajax').modal('show', {backdrop: 'static'});
        jQuery('#modal-ajax').draggable({handle: ".modal-header"});
        jQuery("#modal-ajax .modal-body").load(dir, function(res){
           if(res){
                var titulo = jQuery('#modal-ajax .modal-body h2').html();
                jQuery('#modal-ajax .modal-body h2').hide();
                jQuery('#modal-ajax .modal-body br').hide();
                jQuery('#modal-ajax .modal-title').html(titulo);
                jQuery('#modal-ajax .modal-body .cancelar').hide();
                jQuery('#modal-ajax .modal-body .form-group:last').hide();
                jQuery('#modal-ajax .modal-footer .submit').live("click", function(e){
                    e.preventDefault();
                    jQuery('#modal-ajax .modal-body form').submit();
                }); 
           } 
        });
    });
    
    jQuery(".modal_ajax_reporte").live("click",function(e){
        e.preventDefault();
        var param = $(this).attr('href');
        var dir = "modal_index_ajax.php" + param;
        jQuery('#modal-ajax-reporte').modal('show', {backdrop: 'static'});
        jQuery('#modal-ajax-reporte').draggable({handle: ".modal-header"});
        jQuery("#modal-ajax-reporte .modal-body").load(dir, function(res){
           if(res){
                var titulo = jQuery('#modal-ajax-reporte .modal-body h2').html();
                jQuery('#modal-ajax-reporte .modal-body h2').hide();
                jQuery('#modal-ajax-reporte .modal-body br').hide();
                jQuery('#modal-ajax-reporte .modal-title').html(titulo);
                jQuery('#modal-ajax-reporte .modal-body .cancelar').hide();   
                jQuery('#modal-ajax-reporte .modal-body .form-group:last').hide();             
                jQuery('#modal-ajax-reporte .modal-footer .submit').live("click", function(e){
                    e.preventDefault();
                    jQuery('#modal-ajax-reporte .modal-body form').submit();
                }); 
           } 
        });
    });
    
    $("#planta").change(function(){
           var planta = $(this).val();
           
           $.post("vista/bloque/select_bloques.php",{planta:planta},function(data){
               $("#bloque").html(data);
           });
     });
     
     $("#bloque").change(function(){
           var bloque = $(this).val();
           
           $.post("vista/nicho/select_nichos.php",{bloque:bloque},function(data){
               $("#nicho").html(data);
           });            
     });
     
     $("#id_afiliado").change(function(){
           var id_afiliado = $(this).val();
           
           $.post("vista/beneficiario/select_beneficiario.php",{id_afiliado:id_afiliado},function(data){
               $("#id_beneficiario").html(data);
           });
     });
     
     $("#cupo").change(function(){
           var cupo = $(this).val();
           
           $.post("vista/viaje/saldo_cupo.php",{cupo:cupo},function(data){
               $("#saldo_cupo").val(data);
           });
            
     });
     
     $("#comprobante").change(function(){
           var comprobante = $(this).val();
           
           $.post("vista/movimiento/get_numero_comprobante.php",{comprobante:comprobante},function(data){
               $("#numero").val(data);
               $("#beneficiario").focus();
           });            
     });
     
     jQuery(".actualizar").live("click",function(e){
           e.preventDefault();
           var href = $(this).attr("href");
           ventana = window.open(href, "Visor PDF");           
           window.location.reload();
           //ventana.print();        
     });
     
     $("#herramienta").change(function(){
           var herramienta = $(this).val();
           
           $.post("vista/cola_espera/ultimo_destino.php",{herramienta:herramienta},function(data){
               $("#ciudad").html(data);
           });
     });

      $("#ciudad").change(function(){
           var ciudad = $(this).val();
           
           $.post("vista/asignar_carga/select_turno.php",{ciudad:ciudad},function(data){
               $("#turno").html(data);
           });
     });

      $("#id_tipo_viaje").change(function(){
           var tipo_viaje = $(this).val();
           
           $.post("vista/herramienta/select_herramienta_tipo_viaje.php",{tipo:tipo_viaje},function(data){
               $("#capacidad_h").html(data);
           });
     });

      $("#capacidad_h").change(function(){
           var herramienta = $(this).val();
           
           $.post("vista/asignar_carga/capacidad_herramienta.php",{herramienta:herramienta},function(data){
               $("#capacidad").html(data);
           });
     });

     $("#primera_carga").change(function(){
           var primera = $(this).val();
           if(primera == 'Primera'){
                $(".ocultar").hide();
           }else{
                $(".ocultar").show();
           }
     });
     
    $("input[data-focus]").keypress(function(e){
        var key = e.which;      
        var input = $(this).attr('data-focus');
        if(key == 13){
            $("#"+input).focus();
            return false;
        }
    });
     
    $("#id_cargo").change(function(){
           var cargo_salario = $(this).val();
           
           $.post("vista/cargo/select_salario_cargo.php",{id_cargo:cargo_salario},function(data){
               $("#salario").html(data);
           });
     });

     $("#numero_mes").change(function(){
           var numero_mes = $(this).val();
           
           $.post("vista/nombre_planilla/select_mes_numero.php",{numero_mes:numero_mes},function(data){
               $("#mes").html(data);
           });
     });
     
      
    /* 
    Webcam.set({
        width: 490,
        height: 390,
        image_format: 'jpeg',
        jpeg_quality: 90
    });

    Webcam.attach( '#camera' );

    $("#btn-camera").click(function(e){
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        });
    });
    */
    
});



