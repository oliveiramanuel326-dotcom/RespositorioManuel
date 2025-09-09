<?php
    require 'vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    include 'db.php';

    $conn = connectDB();
    $result = $conn->query("SELECT * FROM orcamentos");

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Orçamento Total');
    $sheet->setCellValue('C1', 'Valor Usado');

    $rowNum = 2;
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNum, $row['id']);
        $sheet->setCellValue('B' . $rowNum, $row['orcamento_total']);
        $sheet->setCellValue('C' . $rowNum, $row['valor_usado']);
        $rowNum++;
    }

    $writer = new Xlsx($spreadsheet);
    $writer->save('orcamentos.xlsx');

    echo "Arquivo exportado com sucesso!";
?>
