<div class="navbar">
  <div class="navbar-inner padding_0">
    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a> 
    <div class="nav-collapse collapse">
      <ul class="nav pull-left">
     
        <?php if (empty($micrositio) ) :?>   
         <?=$this->element("inicio/menu_inicial")?>
        <?php else:?>
          <?=$this->element("inicio/menu_sitio")?>
        <?php  endif;?>
      </ul>
    </div>

  
  </div>
</div>


