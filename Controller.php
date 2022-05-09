<?php
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;

$__department = __DIR__ . '/Department.php';
require_once $__department;

$__employee = __DIR__ . '/Employee.php';
require_once $__employee;

$__tools = __DIR__ . '/tools.php';
require_once $__tools;


class EmployeeController
{
    private int $current_id = 0;

    private function validate_field(mixed $field, array $constraints): array
    {
        $validator = Validation::createValidator();
        $violations = [];
        $violations_in_salary = $validator->validate($field, $constraints);
        foreach ($violations_in_salary as $error_in_salary) {
            $violations[] = (string)$error_in_salary;
        }
        return $violations;
    }

    private function validate(Employee $employee): string
    {

        $violations = [];
        $violations = array_merge($violations, $this->validate_field($employee->getSalary(), [
            new GreaterThan(100),
            new NotBlank()
        ]));
        $violations = array_merge($violations, $this->validate_field($employee->getName(), [
            new Length(null, 2),
            new NotBlank()
        ]));
        $violations = array_merge($violations, $this->validate_field($employee->getDateStartWork(), [
            new GreaterThan(1000),
            new NotBlank()
        ]));
        $violations = array_merge($violations, $this->validate_field($employee->getId(), [
            new GreaterThan(-1),
            new NotBlank()
        ]));

        if (count($violations) > 0) {

            $violations_string = implode("<br>", $violations);
            return ($violations_string);
        }
        return
            '<html><body>Employee added. Id = ' . $employee->getId() . '. Name = ' . $employee->getName() . '. Salary = ' . $employee->getSalary() . '. Experience = ' . $employee->getExperienceTime() . ' years. </body></html>';

    }

    public function create(): string
    {
        $name = getIfSet("name", "Ivan");
        $salary = getIfSet("salary", 900);
        $date_start_work = getIfSet("date_start_work", 77777);

        $employee = new Employee($this->current_id, $name, $salary, $date_start_work);
        $response = $this->validate($employee);
        $this->current_id++;
        return $response;
    }
}

class DepartmentController
{

    public function makeDepartmentWithPeople(int $employee_count): Department
    {
        $name = getIfSet("name", "Default");
        $employees = array();

        for ($i = 0; $i < $employee_count; $i++) {
            $name = "Departament number " . (random_int(1, 2)*$i);
            $salary = ($i + 1) * random_int(200, 1900);
            $date_started_working = time();
            $employees[] = new Employee($i, $name, $salary, $date_started_working);
        }

        return new Department($name, ...$employees);
    }

    private function caseSameTotalSalaryDepartment(Department ...$departments): string
    {
        $max_employee_count = $departments[0]->getEmployeesCount();
        $max_departments = [$departments[0]];
        
        //find max
        for ($i = 1; $i < count($departments); $i++) {
            $department = $departments[$i];
            $employee_count = $department->getEmployeesCount();
            if ($employee_count > $max_employee_count) {
                $max_employee_count = $employee_count;
                $max_departments = [$department];
            } else if ($employee_count == $max_employee_count) {
                $max_departments[] = $department;
            }
        }

        //make response
        $response = "";
        foreach ($max_departments as $department) {
            $response = $response . $department . " <br>\n";
        }
        return $response;
    }

    function findMinMaxDepartmentInArray(Department ...$departments): string
    {
        if (count($departments) < 1) {
            return "<html <body>No departments</body></html>";
        }
        $min_total_salary = $departments[0]->getTotalSalary();
        $min_departments = [$departments[0]];
        $max_total_salary = $departments[0]->getTotalSalary();
        $max_departments = [$departments[0]];

        for ($i = 1; $i < count($departments); $i++) {
            $department = $departments[$i];
            $salary = $department->getTotalSalary();
            if ($salary < $min_total_salary) {
                $min_total_salary = $salary;
                $min_departments = [$department];
            } else if ($salary == $min_total_salary) {
                $min_departments[] = $department;
            }
            if ($salary > $max_total_salary) {
                $max_total_salary = $salary;
                $max_departments = [$department];
            } else
                if ($salary == $max_total_salary) {
                    $max_departments[] = $department;
                }
        }
        $responce = "\n<h3>Minimum</h1><br>\n";
        $count_min_departments = count($min_departments);
        if ($count_min_departments == 1) {
            $responce = $responce . "Total salary (minimum): " . $min_departments[0] . "<br>\n ";
        } else if ($count_min_departments > 1) {
            $responce = $responce . $this->caseSameTotalSalaryDepartment(...$min_departments);
        }

        $responce = $responce . "\n\n<h3>Maximum</h1><br>\n";
        $count_max_departments = count($max_departments);
        if (count($max_departments) == 1) {
            $responce = $responce . "Total salary (maximum): " . $max_departments[0] . " <br>\n ";
        } else if ($count_max_departments > 1) {
            $responce = $responce . $this->caseSameTotalSalaryDepartment(...$max_departments);
        }

        return "<html><body>" . $responce . "\n\n</body></html>";

    }

}