<?php

namespace dcms\reservation\includes;

class Database{
    private $wpdb;
    private $table_name;

    public function __construct(){
        global $wpdb;

        $this->wpdb = $wpdb;
        $this->table_name   = $this->wpdb->prefix.'dcms_reservation_config';
    }

    // Calendar configuration backend methods

    // Get all data
    public function get_calendar_config($type){
        $sql= "SELECT id, qty FROM {$this->table_name} WHERE `type`='{$type}';";

        return $this->wpdb->get_results( $sql , OBJECT_K);
    }

    // Save calendar config, insert or update
    public function save_config_calendar($id, $day, $hour, $qty, $type){
        $sql = "INSERT INTO {$this->table_name} (`id`, `day`, `range`, `qty`, `type`)
                VALUES('{$id}', '{$day}', '{$hour}', $qty, '$type')
            ON DUPLICATE KEY UPDATE qty = $qty";

        return $this->wpdb->query($sql);
    }

    // Init activation create table
    public function create_table(){
        $sql = " CREATE TABLE IF NOT EXISTS {$this->table_name} (
                    `id` varchar(100),
                    `day` varchar(50) DEFAULT NULL,
                    `range` varchar(50) DEFAULT NULL,
                    `qty` smallint unsigned DEFAULT 0,
                    `type` varchar(50) DEFAULT NULL,
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

        $res = [];
        foreach ($result as $item){
            $res[] = $item->day;
        }

        return $res;
    }

}
