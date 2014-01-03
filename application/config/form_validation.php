<?php

$config = array();

$config['organ_put']  = array(
    array(
        'field' => 'name',
        'label' => '組織名稱',
        'rules' => "required|is_unique[".DB_ORGAN_TREE.".oName]"
    ),
    array(
        'field' => 'parent',
        'label' => '父元素ID',
        'rules' => 'required|is_natural'
    ),

    array(
        'field' => 'sort',
        'label' => '排序號碼',
        'rules' => 'required|is_natural'
    ),
);

$config['organ_set']  = $config['organ_put'];


