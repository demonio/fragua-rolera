
function changes_by_size()
{
    var w = $(this).width();

    if (w < 601)
    {
        $('.s').show();
        $('.s0').hide();

        $('aside').hide();
        $('.overlay').hide();
    }
    else if (w > 600 && w < 993)
    {
        $('.m').show();
        $('.m0').hide();
        
        $('aside').hide();
        $('.overlay').hide();
    }
    else
    {
        $('.l0').hide();

        $('aside').show();
        $('.overlay').hide();
    }
}

/**
 * 1) draggable="true"
 * 2) use events:
 *      dragstart
 *      drag
 *      dragenter
 *      dragleave
 *      dragover
 *      drop
 *      dragend
 */
function drag(ev)
{
    ev.dataTransfer.setData('text', ev.target.dataset.href);
}
function dropin(ev)
{
    ev.preventDefault();
    if (ev.target.id) $('#'+ev.target.id).addClass('drop-container');
}
function dropout(ev)
{
    if (ev.target.id) $('#'+ev.target.id).removeClass('drop-container');
}
function drop(ev)
{
    ev.preventDefault();
    if ( ! ev.target.id) return;
    $('#'+ev.target.id).removeClass('drop-container');
    var url = ev.dataTransfer.getData('text');
    var parent = ev.target.dataset.parent;
    if (parent !== undefined) url += '&box_parent='+parent;
    location.href = url;
}

function hide(el)
{
    $(el).hide();
}
