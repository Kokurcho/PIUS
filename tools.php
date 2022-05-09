<?php
//func for return argument of query
//I found this function here:
//https://stackoverflow.com/questions/12933550/better-way-for-checking-request-variable
function getIfSet(string $key, mixed $defaultValue): mixed
{
    return isset($_GET[$key]) ? $_GET[$key] : $defaultValue;
}