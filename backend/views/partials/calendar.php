<?php

$days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
$hours = ['8-9', '9-10', '10-11', '11-12', '12-13', '15-16', '16-17', '17-18'];

?>

<section class="container-calendar">
    <header>
        <p>Llena los cupos por día y por horario para el <?= $plugin_tabs[$current_tab] ?></p>
    </header>
    <table class="tbl-calendar" cellspacing="0" cellpadding="0">
    <thead>
        <tr>
            <th></th>
            <?php
                foreach($days as $day){
                    echo "<th>".$day."</th>";
                }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php for ($i=0; $i < count($hours); $i++): ?>
        <tr>
            <td><?= $hours[$i] ?></td>
            <?php for ($j=0; $j < count($days) ; $j++): ?>
                    <td><input type='number' min="0" max="1000" /></td>
            <?php endfor; ?>
        </tr>
        <?php endfor ?>
    </tbody>
    </table>

    <footer class="fotter-calendar">
        <a class="btn-add button button-primary">Grabar</a>
    </footer>
</section>