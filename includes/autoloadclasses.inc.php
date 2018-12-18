<?php
//Ladda class
function autoClasses($classname)
{

    // False om ej classfilen finns
    if (!is_file('classes/' . $classname . '_class.php')) {
        return false;
        
    }
    require_once 'classes/' . $classname . '_class.php';
}
