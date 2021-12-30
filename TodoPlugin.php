<?php
/*
   Plugin Name: WP Project Todos
   description: A plugin for writing todo items for your Wordpress project.
   Version: 1.0.0
   Author: Samaila Chatto Bashir
   Author URI: https://www.samailabashir.com
*/

include "AddTodo.php";
include "AllProjectTodos.php";

if (!class_exists('TodoPlugin')) {

    class TodoPlugin
    {
        public $add_todo_form;
        public $list_todo_data;

        public function __construct()
        {
            $this->setup_actions();

            $this->add_todo_form = new AddTodo();
            $this->list_todo_data = new AllProjectTodos();
        }

        /**
         * Setting up Actions
         */
        public function setup_actions()
        {
            add_action("admin_menu", array($this, "wp_project_todos_menu"));
        }

        /**
         * Create a new table for plugin
         */
        public function wp_project_todos_table()
        {
            global $wpdb;

            $charset_collate = $wpdb->get_charset_collate();

            $table_name = $wpdb->prefix . "project_todos";

            $sql = "CREATE TABLE $table_name (
                id mediumint(11) NOT NULL AUTO_INCREMENT,
                title varchar(80) NOT NULL,
                description text NOT NULL,
                PRIMARY KEY  (id)
            ) $charset_collate;";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }

        /**
         * Add Menu
         */
        public function wp_project_todos_menu()
        {
            add_menu_page("Project Todos", "Project Todos", "manage_options", "wpprojecttodos", array($this->list_todo_data, "renderData"), "dashicons-editor-ul");
        }
    }

    $todo_plugin = new TodoPlugin();

    register_activation_hook(__FILE__, array($todo_plugin, "wp_project_todos_table"));
}
