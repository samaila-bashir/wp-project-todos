<?php

if (!class_exists('AllProjectTodos')) {

    class AllProjectTodos
    {
        public function renderData()
        {
            global $wpdb;
            $tablename = $wpdb->prefix . "project_todos";

            if (isset($_GET['delete'])) {
                $delete = $_GET['delete'];
                $wpdb->query("DELETE FROM " . $tablename . " WHERE id=" . $delete);
            }

?>
            <h1>All Entries</h1>

            <table width='100%' border='1' style='border-collapse: collapse;'>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
                <?php
                // Select records
                $projectTodos = $wpdb->get_results("SELECT * FROM " . $tablename . " order by id desc");
                if (count($projectTodos) > 0) {
                    $count = 1;
                    foreach ($projectTodos as $todo) {
                        $id = $todo->id;
                        $title = $todo->title;
                        $description = $todo->description;

                        echo "<tr>
                            <td>" . $count . "</td>
                            <td>" . $title . "</td>
                            <td>" . $description . "</td>
                            <td><a href='?page=wpprojecttodos&delete=" . $id . "'>Delete</a></td>
                            </tr>
                        ";
                        $count++;
                    }
                } else {
                    echo "<tr><td colspan='5'>No record found</td></tr>";
                }
                ?>
            </table>
<?php

        }
    }
}

?>