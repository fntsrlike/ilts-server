<?php
interface ICrud
{
    function create();
    function insert();
    function update();
    function delete();
    function list();
    function set();
}