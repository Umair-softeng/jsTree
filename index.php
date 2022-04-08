<?php
    
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JsTree</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />

</head>
<body>

    <div id="jsTree"></div>
    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){ 
            //fill data to tree  with AJAX call
            $('#jsTree').jstree({
                'core' : {
                    'data' : {
                    'url' : 'conf.php',
                    'data' : function (node) {
                        return { 'id' : node.id };
                    },
                "dataType" : "json"
                    },
                    'check_callback' : true,
                    'themes' : {
                    'responsive' : false
                }
            },
            'plugins' : ['state','contextmenu','wholerow']
            }).on('create_node.jstree', function (e, data) {
                    
                $.get('conf.php', { 'id' : data.node.parent, 'position' : data.position, 'text' : data.node.text })
                    .done(function (d) {
                    data.instance.set_id(data.node, d.id);
                    })
                    .fail(function () {
                    data.instance.refresh();
                    });
                }).on('rename_node.jstree', function (e, data) {
                $.get('conf.php', { 'id' : data.node.id, 'text' : data.text })
                    .fail(function () {
                    data.instance.refresh();
                    });
                }).on('delete_node.jstree', function (e, data) {
                $.get('conf.php', { 'id' : data.node.id })
                    .fail(function () {
                    data.instance.refresh();
                    });
                });
        });
    </script>
</body>
</html>