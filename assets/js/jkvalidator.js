//
// jKey Validador de Campos
//
// Version 1.1
// Forma de Uso:
//        $(document).ready(function(){
//            $(".enteros").Enteros();
//            $(".decimales").Decimales(2);
//            $(".solotexto").SoloTexto();
//            $(".alfanumerico").Alfanumerico();
//        });

(function($){
    //Funciones 
        //Cuenta el número de puntos en una cadena.
    	    function ContarPuntos(input) {
    	        var cant = 0;
    	        if (input != null) {
    	            for(var i = 0; i < input.length; i++) {
    	                if(input[i] == '.')
    	                    cant += 1;
    	            }
    	        }
    	        return cant;
    	    }
        //Cuenta el número de dígitos después de un punto.
    	    function CantidadDecimales(input) {
    	        var cant = 0;
    	        if (input.indexOf(".") != -1)
    	            cant = input.substr(input.indexOf(".") + 1).length;
    	        return cant;
    	    }
        //crear mensaje
            function crear_mensaje(campo, txtmensaje)
            {                
                var existe = $(campo).parent().find('.error_float').length;
                
                //$.sticky(txtmensaje, {autoclose : 4000, position: "top-right", type: "st-error" });
                
                /*
                if(!existe)
                {
                    br = document.createElement('br');                    
                    $(campo).parent().append(br);
                    
                    mensaje = document.createElement('span');
                    $(mensaje).addClass("error_float");
                    qT = $(campo).offset().top;                    
                    sTop = qT-20;
                    qL = $(campo).offset().left;
                    qLeft = qL+5+$(campo).width();
                    $(mensaje).css("top",sTop);
                    $(mensaje).css("left",qLeft);
                    $(campo).parent().append(mensaje);
                    //$(campo).append(mensaje);
                    $(mensaje).html(txtmensaje);
                    $(mensaje).fadeTo("fast",0.90);
                    
                } 
                */            
            }
        //borrar mensaje
            function borrar_mensaje(campo)
            {
                $(campo).parent().find('br').remove();
                $(campo).parent().find('.error_float').remove();
            }
    //funcion para validar correos
    $.fn.Correo = function()
    {        
        jQuery(this).live('keyup',function(e){            
            var email = $(this).val();
            
            expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (expr.test(email))             
			{
			    borrar_mensaje(this); 
	            return true;
	        }
	        else
			{
			    crear_mensaje(this,'Correo no v&aacute;lido.'); 
	            e.preventDefault();
	        }
        });
        jQuery(this).live('blur', function(){
            borrar_mensaje(this);            
        });
    }
    //funcion que permite numeros enteros
    $.fn.Enteros = function()
    {
        jQuery(this).live('keypress',function(e){            
            
            if (e.which >= 48 && e.which <= 57 || e.which == 8 || e.which == 0 || e.which == 13) 
			{
			    borrar_mensaje(this); 
	            return true;
	        }
	        else
			{
			    crear_mensaje(this,'Solo se permite n&uacute;meros enteros');
	            e.preventDefault();
	        }
        });
        jQuery(this).live('blur', function(){
            borrar_mensaje(this);            
        });
        
    };
    //funcion que permite numeros decimales
    $.fn.Decimales = function(NumeroDeDecimales)
    {
        
        jQuery(this).live('keypress',function(e){
            var decimales = 0;
            var text = $(this).val();
	        if (ContarPuntos(text) > 0) 
			{
	            decimales = CantidadDecimales(text);
	        }
	         
	        if (e.which >= 48 && e.which <= 57 && decimales < NumeroDeDecimales || e.which == 8 || e.which == 0) 
			{
			     borrar_mensaje(this);
	            return true;
	        }
	        else 
			{
	            if(text != "" && e.which == 46 && ContarPuntos(text) == 0)
	            {
                    borrar_mensaje(this);
                    return true;	               
	            }    
	            else
				{
				    crear_mensaje(this,'Solo se permite n&uacute;meros, decimales');
	                e.preventDefault();                    
	            }
	        }
        });
            
    };
    //funcion que permite numeros decimales
    $.fn.DecimalesNegativos = function(NumeroDeDecimales)
    {   
        jQuery(this).live('keypress',function(e){
            var decimales = 0;
            var text = $(this).val();
	        if (ContarPuntos(text) > 0) 
			{
	            decimales = CantidadDecimales(text);
	        }
	         
	        if (e.which >= 48 && e.which <= 57 && decimales < NumeroDeDecimales || e.which == 8 || e.which == 0 || e.which == 45) 
			{
			     borrar_mensaje(this);
	            return true;
	        }
	        else 
			{
	            if(text != "" && e.which == 46 && ContarPuntos(text) == 0)
	            {
                    borrar_mensaje(this);
                    return true;	               
	            }    
	            else
				{
				    crear_mensaje(this,'Solo se permite n&uacute;meros, decimales');
	                e.preventDefault();                    
	            }
	        }
        });
            
    };
    //funcion que solo permite texto
    $.fn.SoloTexto = function(){
        jQuery(this).live('keypress',function(e){
            //alert(e.which);
            if ((e.which >= 97 && e.which <= 122) || (e.which >= 65 && e.which <= 90) || e.which == 241 || e.which == 243 || e.which == 250 || e.which == 225 || e.which == 237||  e.which == 233 || e.which == 32 || e.which == 8 || e.which == 0) 
			{
			     borrar_mensaje(this);
	            return true;
	        }
	        else {
	           crear_mensaje(this,'Solo se permite letras');
	            e.preventDefault();
	        }
        });    
    };
    //funcion que permite letras y numeros
    $.fn.Alfanumerico = function(){
        jQuery(this).live('keypress',function(e){
            //alert(e.which);
            if ((e.which >= 48 && e.which <= 57) || (e.which >= 97 && e.which <= 122) || (e.which >= 65 && e.which <= 90) || e.which == 241 || e.which == 243 || e.which == 32 || e.which == 8 || e.which == 0) 
			{
			     borrar_mensaje(this);
	            return true;
	        }
	        else {
	           crear_mensaje(this,'Se permiten letras y n&uacute;meros');
	            e.preventDefault();
	        }            
        });    
    };
    
})(jQuery);