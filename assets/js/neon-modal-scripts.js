jQuery(document).ready(function(){
    jQuery("input.form-control").keyup(function(e){
        jQuery(this).val(jQuery(this).val().toUpperCase());        
    });
    
    if(jQuery.isFunction(jQuery.fn.select2))
	{
		jQuery(".select2").each(function(i, el)
		{
			var $this = jQuery(el),
				opts = {
					allowClear: attrDefault($this, 'allowClear', false)
				};

			$this.select2(opts);
			$this.addClass('visible');
            //$this.select2("open");
		});

		if(jQuery.isFunction(jQuery.fn.niceScroll))
		{
			jQuery(".select2-results").niceScroll({
				cursorcolor: '#d4d4d4',
				cursorborder: '1px solid #ccc',
				railpadding: {right: 3}
			});
		}
	}
    /*
    jQuery(".autocompletar_cuenta").autocomplete({
		source: 'vista/cuenta/buscar_cuenta.php',
        select: function(event, ui){
                    $("#id_cuenta").val(ui.item.id_cuenta);
                    $("#codigo_cuenta").val(ui.item.codigo_cuenta);                        
                    $("#nombre_cuenta").val(ui.item.nombre_cuenta);
                    $("#tipo").val(ui.item.tipo);
                    if(ui.item.tipo == 'Grupo' || ui.item.tipo == 'GRUPO')
                        jAlert("Seleccione una cuenta de DETALLE", "Mensaje", function(res){
                            $(".autocompletar_cuenta").focus();    
                        });
                    else
                        $("#cheque").focus();
                }
	});
    */
    jQuery.fn.datepicker.dates['es'] = {
        days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"],
        daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", "Dom"],
        daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
        months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]
    };

	jQuery(".datepicker").each(function(i, el)
	{
		var $this = jQuery(el),
			opts = {
			    language: 'es', 
				format: attrDefault($this, 'format', 'yyyy-mm-dd'),
				startDate: attrDefault($this, 'startDate', ''),
				endDate: attrDefault($this, 'endDate', ''),
				daysOfWeekDisabled: attrDefault($this, 'disabledDays', ''),
				startView: attrDefault($this, 'startView', 0),
                autoclose: true,
				rtl: rtl()
			},
			$n = $this.next(),
			$p = $this.prev();

		$this.datepicker(opts);

		if($n.is('.input-group-addon') && $n.has('a'))
		{
			$n.on('click', function(ev)
			{
				ev.preventDefault();

				$this.datepicker('show');
			});
		}

		if($p.is('.input-group-addon') && $p.has('a'))
		{
			$p.on('click', function(ev)
			{
				ev.preventDefault();

				$this.datepicker('show');
			});
		}
	});
    
   jQuery(".validate, .validate_edit").validate({		        
		onkeyup: false,
		errorClass: 'error',
		validClass: 'valid',                
        submitHandler: function(form){                    
            jConfirm('Esta seguro de realizar esta acci&oacute;n?','Mensaje',function(resp){
				if (resp){
                    show_loading_bar({
							pct: 60,
                            delay: 5,
                            before: function(pct){
								jQuery(form).ajaxSubmit(function(data){
                                    if(data.indexOf('Error')>=0)
                                        var mensaje = "Ocurrión un error.";
                                    else
                                        var mensaje = "Registrado con &eacute;xito.";
                                    
                                    show_loading_bar({
											wait: .5,
											pct: 100
									});
                                    
                                    jAlert(data,'Mensaje',function(){
                                        if(data.indexOf('Error')>=0)
                                        {
                                            //error
                                        }
                                        else
                                        {
                                            window.location.reload();                                            
                                            //window.history.go(-1);
                                        }
                                    });
                                });
							}
						});
				}
			});
		}				
    });   
});