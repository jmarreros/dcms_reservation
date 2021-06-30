<?php
    //$report;
?>
<section class="container-report">

    <header>

        <section class="date-range <?= $current_tab ?>">
            <?php
                $val_start  = get_option('dcms_start_new-users');
                $val_end    = get_option('dcms_end_new-users');
            ?>

            Desde: <input type="date" id="date_start"  value="<?= $val_start ?>" />
            Hasta: <input type="date" id="date_end" value="<?= $val_end ?>" />

            <button id="btn-search" type="button" class="btn-search button button-primary"><?php _e('Filtrar', 'dcms-report') ?></button>

        </section>


        <section class="buttons-export">
            <form method="post" id="frm-export" class="frm-export" action="<?php echo admin_url( 'admin-post.php' ) ?>" >
                <input type="hidden" name="date_start" value="<?= $val_start ?>">
                <input type="hidden" name="date_end" value="<?= $val_end ?>">
                <input type="hidden" name="action" value="process_export_new_users">
                <button type="submit" class="btn-export button button-primary"><?php _e('Exportar', 'dcms-report') ?></button>
            </form>
        </section>

    </header>

    <?php
        $fields = ['Nombre', 'Apellido', 'DNI', 'Email', 'Teléfono', 'Día reserva', 'Hora reserva'];
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
            <td><?= $row->dni ?></td>
            <td><?= $row->email ?></td>
            <td><?= $row->phone ?></td>
            <td><?= $row->day ?></td>
            <td><?= $row->hour ?></td>
        </tr>
    <?php endforeach; ?>
    </table>

</section>





