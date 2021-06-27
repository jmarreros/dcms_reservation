<?php
    //$report;
?>
<section class="container-report">

    <header>
        <span>Reservas recientes de abonados:</span>
        <form method="post" id="frm-export" class="frm-export" action="<?php echo admin_url( 'admin-post.php' ) ?>" >
            <input type="hidden" name="action" value="process_export_new_users">
            <button type="submit" class="btn-export button button-primary"><?php _e('Exportar todo', 'dcms-report') ?></button>
        </form>

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





