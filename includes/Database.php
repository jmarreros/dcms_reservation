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

    // Init activation create table
    public function create_table(){
        $sql = " CREATE TABLE IF NOT EXISTS {$this->table_name} (
                    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                    `day` varchar(50) DEFAULT NULL,
                    `range` varchar(50) DEFAULT NULL,
                    `type` varchar(50) DEFAULT NULL,
                    PRIMARY KEY (`id`)
            )";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

}
