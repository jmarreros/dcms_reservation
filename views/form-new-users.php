<section>

    <form id="frm-new-users" class="frm-new-users">

        <h3>¿Nuevo Abonado?</h3>
        <p>Reserva una cita</p>

        <label for="name">Nombre<span>*</span></label>
        <input type="text" id="name" name="name" value="" maxlength="250" tabindex="1" required>

        <label for="lastname">Apellidos<span>*</span></label>
        <input type="text" id="lastname" name="lastname" value="" maxlength="250" tabindex="2" required>

        <label for="dni">DNI<span>*</span></label>
        <input type="text" id="dni" name="dni" value="" maxlength="20" tabindex="3" required>

        <label for="email">Correo<span>*</span></label>
        <input type="email" id="email" name="email" value="" maxlength="100" tabindex="4" placeholder ="@" required>

        <label for="phone">Teléfono</label>
        <input type="text" id="phone" name="phone" value="" maxlength="50" tabindex="5">

        <label class="lbl-calendar"><span class="dashicons dashicons-calendar-alt"></span> Selecciona una fecha y hora<span>*</span></label>
        <!-- Calendar -->
        <section  class="cal-container">
            <div id="cal-new-user" class="cal-calendar"></div>
            <div class="cal-sel-date">
                <?php include_once 'templates/hours-calendar.php'; ?>
            </div>
        </section>
        <!-- end calendar -->

        <div class="container-policy">
            <input type="checkbox" id="policy" name="policy" tabindex="6" required> <label for="policy">Aceptar los <a href="/politica-de-privacidad-del-club/">Términos y Condiciones</a></label>
        </div>

        <section class="message" style="display:none;">
        </section>

        <input type="submit" class="button" id="send" name="send" value="Enviar" tabindex="7" />
        <!--spinner-->
        <div class="lds-ring" style="display:none;"><div></div><div></div><div></div><div></div></div>

    </form>

</section>