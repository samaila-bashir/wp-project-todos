<?php

if (!class_exists('AddTodo')) {

    class AddTodo
    {
        public function __construct()
        {
            $this->setup_actions();
        }

        /**
         * Setting up Actions
         */
        public function setup_actions()
        {
            add_action("admin_menu", array($this, "initForm"));
        }

        public function renderForm()
        {
            global $wpdb;

            if (isset($_POST['add_todo'])) {

                $title = $_POST['td_title'];
                $description = $_POST['td_description'];
                $tablename = $wpdb->prefix . "project_todos";

                if ($title != '' && $description != '') {
                    $insert_sql = "INSERT INTO " . $tablename . "(title,description) values('" . $title . "','" . $description . "') ";

                    $wpdb->query($insert_sql);

                    echo "Project todo added sucessfully.";
                }
            }
?>

            <h1>Add New Project Todo</h1>
            <form method='post' action=''>
                <table>
                    <tr>
                        <td>Todo Title</td>
                        <td><input type='text' name='td_title'></td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td><textarea name='td_description'></textarea></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type='submit' name='add_todo' value='Submit'></td>
                    </tr>
                </table>
            </form>

<?php
        }

        public function initForm()
        {
            add_submenu_page("wpprojecttodos", "Add Project Todo", "Add Project Todo", "manage_options", "addprojecttodo", array($this, "renderForm"));
        }
    }
}

?>