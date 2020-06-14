<?php
    function route($method, $controller, $action, $callback) {
        if($_SERVER['REQUEST_METHOD'] !== $method && $method !== "any")
            return;

        if($_REQUEST['controller'] !== $controller || $_REQUEST['action'] !== $action)
            return;

        $callback($_REQUEST, $_FILES);
    }
?>
