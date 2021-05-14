<html>
    <head>
        <title>Danh sách thành viên</title>
    </head>

    <body>
        <table width="600" border="1" cellspacing="5" cellpadding="5">
            <tr style="background:#CCC">
                <th>Role id</th>
                <th>Username</th>
                <th>Phone</th>
                <th>Email</th>
            </tr>
            <?php
            foreach ($account as $row) {
                echo "<tr>";
                echo "<td>" . $row->role_id . "</td>";
                echo "<td>" . $row->full_name . "</td>";
                echo "<td>" . $row->pwd . "</td>";
                echo "<td>" . $row->user_name . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
