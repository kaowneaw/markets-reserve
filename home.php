<?php
require('header.php');
require('db_connect.php');
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Market</title>
</head>
<body>
<div class="ui bottom attached segment pushable">
    <div class="ui visible inverted left vertical sidebar menu">
        <a class="item">
            <i class="home icon"></i>
            Home
        </a>
        <a class="item">
            <i class="block layout icon"></i>
            Topics
        </a>
        <a class="item">
            <i class="smile icon"></i>
            Friends
        </a>
        <a class="item">
            <i class="calendar icon"></i>
            History
        </a>
    </div>
    <div class="pusher">
        <div class="ui basic segment">
            <h3 class="ui header">Application Content</h3>
            <p></p>
            <p></p>
            <p></p>
            <p></p>
        </div>
    </div>
</div>
</body>
</html>
<script>
    // showing multiple
    $('.visible.example .ui.sidebar')
        .sidebar({
            context: '.visible.example .bottom.segment'
        })
        .sidebar('hide');
</script>
