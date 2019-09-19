<?php
    function redirect($page){
        //header('location: '. URLROOT . '/' . $page);
        echo "<script>location.replace('". URLROOT . '/' . $page."')</script>";
    }