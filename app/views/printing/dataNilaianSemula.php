<?php

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isPhpEnabled', true);
$dompdf = new Dompdf($options);

$rows = $this->controller->printing->datanilaiansemula();

$gt = 0;
$i = 1;

$html = '
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nilaian Semula</title>
  <style>
  .title {
      font-family: Tahoma, Arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
      text-align:center;
      font-size: 12px;
      margin-bottom:10px;
      
    }
    .print-table {
      font-family: Tahoma, Arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
      font-size: 10px;
    }
    .print-table td,
    .print-table th {
      border: 1px solid #444;
      padding: 8px;
    }
    .print-table thead{
      background-color:#ddd;
    }
  </style>
</head>

<body>';

$html .= '<table class="title">';
$html .= '<tr><td style="width:20%; text-align:left">Tarikh : </td><td style="width:60%;font-size: 14px;font-weight:bold;">MAJLIS DAERAH TAPAH</td><td style="width:20%;text-align:right">Tarikh : 15/03/3000</td></tr>';
$html .= '<tr><td style="width:20%; text-align:left">Tarikh : </td><td>Pegangan Yang Dipinda N. Tahunan - Jadual B (CTA)</td><td style="width:20%;text-align:right">M/Surat : </td></tr>';
$html .= '</table>';
$html .= '<table class="print-table">
    <thead>
      <tr>
        <th rowspan="2">Bil</th>
        <th rowspan="2">Akaun</br> No Siri</th>
        <th rowspan="2">Nama Pemilik & Alamat Harta</th>
        <th rowspan="2">No Lot</br>No PT</br>Hakmilik</th>
        <th rowspan="2">Luas Bangunan (mp)</th>
        <th rowspan="2">Luas Tanah (mp)</th>
        <th colspan="2">Nilai Tahunan</th>
        <th colspan="2">Cukai Taksiran</th>
        <th colspan="2">Kadar</th>
      </tr>
      <tr>
        <th>Asal (RM)</th>
        <th>Baru (RM)</th>
        <th>Asal (RM)</th>
        <th>Baru (RM)</th>
        <th>Asal (%)</th>
        <th>Baru (%)</th>
      </tr>
    </thead>
    <tbody>';

foreach ($rows as $row) {
  $html .= '<tr>
        <td rowspan="3" height="95px">' . $i . '</td>
        <td rowspan="2">' . $row['no_akaun'] . '</br>' . $row['no_siri'] . '</td>
        <td rowspan="2">' . $row['pmk_nmbil'] . '</br>' . $row['adpg1'] . '</br>' . $row['adpg2'] . '</br>' . $row['adpg3'] . '</br>' . $row['adpg4'] . '</td>
        <td rowspan="2">' . $row['peg_nolot'] . '</br>' . $row['peg_nompt'] . '</br>' . $row['pmk_hkmlk'] . '</td>
        <td rowspan="2">' . $row['peg_lsbgn'] . '</td>
        <td rowspan="2">' . $row['peg_lstnh'] . '</td>
        <td>' . number_format($row['peg_nilth'], 2) . '</td>
        <td>' . number_format($row['nilth_baru'], 2) . '</td>
        <td>' . number_format($row['peg_tksir'], 2) . '</td>
        <td>' . number_format($row['cukai_baru'], 2) . '</td>
        <td>' . $row['kaw_kadar'] . '</td>
        <td>' . $row['kadar_baru'] . '</td>
      </tr>
      <tr>
        <td>Perbezaan</td>
        <td>-</td>
        <td>Perbezaan</td>
        <td>-</td>
        <td>Perbezaan</td>
        <td>-</td>
      </tr>
      <tr>
        <td colspan="11">
          Sebab-sebab : ' . $row['sebab'] . '</br>
          Catatan : ' . $row['mesej'] . '
        </td>
      </tr>';
  $i++;
}

$html .= '</tbody>
  </table>
</body>

</html>';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

// Parametersx
$x          = 505;
$y          = 490;
$text       = "{PAGE_NUM} of {PAGE_COUNT}";
$font       = $dompdf->getFontMetrics()->get_font('Helvetica', 'normal');
$size       = 16;
$color      = array(0, 0, 0);
$word_space = 0.0;
$char_space = 0.0;
$angle      = 0.0;

$dompdf->getCanvas()->page_text(
  $x,
  $y,
  $text,
  $font,
  $size,
  $color,
  $word_space,
  $char_space,
  $angle
);

$dompdf->stream('nilaiansemula.pdf', ['Attachment' => 0]);