<table class="table table-condensed table-striped table-bordered">
  <thead>
    <tr>
      <th>Clave
        <?php 
          $icon_order = $this->Html->tag('i', '', array('class' => 'icon-retweet'));
          echo $this->Paginator->sort('cia_cve', $icon_order, array('escape' => false));
        ?>
      </th>
      <th>Nombre
        <?php echo $this->Paginator->sort('cia_nom', $icon_order, array('escape' => false)); ?>
      </th>
      <th>RFC</th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach ($empresas as $empresa):
        $emp = $empresa['Empresa'];
    ?>
    <tr>
      <td>
        <?php
          echo $this->Html->link($emp['cia_cve'], array('admin' => 1, 'action' => 'ver', $emp['cia_cve']), array());
        ?>
      </td>
      <td>
        <?php
          echo $this->Html->link($emp['cia_nom'], array('admin' => 1, 'action' => '/', $emp['cia_cve']), array());
        ?>
      </td>
      <td><?php echo $emp['cia_rfc']; ?></td>
    </tr>
    <?php
      endforeach;
    ?>
  </tbody>
</table>
<?php echo $this->Paginator->numbers(); ?>