<?php
require 'src/Connection.php';
require 'header.php';

$id = null;
if ( !empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if ( null==$id ) {
    header("Location: index.php");
} else {
    $pdo = Database::connect($dbName,$dbHost,$dbUsername,$dbUserPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM `person` where id = $id";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    if (!$data) {
        header("Location: index.php");
    }
    Database::disconnect();
}
?>

<div class="container big-font">
    <div class="span10 offset1">
        <div class="form-horizontal" >
            <div class="control-group">
                <label class="control-label">Imię</label>
                <div class="controls">
                    <label class="checkbox">
                        <?php echo $data['name'];?>
                    </label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Nazwisko</label>
                <div class="controls">
                    <label class="checkbox">
                        <?php echo $data['surname'];?>
                    </label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Numer komórkowy</label>
                <div class="controls">
                    <label class="checkbox">
                        <?php echo !empty($data['cell_number'])?$data['cell_number']:'-';?>
                    </label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Numer domowy</label>
                <div class="controls">
                    <label class="checkbox">
                        <?php echo !empty($data['home_number'])?$data['home_number']:'-';?>
                    </label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Numer służbowy</label>
                <div class="controls">
                    <label class="checkbox">
                        <?php echo !empty($data['business_number'])?$data['business_number']:'-';?>
                    </label>
                </div>
            </div>
            <div class="form-actions">
                <a class="btn btn-warning" href="update.php?id= <?php echo $data['id'];?> ">Edycja danych</a>
                <a class="btn btn-primary" href="index.php">Powrót</a>
            </div>
        </div>
    </div>
</div>