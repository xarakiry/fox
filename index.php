<?php
/**
 * Part of Localhost
 * User: Yevgeniy Karpukhin
 * Date: 3/1/19
 * Time: 5:02 PM
 */

include 'Engine.php';
$data = include 'data.php';
$engine = new Engine($data);

function match($c1, $c2)
{
    global $data;
    $engine = new Engine($data);
    return $engine->getScore($c1, $c2);
}