
$(document).ajaxStart(function()
{
});
$(document).ajaxComplete(function()
{
    materialize();
});

$(window).resize(function()
{
    changes_by_size();
});

$(window).scroll(function()
{
});

$(function()
{
    M.AutoInit();

    changes_by_size();

    /* OCULTA ALGO */
    $('body').on('click', '[data-hide]', function()
    {
        var to = $(this).data('hide');
        $(to).hide();
    });

    /* MUESTRA Y OCULTA ALGO */
    $('body').on('click', '[data-toggle]', function()
    {
        var to = $(this).data('toggle');
        $(to).toggle();
    });

    /* CARGA CONTENIDO EN UN MODAL Y LO ABRE
    $('body').on('click', '.load-modal', function(e)
    {
        e.preventDefault();
        console.log( $('.modal').modal() );
        return;
        $('<div class="modal pa15"></div>').appendTo('body');
        var elem = $('.modal');
        var instance = M.Modal.getInstance(elem);
        instance.open();
        var url = $(this).attr('href');
        $(elem).load(url);
        //$('<div class="modal pa15"></div>').load(url).modal('open');
    }); */
});