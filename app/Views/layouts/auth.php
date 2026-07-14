<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Login | SIPOSKA') ?></title>
    <meta name="description" content="SIPOSKA – Platform digital pendataan, monitoring dan pelaporan data kesehatan balita & ibu hamil wilayah Kandangan.">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* ========== RESET & BASE ========== */
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --blue:      #1a56db;
            --blue-dk:   #1344b0;
            --blue-lt:   #eff4ff;
            --gray-bg:   #f1f5fb;
            --text:      #1e293b;
            --muted:     #64748b;
            --border:    #e2e8f0;
            --radius:    10px;
        }
        html { scroll-behavior: smooth; }
        body { font-family: 'Poppins', sans-serif; color: var(--text); background: var(--gray-bg); }
        a    { text-decoration: none; color: inherit; }
        img  { display: block; max-width: 100%; }
        
        <?= $extraCss ?? '' ?>
    </style>
</head>
<body>

    <!-- Konten Utama (Form Login) -->
    <?= $this->renderSection('content') ?>

    <script>
        <?= $extraJs ?? '' ?>
    </script>
</body>
</html>
