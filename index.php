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
            'plugins': ["wholerow", "dnd", "contextmenu"],
                'core' : {
                    'data' : {
                        "check_callback": true,
                        "url" : "conf.php",
                        "plugins" : [ "wholerow", "checkbox" ],
                        "dataType" : "json" // needed only if you do not supply JSON headers
                    }
                }
            }) 
        });
    </script>
</body>
</html>