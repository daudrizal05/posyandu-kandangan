<?php
     = curl_init('http://localhost:8080/api/admin/dashboard');
    curl_setopt(, CURLOPT_RETURNTRANSFER, true);
     = curl_exec();
     = curl_getinfo(, CURLINFO_HTTP_CODE);
    echo "HTTP Status: " .  . "\n";
