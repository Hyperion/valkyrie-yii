<?php
$this->breadcrumbs = array(
    'Меню' => array('admin'),
    'Управление',
);
?>

<script type="text/javascript">

    window.Tree = null;
    window.clipboardNode = null;
    window.pasteMode = null;
    var site_dir = '<?php echo Yii::app()->request->baseUrl; ?>/index.php';
    $(function(){
        Tree = $("#tree");
        Tree.dynatree({
            initAjax: {
                url: site_dir+"/menu/json"
            },
            minExpandLevel: 3,
            onActivate: function(node) {
                // A DynaTreeNode object is passed to the activation handler
                // Note: we also get this event, if persistence is on, and the page is reloaded.
                //alert("You activated " + node.data.title);
            },
            onClick: function(node, event) {
                // Close menu on click
                if( $(".contextMenu:visible").length > 0 ){
                    $(".contextMenu").hide();
                    // return false;
                }
            },
            onDblClick: function(node, event) {
                // Close menu on click
                if( $(".contextMenu:visible").length > 0 ){
                    $(".contextMenu").hide();
                    // return false;
                }
                if(node.getLevel() >= 2)
                    showNodeEditForm(node);
            },
            onKeydown: function(node, event) {
                // Eat keyboard events, when a menu is open
                if( $(".contextMenu:visible").length > 0 )
                    return false;

                switch( event.which ) {

                    // Open context menu on [Space] key (simulate right click)
                    case 32: // [Space]

                        if(node.data.id != 1) {
                            $(node.span)
                            .trigger("mousedown", {
                                preventDefault: true,
                                button: 2
                            })
                            .trigger("mouseup", {
                                preventDefault: true,
                                pageX: node.span.offsetLeft,
                                pageY: node.span.offsetTop,
                                button: 2
                            });
                        }

                        return false;

                    // Handle Ctrl-C, -X and -V
                case 67:
                    if( event.ctrlKey ) { // Ctrl-C
                        copyPaste("copy", node);
                        return false;
                    }
                    break;
                case 86:
                    if( event.ctrlKey ) { // Ctrl-V
                        copyPaste("paste", node);
                        return false;
                    }
                    break;
                case 88:
                    if( event.ctrlKey ) { // Ctrl-X
                        copyPaste("cut", node);
                        return false;
                    }
                    break;
            }
        },
        onCreate: function(node, span){
            bindContextMenu(span);
        },
        dnd: {
            onDragStart: function(node) {
                /** This function MUST be defined to enable dragging for the tree.
                 *  Return false to cancel dragging of node.
                 */
                return true;
            },
            onDragStop: function(node) {
                // This function is optional.
            },
            autoExpandMS: 1000,
            preventVoidMoves: true, // Prevent dropping nodes 'before self', etc.
            onDragEnter: function(node, sourceNode) {
                /** sourceNode may be null for non-dynatree droppables.
                 *  Return false to disallow dropping on node. In this case
                 *  onDragOver and onDragLeave are not called.
                 *  Return 'over', 'before, or 'after' to force a hitMode.
                 *  Return ['before', 'after'] to restrict available hitModes.
                 *  Any other return value will calc the hitMode from the cursor position.
                 */
                // Prevent dropping a parent below it's own child
                //                    if(node.isDescendantOf(sourceNode))
                //                        return false;
                // Prevent dropping a parent below another parent (only sort
                // nodes under the same parent)
                //                    if(node.parent !== sourceNode.parent)
                //                        return false;
                // if(node === sourceNode)
                //   return false;
                // Don't allow dropping *over* a node (would create a child)
                // return ["before", "after"];

                var rootNode = Tree.dynatree("getTree").getNodeByKey("id1");
                if(node.data.id == rootNode.data.id)
                    return false;

                return true;
            },
            onDragOver: function(node, sourceNode, hitMode) {
                /** Return false to disallow dropping this node.
                 *
                 */
                // Prevent dropping a parent below it's own child
                if(node.isDescendantOf(sourceNode))
                    return false;
                // Prohibit creating childs in non-folders (only sorting allowed)
                //				if( !node.isFolder && hitMode == "over" )
                //					return "after";
            },
            onDrop: function(node, sourceNode, hitMode, ui, draggable) {
                /** This function MUST be defined to enable dropping of items on
                 * the tree.
                 */
                sourceNode.move(node, hitMode);
                // expand the drop target
                $.post(site_dir+"/menu/move", {
                    'node':node.data,
                    'sourceNode':sourceNode.data,
                    'hitMode':hitMode
                }, function(responceText){
                    sourceNode.expand(true);
                    node.expand(true);
                });
            },
            onDragLeave: function(node, sourceNode) {
                /** Always called if onDragEnter was called.
                 */
            }
        }
    });
});

function hideToolbar()
{
    if(typeof arguments[0] == 'boolean' && arguments[0] === true) {
        $('#toolbar').slideUp(200).empty();
    } else {
        $('#toolbar').slideUp(200);
    }
}

function showNodeEditForm(node) {
    $.post(site_dir+"/menu/update/" + node.data.id, {}, function(responceText){
        $('#nodeform').empty();
        $('#nodeform').html(responceText);
    });
}
function showNodeCreateForm(node) {
    $.post(site_dir+"/menu/create", {
        'root':node.data.id
        }, function(responceText){
        $('#nodeform').empty();
        $('#nodeform').html(responceText);
    });
}

function createNode()
{
    $.post(site_dir+"/menu/create",
    $('.treenodeform').serialize(),
    function(responceText){
        if (responceText == 'error') {
            showError('Ошибка создания формы');
            return;
        }
        var json = parseJSON(responceText);
        if (json)
        {
            var treeNode = Tree.dynatree("getTree").getNodeByKey("id" + $('#toolbar input[name="root"]').val());
            hideToolbar(true);
            var obj = {
                id: json.id,
                key: "id"+json.id,
                isFolder: false,
                title: json.title
            };
            treeNode.addChild(obj);
            hideToolbar(true);
        }
    });
}
function parseJSON(str){
    if ($.trim(str) == '') return false;
    return !(/[^,:{}\[\]0-9.\-+Eaeflnr-u \n\r\t]/.test(str.replace(/"(\\.|[^"\\])*"/g, ''))) && eval('(' + str + ')');
}
function updateNode()
{
    var form = $('#toolbar form');
    var id = form.find('input[name="Menu\[id\]"]').val();
    $.post(site_dir+"/menu/update/" + id, $('.treenodeform').serialize(), function(responceText){
        if (responceText == 'complete')
        {
            var treeKey = "id" + id;
            var treeNode = Tree.dynatree("getTree").getNodeByKey(treeKey);
            var new_title = form.find('input[name="Menu\[title\]"]').val();
            treeNode.setTitle(new_title);
            hideToolbar(true);
        }
        else
        {
            showError(responceText);
        }
    });
}
function deleteNode(node)
{
    $.post(site_dir+"/menu/delete", {
        'id' : node.data.id
    },
    function(responceText){
        if (responceText == 'complete')
        {
            node.parent.removeChild(node);
        }
        else
        {
            showError(responceText);
        }
    });
}
function cancelNode()
{
    hideToolbar(true);
}
function showError(text)
{
    $('.alert-error').html(text);
    $('.alert-error').show().delay(3000).slideUp();
}

// --- Implement Cut/Copy/Paste --------------------------------------------

function copyPaste(action, node) {
    switch(action) {
        case "cut":
        case "copy":
            clipboardNode = node;
            pasteMode = action;
            break;
        case "paste":
            if( !clipboardNode ) {
                alert("Clipoard is empty.");
                break;
            }
            if( pasteMode == "cut" ) {
                // Cut mode: check for recursion and remove source
                var isRecursive = false;
                var cb = clipboardNode.toDict(true, function(dict){
                    // If one of the source nodes is the target, we must not move
                    if( dict.key == node.data.key )
                        isRecursive = true;
                });
                if( isRecursive ) {
                    alert("Cannot move a node to a sub node.");
                    return;
                }
                node.addChild(cb);
                clipboardNode.remove();
            } else {
                // Copy mode: prevent duplicate keys:
                var cb = clipboardNode.toDict(true, function(dict){
                    dict.title = "Copy of " + dict.title;
                    delete dict.key; // Remove key, so a new one will be created
                });
                node.addChild(cb);
            }
            clipboardNode = pasteMode = null;
            break;
        default:
            alert("Unhandled clipboard action '" + action + "'");
    }
};

// --- Contextmenu helper --------------------------------------------------
function bindContextMenu(span) {
    $(span).contextMenu({menu: "myMenu"}, function(action, el, pos) {
        var node = $.ui.dynatree.getNode(el);
        switch( action ) {
            case "cut":
            case "copy":
            case "paste":
                copyPaste(action, node);
                break;
            case "edit":

                showNodeEditForm(node);
                break;
            case "add_over":
                showNodeCreateForm(node);
                break;
            case "delete":
                if(confirm("Подтвердите удаление"))
                    deleteNode(node);
                break;
            default:
                alert("Todo: appply action '" + action + "' to node " + node);
        }
    });
};

</script>
<script>
function changeURL(url, title, alt){
    $("#Menu_url").val(url);
    $("#Menu_title").val(title);
    $("#Menu_alt").val(alt);
    $("#mydialog").dialog("close");
    return false;
};
</script>
<!-- class: ui-state-highlight ui-corner-all -->

<h1>Управление меню</h1>

<div class="alert alert-error">
</div>

<div class="" style="margin:0 0 12px 0;padding:0 8px;">
    <h3>Раздел управления меню сайта</h3>
    <div class="alert alert-info">
        Действия над элементами выбираются в контекстном меню <b>правым щелчком мыши</b>.<br />
        Двойное нажатие левой кнопки миши - редактирование элемента.
    </div>
</div>

<ul id="myMenu" class="contextMenu">
    <li class="insert_bottom"><a href="#add_over">Вставить элемент</a></li>
    <li class="edit2"><a href="#edit">Редактировать</a></li>
    <!--<li class="cut separator"><a href="#cut">Cut</a></li>
    <li class="copy"><a href="#copy">Copy</a></li>
    <li class="paste"><a href="#paste">Paste</a></li>-->
    <li class="minus separator"><a href="#delete">Удалить</a></li>
    <!--<li class="quit separator"><a href="#quit">Quit</a></li>-->
</ul>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'      => 'mydialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title'         => 'Привязка',
        'autoOpen'      => false,
        'closeOnEscape' => true,
        'modal'         => true,
        'width'         => 'auto',
        'buttons'       => array(
            Yii::t('button', 'Закрыть') => 'js:function(){ $(this).dialog("close"); }',
        ),
    ),
));
$this->widget('application.components.widgets.TreeMenu');
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<div id="tree"></div>
<div id="nodeform"></div>
<script>
$(document).ready(function() {
    $(".alert-error").hide();
});
</script>