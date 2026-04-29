<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Pembiayaan - <?= htmlspecialchars($_POST['invoice_no'] ?? '') ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Times New Roman', 'Courier New', monospace;
            background: #7f8c8d;
            padding: 30px;
        }
        .invoice {
            max-width: 1000px;
            margin: auto;
            background: white;
            border: 1px solid #000;
            padding: 20px 30px;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
        }
        .header-title {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 3px;
            border-bottom: 3px solid #000;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        .koperasi-info {
            text-align: center;
            margin-bottom: 20px;
            font-size: 12px;
            border-bottom: 1px dashed #999;
            padding-bottom: 10px;
        }
        .debitur-box {
            background: #f9f9f9;
            padding: 10px;
            border: 1px solid #ccc;
            margin: 15px 0;
            font-size: 13px;
        }
        .info-invoice {
            display: flex;
            justify-content: space-between;
            margin: 15px 0;
            font-size: 13px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 13px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: top;
        }
        th {
            background: #f0f0f0;
            text-align: center;
        }
        .total-box {
            text-align: right;
            font-size: 16px;
            font-weight: bold;
            margin: 15px 0;
            padding: 10px;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
        }
        .signature {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            text-align: center;
            font-size: 12px;
        }
        .sign-line {
            width: 200px;
            margin-top: 40px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
        .footer-note {
            margin-top: 25px;
            font-size: 10px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
            color: #555;
        }
        @media print {
            body { background: white; padding: 0; }
            .no-print { display: none; }
            .invoice { box-shadow: none; border: 1px solid #ccc; }
        }
        button {
            background: #2c3e50;
            color: white;
            padding: 10px 20px;
            margin: 20px 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover { background: #1a252f; }
        .print-group { text-align: center; }
    </style>
</head>
<body>
<div class="invoice">

    <div class="header-title">INVOICE PEMBIAYAAN</div>

    <!-- KOPERASI -->
    <div class="koperasi-info">
        <strong><?= nl2br(htmlspecialchars($_POST['koperasi_nama'] ?? 'KOPERASI / JASA KEUANGAN MITRA')) ?></strong><br>
        <?= nl2br(htmlspecialchars($_POST['koperasi_alamat'] ?? '')) ?><br>
        <?= htmlspecialchars($_POST['koperasi_kontak'] ?? '') ?>
    </div>

    <!-- DEBITUR -->
    <div class="debitur-box">
        <strong>DEBITUR / PENERIMA DANA:</strong><br>
        <?= htmlspecialchars($_POST['debitur_nama'] ?? '-') ?><br>
        NIK: <?= htmlspecialchars($_POST['debitur_nik'] ?? '-') ?><br>
        <?= nl2br(htmlspecialchars($_POST['debitur_alamat'] ?? '-')) ?>
    </div>

    <!-- INFO INVOICE -->
    <div class="info-invoice">
        <div><strong>No. Invoice:</strong> <?= htmlspecialchars($_POST['invoice_no'] ?? '-') ?></div>
        <div><strong>Tanggal:</strong> <?= htmlspecialchars($_POST['tanggal'] ?? '-') ?></div>
        <div><strong>Status:</strong> <span style="color:green; font-weight:bold;"><?= htmlspecialchars($_POST['status'] ?? 'DICAIRKAN') ?></span></div>
    </div>

    <!-- DATA BPKB -->
    <table>
        <tr><th colspan="2">INFORMASI JAMINAN BPKB</th></tr>
        <tr>
            <td style="width:30%"><strong>Merk / Tipe</strong><br><?= htmlspecialchars($_POST['bpkb_merk'] ?? '-') ?></td>
            <td><strong>Tahun</strong><br><?= htmlspecialchars($_POST['bpkb_tahun'] ?? '-') ?></td>
        </tr>
        <tr>
            <td><strong>No. Polisi</strong><br><?= htmlspecialchars($_POST['bpkb_polisi'] ?? '-') ?></td>
            <td><strong>Warna</strong><br><?= htmlspecialchars($_POST['bpkb_warna'] ?? '-') ?></td>
        </tr>
        <tr>
            <td><strong>No. BPKB</strong><br><?= htmlspecialchars($_POST['bpkb_no'] ?? '-') ?></td>
            <td><strong>No. Rangka</strong><br><?= htmlspecialchars($_POST['bpkb_rangka'] ?? '-') ?></td>
        </tr>
    </table>

    <!-- RINCIAN DANA -->
    <?php
    $plafond = floatval($_POST['plafond'] ?? 0);
    $adm = floatval($_POST['biaya_adm'] ?? 0);
    $asuransi = floatval($_POST['biaya_asuransi'] ?? 0);
    $provisi = floatval($_POST['biaya_provisi'] ?? 0);
    $total_bersih = $plafond - $adm - $asuransi - $provisi;
    ?>
    <table>
        <tr><th colspan="2">RINCIAN DANA (DISBURSEMENT)</th></tr>
        <tr><td>Plafond Pinjaman Pokok</td><td style="text-align:right">Rp <?= number_format($plafond, 0, ',', '.') ?></td></tr>
        <tr><td style="color:red">Biaya Administrasi & Notaris</td><td style="text-align:right; color:red">(Rp <?= number_format($adm, 0, ',', '.') ?>)</td></tr>
        <tr><td style="color:red">Premi Asuransi Kendaraan</td><td style="text-align:right; color:red">(Rp <?= number_format($asuransi, 0, ',', '.') ?>)</td></tr>
        <tr><td style="color:red">Biaya Provisi</td><td style="text-align:right; color:red">(Rp <?= number_format($provisi, 0, ',', '.') ?>)</td></tr>
    </table>

    <div class="total-box">
        TOTAL PENCAIRAN BERSIH (NET)<br>
        Rp <?= number_format($total_bersih, 0, ',', '.') ?>
    </div>

    <!-- KEWAJIBAN PEMBAYARAN -->
    <?php
    $angsuran = floatval($_POST['angsuran'] ?? 0);
    $tenor = intval($_POST['tenor'] ?? 0);
    $jatuh_tempo = intval($_POST['jatuh_tempo_tanggal'] ?? 29);
    $mulai_cicilan = $_POST['mulai_cicilan'] ?? date('Y-m');
    $mulai_format = date('F Y', strtotime($mulai_cicilan . '-01'));
    ?>
    <table>
        <tr><th colspan="2">KEWAJIBAN PEMBAYARAN</th></tr>
        <tr><td style="width:50%">Angsuran Per Bulan</td><td style="text-align:right">Rp <?= number_format($angsuran, 0, ',', '.') ?></td></tr>
        <tr><td>Jatuh Tempo</td><td>Tanggal <?= $jatuh_tempo ?> Setiap Bulan</td></tr>
        <tr><td>Tenor</td><td><?= $tenor ?> Bulan</td></tr>
        <tr><td>Mulai Cicilan</td><td><?= $mulai_format ?></td></tr>
    </table>

    <!-- TANDA TANGAN -->
    <div class="signature">
        <div>
            Petugas Keuangan,<br><br><br>
            <div class="sign-line">(<?= htmlspecialchars($_POST['petugas'] ?? '_________________') ?>)</div>
        </div>
        <div>
            Penerima Dana / Debitur,<br><br><br>
            <div class="sign-line">(<?= htmlspecialchars($_POST['debitur_nama'] ?? '_________________') ?>)</div>
        </div>
    </div>

    <!-- CATATAN -->
    <div class="footer-note">
        <strong>Catatan:</strong><br>
        1. BPKB asli disimpan oleh Kreditur sebagai jaminan hutang hingga pelunasan dilakukan.<br>
        2. Ketentuan pembayaran akan dikenakan denda sesuai dengan ketentuan akad kredit.<br>
        3. Invoice ini merupakan bukti pencairan dana dan pengikatan aset.
    </div>

</div>

<div class="print-group no-print">
    <button onclick="window.print()">🖨️ CETAK / PDF</button>
    <button onclick="window.location.href='index.html'">📝 BUAT INVOICE BARU</button>
</div>

</body>
</html>