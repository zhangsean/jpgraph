<?php

/**
 * JPGraph v4.1.0-beta.01
 */

require_once __DIR__ . '/../../src/config.inc.php';

require_once 'jpgraph/jpgraph_canvas.php';
require_once 'jpgraph/jpgraph_table.php';

$cols = 4;
$rows = 3;
$data = [['', 'Jan', 'Feb', 'Mar', 'Apr'],
    ['Min', '15.2', '12.5', '9.9', '70.0'],
    ['Max', '23.9', '14.2', '18.6', '71.3'], ];

$__width  = 300;
$__height = 200;
$graph    = new CanvasGraph($__width, $__height);

$table = new GTextTable($cols, $rows);
$table->Init();
$table->Set($data);

// Setup row and column headers
$table->SetRowFont(0, Graph\Configs::getConfig('FF_TIMES'), Graph\Configs::getConfig('FS_BOLD'), 11);
$table->SetRowAlign(0, 'left', 'bottom');
$table->SetRowColor(0, 'navy');
$table->SetRowFillColor(0, 'lightgray');
$table->SetColFont(0, Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 11);
$table->SetColColor(0, 'navy');
$table->SetColFillColor(0, 'lightgray');

// Highlight cell 2,3
$table->SetCellFillColor(2, 3, 'yellow');

$graph->Add($table);
$graph->Stroke();
