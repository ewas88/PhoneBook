<?php
require 'src/Connection.php';
require 'header.php';

$id = 0;

if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
    $pdo = Database::connect($dbName, $dbHost, $dbUsername, $dbUserPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM `person` where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    if (!$data) {
        header("Location: index.php");
    } else {
        $name = $data['name'];
        $surname = $data['surname'];
        Database::disconnect();
    }
}

if (!empty($_POST)) {
    $id = $_POST['id'];

    $pdo = Database::connect($dbName, $dbHost, $dbUsername, $dbUserPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM `person` WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    Database::disconnect();
    header("Location: index.php");

}
?>

<div class="container">
    <div class="span10 offset1">
        <form class="form-horizontal" action="delete.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
            <p class="alert alert-error">Czy na pewno chcesz usunąć kontakt <?php echo $name . " " . $surname; ?>?</p>
            <div class="form-actions">
                <button type="submit" class="btn btn-danger">Tak</button>
                <a class="btn" href="index.php">Nie</a>
            </div>
        </form>
    </div>
</div>
