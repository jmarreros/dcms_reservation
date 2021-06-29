<section>

    <form id="frm-change-seats" class="frm-change-seats">

        <h3>Cambiar Asientos</h3>
        <p>Reserva de cambio de asientos para abonado</p>

        <div class="control-container">
            <label for="name">Nombre<span>*</span></label>
            <input type="text" id="name" name="name" value="" maxlength="250" tabindex="1" required>

            <label class="lbl-calendar"><span class="dashicons dashicons-calendar-alt"></span> Selecciona una fecha y hora<span>*</span></label>
            <!-- Calendar -->
            <section  class="cal-container">
                <div id="cal-change-seats" class="cal-calendar"></div>
                <div class="cal-sel-date">
                    <?php include_once 'templates/hours-calendar.php'; ?>
                </div>
            </section>
            <!-- end calendar -->

            <div class="container-policy">
                <input type="checkbox" id="policy" name="policy" tabindex="6" required> <label for="policy">Aceptar los <a href="/politica-de-privacidad-del-club/">Términos y Condiciones</a></label>
            </div>
        </div>

        <section class="message" style="display:none;">
        </section>

        <input type="submit" class="button" id="send" name="send" value="Enviar" tabindex="7" />
        <!--spinner-->
        <div class="lds-ring" style="display:none;"><div></div><div></div><div></div><div></div></div>

    </form>

</section>