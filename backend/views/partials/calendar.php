<?php
// $data
// $current_tab
// $plugin_tabs

$days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
$hours = ['8-9', '9-10', '10-11', '11-12', '12-13', '15-16', '16-17', '17-18'];

?>

<section class="container-calendar">
    <header>
        <p>Llena los cupos por día y por horario para el <?= $plugin_tabs[$current_tab] ?></p>
    </header>
    <table id="tbl-calendar" class="tbl-calendar" cellspacing="0" cellpadding="0">
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
                    <td>
                        <?php $id = md5($days[$j].$hours[$i].$current_tab) ?>
                        <input
                            data-day="<?= $days[$j] ?>"
                            data-hour="<?= $hours[$i] ?>"
                            type='number'
                            min="0"
                            max="1000"
                            value=<?= $data[$id]->qty??0 ?>
                        />
                    </td>
            <?php endfor; ?>
        </tr>
        <?php endfor ?>
    </tbody>
    </table>

    <footer class="fotter-calendar">
        <button type="button" id="save_res_config" class="btn-add button button-primary">Grabar
            <div class="lds-ring" style="display:none" ><div></div><div></div><div></div><div></div></div>
        </button>
    </footer>
</section>