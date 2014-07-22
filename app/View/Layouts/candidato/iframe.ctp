
<!DOCTYPE html>
<html lang="en">

    <head>
      
        <meta charset="utf-8">
        <title>::Nuestro Empleo:: Tu espacio laboral en internet</title>
        <meta http-equiv="X-UA-Compatible" content="IE=8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Nuesto Empleo es un espacio laboral en internet que te ayudará a conseguir contactos laborales confiables.">
        <meta name="subject" content="Tu espacio laboral en internet"/>
        <meta name="keywords" content="Empleo, red laboral, bolsa de trabajo, trabajo, nuestro empleo."/>


        <?php   
             echo $this->Html->meta('icon');
              echo $this->Html->charset();
              echo $this->AssetCompress->css('fonts.css');              
              echo $this->AssetCompress->css('main.css');        
              echo $this->AssetCompress->includeCss();


             echo $this->fetch('meta');  
            echo $this->Html->script('vendor/modernizr.custom.min');   
        ?> 
    
     
        <!--[if lte IE 8]>
            <link rel="stylesheet" type="text/css" href="/css/app/inicio/ie8.css" />
        <![endif]-->

            

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <!-- hojas de estilos aleatorias-->
        <!--link rel="stylesheet" href="" type="text/css">
          <script type="text/javascript">
          num=4;
          rnd = Math.ceil(Math.random()*num);
          document.getElementsByTagName('link')[0].href = '/css/style'+rnd+'.css';
          </script-->
    
    </head>

    <body >

        <!-- Header -->
<div id="out_container" class="boxed">
  <!-- ventana emergente-->
                         <!-- termina ventana emergente-->
        <?=$this->fetch("content") ?>    
</div>
  


    <?=$this->AssetCompress->script('jquery.js')  ?>
    <?=$this->AssetCompress->script('plugins.js')  ?>
    <?=$this->AssetCompress->includeJs() ?>
    <?=$this->fetch('script') ?>
     <?=$this->fetch('css') ?>

      

        <!-- Termina porcentaje circular -->
    </body>

</html>

