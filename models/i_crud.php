<?php
interface ICrud
{
    function create();
    function update();
    function delete();
    function list();
    function set();
}