<?php
  //  $label= oferta 
  //  $link= $Oferta['oferta_link']
  //  $title=$OFerta['puesto_nom']
?>
  <span class="pennant">
          Comparte <?=$label?> con un amigo a través de las Redes Sociales.
        <span >
          <a  href="<?=$link?>" target="_blank"> <?=$link ?></a>

          <div  style="margin-top:20px" >
                <p class="social_vacantes center box" >
                  <?=$this->Html->link(" ",$link,array(
                      'data-network-social' => 'facebook',
                      'data-text' => $title,
                      'class' => 'facebook'
                    ) )?>


                    <?=$this->Html->link(" ",$link,array(
                      'data-network-social' => 'twitter',
                      'data-text' => $title,
                      'class' => 'twitter'

                      ) )?>

                    <?=$this->Html->link(" ",$link,array(
                      'data-network-social' => 'linkedin',
                      'data-text' => $title,
                      'class' => 'linkedin'

                      ) )?>
                    <?=$this->Html->link(" ",$link,array(
                      'data-network-social' => 'googleplus',
                      'data-text' => $title,
                      'class' => 'googleplus'

                      ) )?>
               
              </p>
          </div>


          <br>

        </span>
        <span class="pennant_bottom">
        </span>
      </span>
