<?php

class Employee
{
    private int $id;

    private string $name;

    private int $salary;

    private int $date_start_work;

    public function __construct($id, $name, $salary, $date_started_working)
    {
        $this->id = $id;
        $this->name = $name;
        $this->salary = $salary;
        $this->date_start_work = $date_started_working;
    }

    //setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setSalary($salary)
    {
        $this->salary = $salary;
    }

    public function setDateStartWork($date_start_work)
    {
        $this->date_start_work = $date_start_work;
    }

    //getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSalary(): int
    {
        return $this->salary;
    }

    public function getDateStartWork(): int
    {
        return $this->date_start_work;
    }

    //custom function for lab
    public function getExperienceTime(): string
    {
        $year_now = date("Y");
        return $year_now - date("Y", $this->date_start_work);
    }

}