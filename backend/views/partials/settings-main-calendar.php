<?php
// $data
// $current_tab
// $plugin_tabs
// $days
// $hours
?>

<section class="container-calendar">
    <header>

        <section class="date-range <?= $current_tab ?>">
            <?php
                $val_start  = get_option('dcms_start_'.$current_tab);
                $val_end    = get_option('dcms_end_'.$current_tab);
            ?>

            Desde: <input type="date" id="date_start"  value="<?= $val_start ?>" />
            Hasta: <input type="date" id="date_end" value="<?= $val_end ?>" />
        </section>

        <p>Llena los cupos por día y por horario para el <?= $plugin_tabs[$current_tab] ?></p>

    </header>
    <table id="tbl-calendar" class="tbl-calendar" cellspacing="0" cellpadding="0">
    <thead>
        <tr>
            <th></th>
            <?php
                foreach($days as $day){
                    echo "<th>".ucfirst($day)."</th>";
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
                            data-order="<?= $i ?>"
                            type='number'
                            min="0"
                            max="1000"
                            value=<?= $data[$id]->qty>0?$data[$id]->qty:'' ?>
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

    <section class="cmessage">
    </section>


    <section class="exclude-dates">
        <h3>Excluir Fechas</h3>
        <p>Ingresa una lista de fechas a excluir, en el formato yyyy-mm-dd (año-mes-día), por cada línea, ejemplo: 2021-07-02 </p>
        <form method="post" id="frm-exclude" class="frm-exclude" action="<?php echo admin_url( 'admin-post.php' ) ?>" >
            <?php
                $dates_db = [];
                switch ( $current_tab ){
                    case 'new-users':
                        $dates_db = get_option(DCMS_EXCLUDE_NEW_USERS);
                        break;
                    case 'change-seats':
                        $dates_db = get_option(DCMS_EXCLUDE_CHANGE_SEAT);
                        break;
                }
            ?>
            <textarea name="dates"><?= implode(PHP_EOL, $dates_db) ?></textarea>
            <input type="hidden" name="type" value="<?= $current_tab ?>">
            <input type="hidden" name="action" value="process_exclude_dates">
            <button type="submit" class="btn-exclude button button-primary"><?php _e('Grabar', 'dcms-report') ?></button>
        </form>
    </section>

</section>