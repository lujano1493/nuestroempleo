<div class="row-fluid">
  <div class="span6">
    <?php
      echo $this->Html->image('publicidad/publicidad-horizontal.jpg', array(
        'class' => 'img-polaroid'
      ));
    ?>
    <?php if (empty($single)) { ?>
    <br><br>
    <?php
      echo $this->Html->image('publicidad/publicidad-horizontal.jpg', array(
        'class' => 'img-polaroid'
      ));
    ?>
    <?php } ?>
  </div>
  <?php if (empty($single)) { ?>
    <div class="span3 right pull-right" style="padding-top:10px;">
      <?php
        echo $this->Html->image('publicidad/publicidad-vertical.jpg', array(
          'class' => 'img-polaroid'
        ));
      ?>
    </div>
<?php } ?>
</div>