<?php
include('header.php');
include 'src/Connection.php';
?>

<div class="container">
    <div class="row">
        <p>
            <a href="create.php" class="btn btn-success" style="font-size: xx-large;">Dodaj nowy kontakt</a>
        </p>

        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>IMIĘ</th>
                <th>NAZWISKO</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php

            $pdo = Database::connect($dbName, $dbHost, $dbUsername, $dbUserPassword);
            $sql = 'SELECT * FROM `person` ORDER BY `name` ASC';
            foreach ($pdo->query($sql) as $row) {
                echo '<tr>';
                echo '<td>' . $row['name'] . '</td>';
                echo '<td>' . $row['surname'] . '</td>';
                echo '<td width=250>';
                echo '<a class="btn btn-info" href="read.php?id=' . $row['id'] . '">Szczegóły</a>';
                echo ' ';
                echo '<a class="btn btn-warning" href="update.php?id=' . $row['id'] . '">Edytuj</a>';
                echo ' ';
                echo '<a class="btn btn-danger" href="delete.php?id=' . $row['id'] . '">Usuń</a>';
                echo '</td>';
                echo '</tr>';
            }
            Database::disconnect();
            ?>
            </tbody>
        </table>
    </div>
</div>