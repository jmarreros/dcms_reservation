<?php

namespace dcms\reservation\includes;

class Database{
    private $wpdb;
    private $table_config;
    private $table_new_user;
    private $table_change_seats;
    private $view_users;

    public function __construct(){
        global $wpdb;

        $this->wpdb = $wpdb;
        $this->table_config   = $this->wpdb->prefix.'dcms_reservation_config';
        $this->table_new_user = $this->wpdb->prefix.'dcms_reservation_new_user';
        $this->table_change_seats = $this->wpdb->prefix.'dcms_reservation_change_seats';
        $this->view_users = $this->wpdb->prefix.'dcms_view_users';
    }

    // Calendar configuration backend methods
    // ----------------------------------------------------------------

    // Get all data
    public function get_calendar_config($type){
        $sql= "SELECT id, qty FROM {$this->table_config} WHERE `type`='{$type}';";

        return $this->wpdb->get_results( $sql , OBJECT_K);
    }

    // Save calendar config, insert or update
    public function save_config_calendar($id, $day, $hour, $qty, $order, $type){
        $sql = "INSERT INTO {$this->table_config} (`id`, `day`, `range`, `qty`, `order`, `type`)
                VALUES('{$id}', '{$day}', '{$hour}', '{$qty}', '{$order}', '{$type}')
            ON DUPLICATE KEY UPDATE `qty` = $qty, `order` = $order";

        return $this->wpdb->query($sql);
    }

    // Init activation create table
    public function create_table_config(){
        $sql = " CREATE TABLE IF NOT EXISTS {$this->table_config} (
                    `id` varchar(100),
                    `day` varchar(50) DEFAULT NULL,
                    `range` varchar(50) DEFAULT NULL,
                    `qty` smallint DEFAULT 0,
                    `type` varchar(50) DEFAULT NULL,
                    `order` smallint DEFAULT 0,
                    PRIMARY KEY (`id`)
            )";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }


    // get dates between current range
    public function get_available_days($type){
        $sql = "SELECT DISTINCT `day` FROM wp_dcms_reservation_config
                WHERE `type`='{$type}' and qty > 0";
        $result = $this->wpdb->get_results( $sql );

        error_log(print_r($result,true));

        $res = [];
        foreach ($result as $item){
            $res[] = $item->day;
        }

        return $res;
    }

    // New users
    // ----------------------------------------------------------------

    // Init activation create table new user
    public function create_table_new_user(){
        $sql = " CREATE TABLE IF NOT EXISTS {$this->table_new_user} (
                    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                    `name` varchar(250) DEFAULT NULL,
                    `lastname` varchar(250) DEFAULT NULL,
                    `dni` varchar(50) DEFAULT NULL,
                    `email` varchar(100) DEFAULT NULL,
                    `phone` varchar(50) DEFAULT NULL,
                    `day` datetime DEFAULT NULL,
                    `hour` char(20) DEFAULT NULL,
                    `deleted` boolean DEFAULT FALSE,
                    `date` datetime DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
            )";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }


    // Save new user reservation
    public function save_reservation_new_user($values){
        return $this->wpdb->insert($this->table_new_user, $values);
    }

    // Get diff cupos specific day - new users
    public function get_available_hours_new_user($date, $day_name){
        $sql = "SELECT rc.`range`, ( rc.`qty` - IFNULL(nu.`qty`,0) ) diff
                FROM {$this->table_config}  rc
                LEFT JOIN (SELECT `hour`, count(`hour`) qty FROM {$this->table_new_user}
                            WHERE `day` = '{$date}' AND deleted = 0
                            GROUP BY `hour`) nu
                ON nu.hour = rc.range
                WHERE rc.`type`='new-users' AND rc.`day` = '{$day_name}' AND rc.qty > 0
                ORDER BY rc.`order`";

        return $this->wpdb->get_results( $sql );
    }

    // report new users
    public function get_report_new_users($start, $end){
        $sql = "SELECT `id`,`name`,`lastname`,`dni`,`email`,`phone`, DATE_FORMAT(`day`,'%Y-%m-%d') `day`,`hour`, `date`
                FROM {$this->table_new_user}
                WHERE deleted = 0 AND `day` BETWEEN '{$start}' AND '{$end}'
                ORDER BY STR_TO_DATE( CONCAT(DATE_FORMAT(`day`,'%Y-%m-%d'), `hour`), '%Y-%m-%d %H:%i') DESC";

        return $this->wpdb->get_results( $sql );
    }

    // update state deleted table
    public function deleted_new_user($id){
        $data = ['deleted' => true];
        $where = ['id' => $id];
        return $this->wpdb->update($this->table_new_user, $data, $where);
    }


    // Change Seats
    // ----------------------------------------------------------------

    // Init activation create table new user
    public function create_table_change_seats(){
        $sql = " CREATE TABLE IF NOT EXISTS {$this->table_change_seats} (
                    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                    `user_id` bigint(20) unsigned NOT NULL,
                    `day` datetime DEFAULT NULL,
                    `hour` char(20) DEFAULT NULL,
                    `deleted` boolean DEFAULT FALSE,
                    `date` datetime DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
            )";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }


    // Save change seats reservation
    public function save_reservation_change_seats($values){
        return $this->wpdb->insert($this->table_change_seats, $values);
    }

    // Get diff cupos for a day - change seats
    public function get_available_hours_change_seats($date, $day_name){
        $sql = "SELECT rc.`range`, ( rc.`qty` - IFNULL(cs.`qty`,0) ) diff
                FROM {$this->table_config}  rc
                LEFT JOIN (SELECT `hour`, count(`hour`) qty FROM {$this->table_change_seats}
                            WHERE `day` = '{$date}' AND deleted = 0
                            GROUP BY `hour`) cs
                ON cs.hour = rc.range
                WHERE rc.`type`='change-seats' AND rc.`day` = '{$day_name}' AND rc.qty > 0
                ORDER BY rc.`order`";

        return $this->wpdb->get_results( $sql );
    }

     // report change seats
     public function get_report_change_seats($start, $end){

        $sql = "SELECT cs.`id`, vu.`name`, vu.`lastname`, vu.`identify`, vu.`number`, vu.`email`, DATE_FORMAT(cs.`day`,'%Y-%m-%d') `day`,cs.`hour`, cs.`date`
                FROM {$this->table_change_seats} cs
                INNER JOIN {$this->view_users} vu ON cs.user_id = vu.user_id
                WHERE cs.`deleted` = 0 AND cs.`day` BETWEEN '{$start}' AND '{$end}'
                ORDER BY STR_TO_DATE( CONCAT(DATE_FORMAT(cs.`day`,'%Y-%m-%d'), cs.`hour`), '%Y-%m-%d %H:%i') DESC";

        return $this->wpdb->get_results( $sql );
    }

    // update state deleted table
    public function deleted_change_seats($id){
        $data = ['deleted' => true];
        $where = ['id' => $id];
        return $this->wpdb->update($this->table_change_seats, $data, $where);
    }

}
