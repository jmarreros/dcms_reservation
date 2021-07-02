<?php
    //$report;
?>
<section class="container-report">

    <header>

        <section class="date-range <?= $current_tab ?>">
            <form method="post" id="frm-search" class="frm-search" action="" >
                Desde: <input type="date" id="date_start" name="date_start"  value="<?= $val_start ?>" />
                Hasta: <input type="date" id="date_end" name="date_end" value="<?= $val_end ?>" />
                <button id="btn-search" type="submit" class="btn-search button button-primary"><?php _e('Filtrar', 'dcms-report') ?></button>            </form>
        </section>

        <section class="buttons-export">
            <form method="post" id="frm-export" class="frm-export" action="<?php echo admin_url( 'admin-post.php' ) ?>" >
                <input type="hidden" name="date_start" value="<?= $val_start ?>">
                <input type="hidden" name="date_end" value="<?= $val_end ?>">
                <input type="hidden" name="action" value="process_export_change_seats">
                <button type="submit" class="btn-export button button-primary"><?php _e('Exportar', 'dcms-report') ?></button>
            </form>
        </section>
    </header>


    <?php
        $fields = ['Nombre', 'Apellido', 'Identificación', 'Número', 'Email', 'Día reserva', 'Hora reserva', ''];
    ?>
    <table class="dcms-table">
        <tr>
            <?php
            foreach($fields as $field) {
                echo "<th>" . $field . "</th>";
            }
            ?>
        </tr>
    <?php foreach ($report as $row):  ?>
        <tr>
            <td><?= $row->name ?></td>
            <td><?= $row->lastname ?></td>
            <td><?= $row->identify ?></td>
            <td><?= $row->number ?></td>
            <td><?= $row->email ?></td>
            <td><?= $row->day ?></td>
            <td><?= $row->hour ?></td>
            <td><a class="delete" data-id="<?= $row->id ?>" data-name="<?= $row->name . ' ' . $row->lastname ?>" href="#">Eliminar</a></td>
        </tr>
    <?php endforeach; ?>
    </table>

</section>
