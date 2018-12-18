<?php
$templateCustomer = 'signup_controller';

switch ($_GET['action'] ?? null){

    case 'newCostumer':

        if (isset($_POST['newCostumer'])) {
            $sql = "INSERT INTO user (email, password, address, phone, name, lastname, role) VALUES (:email, :password, :adress, :phone, :name, :lastname, :role)";


            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':name', ucfirst(strtolower(filter_var($_POST['newCostumer']['name'], FILTER_SANITIZE_STRING))));
            $stmt->bindParam(':lastname', ucfirst(strtolower(filter_var($_POST['newCostumer']['lastname'], FILTER_SANITIZE_STRING))));
            $stmt->bindParam(':phone', trim($_POST['newCostumer']['phone']));
            $stmt->bindParam(':email', strtolower(filter_var($_POST['newCostumer']['email'], FILTER_SANITIZE_STRING)));
            $stmt->bindParam(':password', password_hash($_POST['newCostumer']['password'], PASSWORD_DEFAULT));
            $stmt->bindParam(':adress', ucfirst(strtolower(filter_var($_POST['newCostumer']['address'], FILTER_SANITIZE_STRING))));
            $stmt->bindValue(':role', 2);
            $stmt->execute();

            header("Location: ?controller=login");
        }
        break;
}

loadCustomerTemplate('signup', $templateCustomer);