<?php
//
// Created by Grégoire JONCOUR on 25/05/2015.
// Copyright (c) 2015 Grégoire JONCOUR. All rights reserved.
//
include_once('../accessoires/functions_connect.php');
$email_user=trim($_POST['email_user']);

$data = recup_data_user(array("email" => $email_user),"newmdp");
if($data==true)
{
    echo 1;
}