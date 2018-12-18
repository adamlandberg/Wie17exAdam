<?php

//funktion för att Inkludera templatefiler.

function loadAdminTemplate($templateName, $templateAdmin){
    require('templates/'.'adminfront.tpl.php');
    require('templates/'.$templateName.'.tpl.php');

}

function loadCustomerTemplate($templateName, $templateCustomer){
    require('templates/'.'header.tpl.php');
    require('templates/'.$templateName.'.tpl.php');
    require('templates/'.'footer.tpl.php');

}


function getCategories() {
    global $dbh;
    $sql = "SELECT * FROM categories";
    $stmt = $dbh->query($sql);
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $categories;
}
