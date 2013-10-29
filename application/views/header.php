<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>伊爾特系統Demo</title>
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">

  <style type="text/css">
    body { 
        padding-top: 70px; 
    }
  </style>
  
</head>
<body>

<header id="bs_nav_menu" class="navbar navbar-inverse navbar-fixed-top" role="navigation"c>
  <div class="container" style="max-width:1024px;">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="<?php echo base_url('sg')?>" class="navbar-brand" >Ilt System Demo</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <nav class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

      <ul class="nav navbar-nav">
        <li><a href="<?php echo base_url('about')?>">About</a></li>
        <li><a href="<?php echo base_url('user')?>">Users</a></li>
        <li><a href="<?php echo base_url('organization')?>">Organizations</a></li>
        <li><a href="<?php echo base_url('identify')?>">Identifies</a></li>
      </ul>
      

      <ul class="nav navbar-nav navbar-right">
        <li><a href="<?php echo base_url('portal/user_page')?>">User Page</a></li>
        <li><a href="<?php echo base_url('portal/logout');?>" target="_blank">Logout</a></li>
      </ul>
    </nav><!-- /.navbar-collapse -->
  </div>
</header>    

<div class="container">