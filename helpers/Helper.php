<?php

namespace dcms\reservation\helpers;

final class Helper{

    // Search in array of objects
    public static function get_days(){
        $days = ['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo'];
        return $days;
    }

    // object meta to array meta
    public static function get_hours(){
        $hours = ['9:00', '9:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30'];
        return $hours;
    }
}
