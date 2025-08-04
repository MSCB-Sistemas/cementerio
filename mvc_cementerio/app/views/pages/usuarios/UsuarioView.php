<html>
    <ul>
        <?php foreach ($datos as $usuario): ?>
            <li><?php echo ($usuario['id_usuario'] . "&nbsp&nbsp" . 
                            $usuario['usuario'] . "&nbsp&nbsp" . 
                            $usuario['nombre'] . "&nbsp&nbsp" . 
                            $usuario['apellido']);?>
            </li>
        <?php endforeach; ?>
    </ul>
</html>