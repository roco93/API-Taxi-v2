<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Drag_Drop</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url()?>assets/drag.js"> </script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/drag.css"/>

    <style type="text/css">
        

.dropp{
    height: 200px;
    width: 30%;
    border:1px solid black;
    float: left;
    padding: 10px;


}
.drag{
    height: 150px;
    width: 200px;
    background: red;
    margin: auto;           
}
#matriz{
    height: 600px;
    width: 100%;
    text-align: center;

}
.gris{
    background: silver;
}
    </style>

</head>
<body>
    <h2>Prueba</h2>
    <div id="matriz">
        <div id="s1" class="dropp">
            <div id="a1" class="drag">div1</div>
        </div>
        <div id="s2" class="dropp"></div>
        <div id="s3" class="dropp"></div>

        <div id="s4" class="dropp"></div>
        <div id="s5" class="dropp">
            <div id="a2" class="drag">div2</div>
        </div>
        <div id="s6" class="dropp"></div>

        <div id="s7" class="dropp"></div>
        <div id="s8" class="dropp"></div>
        <div id="s9" class="dropp">
            <div id="a3" class="drag">div3</div>
        </div>
    </div>
</body>
</html>