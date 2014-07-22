<div class="box form">
    <?php
        echo $this->Session->flash('auth', array(
            'params' => array('type' => 'warning'),
            'element' => 'common/alert'
        ));
    ?>
    <!--
    <?php echo $this->Form->create(false, array('class' => 'form-inline big')); ?>
        <fieldset>
            <legend>Datos de Sesi&oacute;n</legend>
            <?php
                echo $this->Form->input('UsuarioEmpresa.cuenta', array(
                    'icon' => 'user',
                    'placeholder' => 'Correo Electrónico'
                ));
                echo $this->Form->input('UsuarioEmpresa.password', array(
                    'icon' => 'key',
                    'placeholder' => 'Contraseña'
                ));
            ?>
        </fieldset>
        <div class="form-actions f-right">
            <div class="left">
                <?php echo $this->Session->flash(); ?>
            </div>
            <?php
                echo $this->Form->submit('Entrar', array( 'class' => 'btn btn-success btn-large', 'div' => false));
                echo $this->Html->link('Registrarme', '/empresas/registrar');
                echo $this->Html->link('Recuperar contraseña', '/recuperar_password');
            ?>
        </div>
    <?php echo $this->Form->end(); ?>
    -->
</div>