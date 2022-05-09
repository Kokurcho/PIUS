<?php
$__autoload = __DIR__ . '/vendor/autoload.php';
require_once $__autoload;

$__department_controller = __DIR__ . '/Controller.php';
require_once $__department_controller;

$__employee_controller = __DIR__ . '/Controller.php';
require_once $__employee_controller;

$__tools = __DIR__ . '/tools.php';
require_once $__tools;


$empl_controller = new EmployeeController();
print $empl_controller->create();
echo "<br/>";
print $empl_controller->create();
echo "<br/>";
print $empl_controller->create();
echo "<br/>";

function makeDepArray($employee_numbers)
{

    $employee_counts = explode(";", $employee_numbers);
    $departments = array();
    $dep_controller = new DepartmentController();

    foreach ($employee_counts as $employee_count) {
        $departments[] = $dep_controller->makeDepartmentWithPeople((int)$employee_count);
    }
    
    print $dep_controller->findMinMaxDepartmentInArray(...$departments);
}


$employee_numbers = getIfSet("counts", "45;40;39;43;44;47;41;50");
//echo $employee_numbers;
makeDepArray($employee_numbers);