<?php
     = curl_init('http://localhost:8080/index.php/api/admin/pengukuran');
    curl_setopt(, CURLOPT_RETURNTRANSFER, true);
     = curl_exec();
    echo substr(, 0, 500);
