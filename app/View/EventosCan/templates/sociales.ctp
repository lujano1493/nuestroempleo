<?php
  //  $label= oferta 
  //  {{=it.link}} $Oferta['oferta_link']
  //  "{{=it.title}}"=$OFerta['puesto_nom']
?>
  <span class="pennant">
          Comparte {{=it.label}} con un amigo a través de las Redes Sociales.
        <span >
          <a  href="{{=it.link}}" target="_blank"> {{=it.link}} </a>

          <div  style="margin-top:20px" >
                <p class="social_vacantes center box" >
                  <?=$this->Html->link("","{{=it.link}}",array(
                      'data-network-social' => 'facebook',
                      'data-text' => "{{=it.title}}",
                      'class' => 'facebook'
                    ) )?>


                    <?=$this->Html->link("","{{=it.link}}",array(
                      'data-network-social' => 'twitter',
                      'data-text' => "{{=it.title}}",
                      'class' => 'twitter'

                      ) )?>

                    <?=$this->Html->link("","{{=it.link}}",array(
                      'data-network-social' => 'linkedin',
                      'data-text' => "{{=it.title}}",
                      'class' => 'linkedin'

                      ) )?>
                    <?=$this->Html->link("","{{=it.link}}",array(
                      'data-network-social' => 'googleplus',
                      'data-text' => "{{=it.title}}",
                      'class' => 'googleplus'

                      ) )?>
               
              </p>
          </div>


          <br>

        </span>
        <span class="pennant_bottom">
        </span>
      </span>
