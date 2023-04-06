<?php

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isPhpEnabled', true);
$dompdf = new Dompdf($options);

$rows = $this->controller->printing->datasubmition($date);
$year = substr($date, 4, 8);
$month = substr($date, 2, 2);
$day = substr($date, 0, 2);

$newdate = $year . "-" . $month . "-" . $day;

$gt = 0;
$i = 1;

$html = '
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Serahan</title>
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
      page-break-inside: auto;
    }
    .print-table td,
    .print-table th {
      border: 1px solid #444;
      padding: 2px 8px;
    }
    .print-table thead{
      background-color:#ddd;
    }
  </style>
</head>

<body>';
$html .= '<table class="title">';
$html .= '<tr><td style="width:20%; text-align:left"> </td><td style="width:60%;font-size: 14px;font-weight:bold;">MAJLIS DAERAH TAPAH</td><td style="width:20%;text-align:right"></td></tr>';
$html .= '<tr><td style="width:20%; text-align:left">Tarikh : </td><td>Pegangan Yang Dipinda N. Tahunan - Jadual B (CTA)</td><td style="width:20%;text-align:right">Tarikh : ' . $newdate . '</td></tr>';
$html .= '</table>';
$html .= '<main><table class="print-table">
    <thead>
      <tr>
        <th rowspan="2">Bil</th>
        <th rowspan="2">Akaun</th>
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
        <td rowspan="3">' . $i . '</td>
        <td rowspan="2">' . $row['akaun'] . '</td>
        <td rowspan="2">' . $row['pmk_nmbil'] . '</br>' . $row['smk_adpg1'] . '</br>' . $row['smk_adpg2'] . '</br>' . $row['smk_adpg3'] . '</br>' . $row['smk_adpg4'] . '</td>
        <td rowspan="2">' . $row['smk_nolot'] . '</br>' . $row['smk_nompt'] . '</br>' . $row['pmk_hkmlk'] . '</td>
        <td rowspan="2">' . $row['smk_lsbgn'] . '</td>
        <td rowspan="2">' . $row['smk_lstnh'] . '</td>
        <td>' . number_format($row['peg_nilth'], 2) . '</td>
        <td>-</td>
        <td>' . number_format($row['peg_tksir'], 2) . '</td>
        <td>-</td>
        <td>' . $row['kaw_kadar'] . '</td>
        <td>-</td>
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
          Sebab-sebab :</br>
          Catatan :
        </td>
      </tr>';
  $i++;
}

$html .= '</tbody>
  </table></main>
</body>

</html>';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
// Parametersx
$x          = 782;
$y          = 564;
$text       = "{PAGE_NUM} of {PAGE_COUNT}";
$font       = $dompdf->getFontMetrics()->get_font('Helvetica', 'normal');
$size       = 9;
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
$dompdf->stream('dataserahan.pdf', ['Attachment' => 0]);