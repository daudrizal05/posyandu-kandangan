<?php
 = ['dashboard', 'posyandu', 'balita', 'pengukuran', 'lansia', 'berita', 'galeri', 'infografis', 'dokumen', 'halaman_statis', 'pesan', 'user'];
foreach ( as ) {
    echo "--- Testing  ---\n";
     = curl_init('http://localhost/posyandu-kandangan/public/index.php/api/admin/' . );
    curl_setopt(, CURLOPT_RETURNTRANSFER, true);
     = curl_exec();
     = curl_getinfo(, CURLINFO_HTTP_CODE);
    echo "HTTP Status: \n";
    if ( !== 200) {
        echo substr(, 0, 500) . "\n";
    }
}
