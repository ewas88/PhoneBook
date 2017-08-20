<?php
require 'src/Connection.php';
require 'header.php';

$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if (null == $id) {
    header("Location: index.php");
}

if (!empty($_POST)) {
    $nameError = null;
    $surnameError = null;
    $cellError = null;
    $homeError = null;
    $businessError = null;

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $cell = $_POST['cell'];
    $home = $_POST['home'];
    $business = $_POST['business'];

    $valid = true;
    if (empty($name)) {
        $nameError = 'Proszę wprowadzić imię';
        $valid = false;
    }

    if (empty($surname)) {
        $surnameError = 'Proszę wprowadzić nazwisko';
        $valid = false;
    }

    if (!empty($cell)) {
        if (!preg_match('~^[+]?([0-9]+[-]?[ ]?[0-9]+)+$~', $cell)) {
            $cellError = 'Proszę wprowadzić poprawny numer składający się z cyfr, spacji lub/i myślników';
            $valid = false;
        } elseif (strlen(trim($cell, '+')) < 9) {
            $cellError = 'Proszę wprowadzić poprawny numer składający się z co najmniej 9 cyfr';
            $valid = false;
        }
    }

    if (!empty($home)) {
        if (!preg_match('~^[+]?([0-9]+[-]?[ ]?[0-9]+)+$~', $home)) {
            $homeError = 'Proszę wprowadzić poprawny numer składający się z cyfr, spacji lub/i myślników';
            $valid = false;
        } elseif (strlen(trim($home, '+')) < 7) {
            $homeError = 'Proszę wprowadzić poprawny numer składający się z co najmniej 7 cyfr';
            $valid = false;
        }
    }

    if (!empty($business)) {
        if (!preg_match('~^[+]?([0-9]+[-]?[ ]?[0-9]+)+$~', $business)) {
            $businessError = 'Proszę wprowadzić poprawny numer składający się z cyfr, spacji lub/i myślników';
            $valid = false;
        } elseif (strlen(trim($business, '+')) < 7) {
            $businessError = 'Proszę wprowadzić poprawny numer składający się z co najmniej 7 cyfr';
            $valid = false;
        }
    }

    if ($valid) {
        $pdo = Database::connect($dbName, $dbHost, $dbUsername, $dbUserPassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE `person` SET `name` = ?, surname = ?, cell_number = ?, home_number = ?, business_number = ? WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($name, $surname, $cell, $home, $business, $id));
        Database::disconnect();
        header("Location: index.php");
    }
} else {
    $pdo = Database::connect($dbName, $dbHost, $dbUsername, $dbUserPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM `person` where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    if (!$data) {
        header("Location: index.php");
    }
    $name = $data['name'];
    $surname = $data['surname'];
    $cell = $data['cell_number'];
    $home = $data['home_number'];
    $business = $data['business_number'];
    Database::disconnect();
}
?>

<div class="container">
    <div class="span10 offset1">
        <form class="form-horizontal" action="update.php?id=<?php echo $id ?>" method="post">
            <div class="control-group <?php echo !empty($nameError) ? 'error' : ''; ?>">
                <label class="control-label">Imię</label>
                <div class="controls">
                    <input class="font" name="name" type="text" value="<?php echo !empty($name) ? $name : ''; ?>">
                    <?php if (!empty($nameError)): ?>
                        <span class="help-inline"><?php echo $nameError; ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="control-group <?php echo !empty($surnameError) ? 'error' : ''; ?>">
                <label class="control-label">Nazwisko</label>
                <div class="controls">
                    <input name="surname" type="text" value="<?php echo !empty($surname) ? $surname : ''; ?>">
                    <?php if (!empty($surnameError)): ?>
                        <span class="help-inline"><?php echo $surnameError; ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="control-group <?php echo !empty($cellError) ? 'error' : ''; ?>">
                <label class="control-label">Numer komórkowy</label>
                <div class="controls">
                    <input name="cell" type="text" value="<?php echo !empty($cell) ? $cell : ''; ?>">
                    <?php if (!empty($cellError)): ?>
                        <span class="help-inline"><?php echo $cellError; ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="control-group <?php echo !empty($homeError) ? 'error' : ''; ?>">
                <label class="control-label">Numer domowy</label>
                <div class="controls">
                    <input name="home" type="text" value="<?php echo !empty($home) ? $home : ''; ?>">
                    <?php if (!empty($homeError)): ?>
                        <span class="help-inline"><?php echo $homeError; ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="control-group <?php echo !empty($businessError) ? 'error' : ''; ?>">
                <label class="control-label">Numer służbowy</label>
                <div class="controls">
                    <input name="business" type="text" value="<?php echo !empty($business) ? $business : ''; ?>">
                    <?php if (!empty($businessError)): ?>
                        <span class="help-inline"><?php echo $businessError; ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-success">Edytuj</button>
                <a class="btn btn-primary" href="index.php">Powrót</a>
            </div>
        </form>
    </div>
</div>