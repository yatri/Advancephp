<?php
    function __autoload($cname){
        include 'corelib/classes/'.'class.'.$cname.'.php';
        // include 'controllers/'.'class.'.$cname.'.php';
    }