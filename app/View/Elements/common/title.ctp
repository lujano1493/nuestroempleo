<header class="container-header">
  <h1>
    <?php echo isset($title) ? $title : $this->name; ?>
    <?php if (!empty($desc)): ?>
      <small><?php echo $desc; ?></small>
    <?php endif ?>
  </h1>
</header>