<p>Se ha contratado un nuevo paquete para tu empresa <?php echo $this->Session->read('Auth.User.Empresa.cia_nombre'); ?></p>
<p>Fecha: <?php echo $this->Time->format('d/m/Y,  g:i a', time()); ?></p>
<p>Costo: <?php echo $this->Number->currency($costo); ?></p>

<p>
  <span>Av. Nuevo Leon #202 Piso 5</span>
  <span>Col. Hipodormo Condesa</span>
  <span>Mexico, DF. CP. 06170</span>
  <span>T. 55840353 T. 55644006 </span>
</p>
<div><a href="www.nuestroempleo.com.mx">www.nuestroempleo.com.mx</a></div>