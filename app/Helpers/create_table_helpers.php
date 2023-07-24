<?php



namespace App\Helpers;



class CreateTableHelper

{

    // public static function create_table()

    // {

    //     $sql  = 'create table modules (id int NOT NULL AUTO_INCREMENT, name varchar(50), `view` int(1) DEFAULT 0, `add` int(1) DEFAULT 0, `edit` int(1) DEFAULT 0, `delete` int(1) DEFAULT 0, PRIMARY KEY (id), created_at datetime null, updated_at datetime null, deleted_at timestamp null);';

    //     $sql .= 'create table roles (id int NOT NULL AUTO_INCREMENT, name varchar(50),description text, PRIMARY KEY (id), created_at datetime null, updated_at datetime null, deleted_at timestamp null);';

    //     $sql .= 'create table subscriptions (id int NOT NULL AUTO_INCREMENT, title varchar(50), tenure_from datetime null, tenure_to datetime null, PRIMARY KEY (id), created_at datetime null, updated_at datetime null, deleted_at timestamp null);';

    //     $sql .= 'create table settings (id int NOT NULL AUTO_INCREMENT, `group` varchar(100), name varchar(100), locked tinyint(1), payload text, PRIMARY KEY (id), created_at datetime null, updated_at datetime null, deleted_at timestamp null, INDEX(`group`));';

    //     $sql .= 'create table users ( id int NOT NULL AUTO_INCREMENT, name varchar(100), email varchar(100), password varchar(255), status int(2) DEFAULT 1, role_id int(5), remember_token varchar(100), PRIMARY KEY (id), created_at datetime null, updated_at datetime null, deleted_at timestamp null);';

    //     $sql .= 'create table role_module_permissions (id int NOT NULL AUTO_INCREMENT, role_id int(5), module_id int(1), `view` int(1) DEFAULT 0, `add` int(1) DEFAULT 0, `edit` int(1) DEFAULT 0, `delete` int(1) DEFAULT 0, PRIMARY KEY (id), created_at datetime null, updated_at datetime null, deleted_at timestamp null);';

    //     return $sql;

    // }

    

    

     public static function create_table()

    {

        $sql  = 'create table modules (id int NOT NULL AUTO_INCREMENT, name varchar(50), `view` int(1) DEFAULT 0, `add` int(1) DEFAULT 0, `edit` int(1) DEFAULT 0, `delete` int(1) DEFAULT 0, PRIMARY KEY (id), created_at datetime null, updated_at datetime null, deleted_at timestamp null);';

        $sql .= 'create table roles (id int NOT NULL AUTO_INCREMENT, name varchar(50),description text, PRIMARY KEY (id), created_at datetime null, updated_at datetime null, deleted_at timestamp null);';

        $sql .= 'create table subscriptions (id int NOT NULL AUTO_INCREMENT, title varchar(50), tenure_from datetime null, tenure_to datetime null, PRIMARY KEY (id), created_at datetime null, updated_at datetime null, deleted_at timestamp null);';

        $sql .= 'create table settings (id int NOT NULL AUTO_INCREMENT, `group` varchar(100), name varchar(100), locked tinyint(1), payload text, PRIMARY KEY (id), created_at datetime null, updated_at datetime null, deleted_at timestamp null, INDEX(`group`));';

        $sql .= 'create table users ( id int NOT NULL AUTO_INCREMENT, first_name varchar(100), last_name varchar(100), email varchar(100), phone varchar(12), country varchar(20), state varchar(20), city varchar(20), password varchar(255), status int(2) DEFAULT 1, role_id int(5), remember_token varchar(100), PRIMARY KEY (id), created_at datetime null, updated_at datetime null, deleted_at timestamp null);';

        $sql .= 'create table role_module_permissions (id int NOT NULL AUTO_INCREMENT, role_id int(5), module_id int(1), `view` int(1) DEFAULT 0, `add` int(1) DEFAULT 0, `edit` int(1) DEFAULT 0, `delete` int(1) DEFAULT 0, PRIMARY KEY (id), created_at datetime null, updated_at datetime null, deleted_at timestamp null);';

        return $sql;

    }

}

