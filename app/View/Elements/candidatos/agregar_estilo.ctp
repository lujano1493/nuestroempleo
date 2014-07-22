<?php
    $define_css="";
    if(empty($micrositio)){
        $style=$styleApp['css'];
        $style= $style == 0 ? "" :$style;
        $define_css="app/inicio/style{$style}";
    }
    else{
       
        $define_css=$micrositio['src_css'];

    }
     echo $this->Html->css($define_css);


?>



       <!--[if lte IE 8]>
            <link rel="stylesheet" type="text/css" href="/css/app/inicio/ie8.css" />
        <![endif]-->



        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
