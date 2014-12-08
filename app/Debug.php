<?php
namespace octopus\app;

class Debug {
    static $debug = 1;
    static $pdoDebugMode =
    //*
        PDO::ERRMODE_EXCEPTION;
        /*/
        PDO::ERRMODE_WARNING;
    //*/
}
