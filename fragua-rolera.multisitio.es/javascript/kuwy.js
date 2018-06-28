
$.fn.kuwy = function()
{
    return this.each(function()
    {
        //
        // INICIALIZACIÓN
        //

        // Si el elemento que instancia el plugin ya ha sido inicializado, retornar.
        if ($(this).data('data-kuwy'))
        {
          return this;
        }

        if (!$(this).is('textarea'))
        {
          throw new Error('El elemento debe ser un <textarea />.');
        }

        // Crear configuración de instancia
        var conf =
        {
          $output: $(this),
          id: 'kuwy-' + (new Date()).getTime() + Math.round(Math.random() * 10000),
        };

        // Guardar referencia de la instancia.
        conf.$output.data('data-kuwy', conf);

        //
        // ESTRUCTURA
        //

        // Textarea.
        $(conf.$output).addClass('kuwy-textarea');
        $(conf.$output).hide(0);

        // Editor.
        conf.$container = $('<div class="kuwy-flow-text kuwy '+ conf.id +'"></div>');
        conf.$editor = $('<div class="kuwy-content" contenteditable></div>');

        conf.$container.append(conf.$editor);
        conf.$output.before(conf.$container);

        var currentContent = $(conf.$output).val();
        $(conf.$editor).html(currentContent);

        // Barra de menu.
        conf.$menu = $('<div class="kuwy-menu"></div>');
        $(conf.$editor).before(conf.$menu);

        // Botones del menu.
        $('<a class="kuwy-btn html" title="html" href="javascript:void(0)"></a>').appendTo(conf.$menu);

        // Crear lista de botones del menú.
        var btn =
        [
            {tag:'removeformat'},       
            {tag:'undo'},        
            {tag:'redo'},       
            {tag:'bold'},       
            {tag:'italic'},   
            {tag:'underline'},    
            {tag:'strikeThrough'},     
            {tag:'justifyLeft'},    
            {tag:'justifyCenter'},  
            {tag:'justifyRight'},    
            {tag:'justifyFull'},      
            {tag:'indent'},       
            {tag:'outdent'},      
            {tag:'insertUnorderedList'},      
            {tag:'insertOrderedList'},      
            {tag:'inserthorizontalrule'},       
            {tag:'blockquote'},        
            {tag:'h1'},      
            {tag:'h2'},      
            {tag:'h3'},      
            {tag:'h4'},      
            {tag:'h5'},       
            {tag:'h6'},     
            {tag:'p'},   
            {tag:'subscript'},     
            {tag:'superscript'},     
            {tag:'fontname', items:['cursive', 'fantasy', 'georgia', 'monospace', 'tahoma', 'times', 'verdana']},     
            {tag:'fontsize', items:[1,2,3,4,5,6,7]},  
            {tag:'forecolor'},        
            {tag:'backcolor'},   
            {tag:'createLink'},     
            {tag:'insertImage'},
        ];

        var i;
        var n_btn = btn.length;

        for (i=0; i<n_btn; ++i)
        {
            var tag = btn[i].tag;

            // ESTOS BOTONES INSERTAN UN PARAMETRO PREDEFINIDO EN UN COMBO
            if (btn[i].items && btn[i].items.length)      
            {
                // BOTON QUE ABRE UN COMBO
                $('<a class="kuwy-btn '+tag+' kuwy-toggle-options" data-to="'+tag+'" title="'+tag+'" href="javascript:void(0)"></a>').appendTo(conf.$menu);

                // COMBO PREDEFINIDO
                var ii;
                var n_items = btn[i].items.length;

                $('<ul class="'+tag+' kuwy-options"></ul>').appendTo('.'+tag+'.kuwy-toggle-options');

                for (ii=0; ii<n_items; ++ii)            
                {
                    var item = btn[i].items[ii];
                    $('<li><a class="kuwy-btn" data-role="'+tag+'" data-value="'+item+'" href="javascript:void(0)">'+item+'</a></li>').appendTo('ul.'+tag+'.kuwy-options');
                }
            }
            else       
            {
                // BOTON ESTANDAR
                $('<a class="kuwy-btn '+tag+'" data-role="'+tag+'" title="'+tag+'" href="javascript:void(0)"></a>').appendTo(conf.$menu);
            }
        }

        // CAMPO DE TEXTO PARA LOS BOTONES QUE NECESITAN UN PARAMETRO
        conf.$input = $('<input class="kuwy '+conf.id+'" placeholder="Los 4 iconos de abajo necesitan un parametro aquí -> Después selecciona el texto -> Y haz click en uno de esos 4 botones.">');
        $('.kuwy.'+conf.id+' a[data-role="forecolor"]').before(conf.$input);

        //
        // EVENTOS
        //

        // El boton para ver el HTML: oculta el editor y muestra el textarea o viceversa
        conf.$menu.on('click', '.kuwy-btn.html', function()
        {
            conf.$editor[conf.$editor.is(':visible') ? 'hide' : 'show'](0);
            conf.$output[conf.$output.is(':visible') ? 'hide' : 'show'](0);
        });

        // EL BOTON PARA VER EL HTML OCULTA EL EDITOR Y MUESTRA EL TEXTAREA
        conf.$container.find('.kuwy-btn.kuwy-toggle-options').click(function()
        {
            var to = $(this).data('to');
            conf.$container.find('ul.kuwy-options').not('.'+to+'.kuwy-options').hide();
            conf.$container.find('.'+to+'.kuwy-options').toggle();
        });

        // LOS EFECTOS DE CADA BOTON SE APLICA SEGUN SU ROL Y EXCEPCIONES
        conf.$menu.find('a').click(function()
        {
            var role = $(this).data('role');
            var input_kuwy = conf.$input.val();
            var value = $(this).data('value');

            switch(role)
            {
                case 'blockquote':
                case 'h1':
                case 'h2':
                case 'h3':
                case 'h4':
                case 'h5':
                case 'h6':
                case 'p':
                    document.execCommand('formatBlock', false, role);
                    break;
                case 'fontname':
                case 'fontsize':
                    document.execCommand(role, false, value);
                    conf.$container.find('.kuwy-btn.toggle-options').trigger();
                    break;
                case 'backcolor':
                case 'createLink':
                case 'forecolor':
                case 'insertImage':
                    document.execCommand(role, false, input_kuwy);
                    break;
                case 'removeformat':
                    document.execCommand(role, false, null);
                    document.execCommand('unlink', false, null);
                    break;
                default:
                    document.execCommand(role, false, null);
                    break;
            }

            // ACTUALIZA EL AREA DE TEXTO EL FORMULARIO
            conf.$editor.val( conf.$output.html() );
        });

        // EL EDITOR MANTIENE ACTUALIZADO EL AREA DE TEXTO EL FORMULARIO CON DIVERSOS EVENTOS
        $(conf.$editor).on('blur keyup paste copy cut mouseup', function()
        {
            conf.$output.val( $(this).html() ).trigger('change');
        });

        // EL AREA DE TEXTO TAMBIEN ACTUALIZA EL EDITOR
        $(conf.$output).on('blur keyup paste copy cut mouseup', function()
        {
            conf.$editor.html( $(this).val() );
        });

        return this;
    });
};

$(function()
{
    $('.kuwy-editor').kuwy();
});
