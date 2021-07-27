<?php

function create($class, $attributes = [], $times = null)
{
    $configuration = $class::factory();
    if ($times) {
        $configuration = $configuration->count($times);
    }
    return $configuration->create($attributes);
}


function make($class, $attributes = [], $times = null)
{
    $configuration = $class::factory();
    if ($times) {
        $configuration = $configuration->count($times);
    }
    return $configuration->make($attributes);
}

function raw($class, $attributes = [], $times = null)
{
    $configuration = $class::factory();
    if ($times) {
        $configuration = $configuration->count($times);
    }
    return $configuration->raw($attributes);
}
