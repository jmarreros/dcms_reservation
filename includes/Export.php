<?php

namespace dcms\reservation\includes;

use dcms\reservation\includes\Database;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Class for the operations of plugin
class Export{

    public function __construct(){
        add_action('admin_post_process_export_new_users', [$this, 'process_export_new_users']);
        add_action('admin_post_process_export_change_seats', [$this, 'process_export_change_seats']);
    }

    // Export data new users
    public function process_export_new_users(){
        $db = new Database();

        $spreadsheet = new Spreadsheet();
        $writer = new Xlsx($spreadsheet);

        $sheet = $spreadsheet->getActiveSheet();

        // Headers
        $sheet->setCellValue('A1', 'Nombre');
        $sheet->setCellValue('B1', 'Apellido');
        $sheet->setCellValue('C1', 'DNI');
        $sheet->setCellValue('D1', 'Correo');
        $sheet->setCellValue('E1', 'Teléfono');
        $sheet->setCellValue('F1', 'Dia reserva');
        $sheet->setCellValue('G1', 'Hora reserva');
        $sheet->setCellValue('H1', 'Enviado');

        // Get data from table
        $val_start  = $_POST['date_start']??get_option('dcms_start_new-users');
        $val_end    = $_POST['date_end']??get_option('dcms_end_new-users');

        $data = $db->get_report_new_users($val_start, $val_end);

        $i = 2;
        foreach ($data as $row) {
            $sheet->setCellValue('A'.$i, $row->name);
            $sheet->setCellValue('B'.$i, $row->lastname);
            $sheet->setCellValue('C'.$i, $row->dni);
            $sheet->setCellValue('D'.$i, $row->email);
            $sheet->setCellValue('E'.$i, $row->phone);
            $sheet->setCellValue('F'.$i, $row->day);
            $sheet->setCellValue('G'.$i, $row->hour);
            $sheet->setCellValue('H'.$i, $row->date);
            $i++;
        }

        $filename = 'reporte_alta_abonados.xlsx';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='. $filename);
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }


    // Export data change seats
    public function process_export_change_seats(){
        $db = new Database();

        $spreadsheet = new Spreadsheet();
        $writer = new Xlsx($spreadsheet);

        $sheet = $spreadsheet->getActiveSheet();

        // Headers
        $sheet->setCellValue('A1', 'Nombre');
        $sheet->setCellValue('B1', 'Apellido');
        $sheet->setCellValue('C1', 'Identificación');
        $sheet->setCellValue('D1', 'Número');
        $sheet->setCellValue('E1', 'Email');
        $sheet->setCellValue('F1', 'Dia reserva');
        $sheet->setCellValue('G1', 'Hora reserva');
        $sheet->setCellValue('H1', 'Enviado');

        // Get data from table
        $val_start  = $_POST['date_start']??get_option('dcms_start_new-users');
        $val_end    = $_POST['date_end']??get_option('dcms_end_new-users');

        $data = $db->get_report_change_seats($val_start, $val_end);

        $i = 2;
        foreach ($data as $row) {
            $sheet->setCellValue('A'.$i, $row->name);
            $sheet->setCellValue('B'.$i, $row->lastname);
            $sheet->setCellValue('C'.$i, $row->identify);
            $sheet->setCellValue('D'.$i, $row->number);
            $sheet->setCellValue('E'.$i, $row->email);
            $sheet->setCellValue('F'.$i, $row->day);
            $sheet->setCellValue('G'.$i, $row->hour);
            $sheet->setCellValue('H'.$i, $row->date);
            $i++;
        }

        $filename = 'reporte_alta_abonados.xlsx';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='. $filename);
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

}