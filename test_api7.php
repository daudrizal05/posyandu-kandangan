<?php
     = curl_init('http://localhost:8080/index.php/api/admin/dashboard');
    curl_setopt(, CURLOPT_RETURNTRANSFER, true);
     = curl_exec();
    echo ;
