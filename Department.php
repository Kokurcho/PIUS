<?php
class Department
{
    private string $department_name;
    private $employees_array;

    public function __construct(string $department_name, Employee ...$employees_array)
    {
        $this->department_name = $department_name;
        $this->employees_array = $employees_array; 
    }

    //setters
    public function setDepartmentName($department_name)
    {
        $this->department_name = $department_name;
    }

    //getters

    public function getDepartmentName(): string
    {
        return $this->department_name;
    }

    public function getEmployeesCount(): int 
    {
        return count($this->employees_array);
    }

    public function getTotalSalary(): int
    {
        $result = 0;
        foreach ($this->employees_array as $employee) {
            $result += $employee->getSalary();
        }
        return $result;
    }

    public function __toString(): string
    {
        return $this->department_name . " has " . $this->getEmployeesCount() . " employees and summary salary " . $this->getTotalSalary();
    }
}