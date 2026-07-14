<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { font-family: sans-serif; font-size: 12px; margin: 20px; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #333; }
        th, td { padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        .print-btn { display: block; margin: 20px auto; padding: 10px 20px; background: #1a56db; color: #fff; border: none; border-radius: 5px; cursor: pointer; }
        @media print { .print-btn { display: none; } }
    </style>
</head>
<body>
    <h2><?= $title ?></h2>
    <p>Tanggal Cetak: <?= date('d M Y H:i') ?></p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <?php if (!empty($rows)): ?>
                    <?php foreach(array_keys($rows[0]) as $key): ?>
                        <th><?= strtoupper(str_replace('_', ' ', $key)) ?></th>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($rows)): ?>
                <?php $i=1; foreach($rows as $row): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <?php foreach($row as $val): ?>
                            <td><?= $val ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="10" style="text-align:center;">Tidak ada data</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <button class="print-btn" onclick="window.print()">Cetak Halaman</button>
</body>
</html>
