<section>

    <form id="frm-change-seats" class="frm-change-seats">

        <h3>Cambiar Asientos</h3>
        <p>
            <strong>Reservar cita para cambio de asientos de abonado</strong>,
            selecciona una fecha y hora,
            se te enviará un correo de confirmación.
        </p>

        <div class="control-container">
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
                <input type="checkbox" id="policy" name="policy" tabindex="6" required> <label for="policy">Aceptar los <a href="/politica-de-privacidad-del-club/" target="_blank">Términos y Condiciones</a></label>
            </div>
        </div>

        <section class="message" style="display:none;">
        </section>

        <input type="submit" class="button" id="send" name="send" value="Enviar" tabindex="7" />
        <!--spinner-->
        <div class="lds-ring" style="display:none;"><div></div><div></div><div></div><div></div></div>

    </form>

</section>