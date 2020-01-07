<?php

/**
 * JPGraph v4.1.0-beta.01
 */

// Example for use of JpGraph,
// ljp, 01/03/01 19:44
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// We need some data
$datay = [0.3031, 0.3044, 0.3049, 0.3040, 0.3024, 0.3047];

// Setup the graph.
$__width  = 400;
$__height = 200;
$graph    = new Graph\Graph($__width, $__height);
$graph->img->SetMargin(60, 30, 30, 40);
$graph->SetScale('textlin');
$graph->SetMarginColor('teal');
$graph->SetShadow();

// Create the bar pot
$bplot = new Plot\BarPlot($datay);
$bplot->SetWidth(0.6);

// This is how you make the bar graph start from something other than 0
$bplot->SetYMin(0.302);

// Setup color for gradient fill style
$tcol = [100, 100, 255];
$fcol = [255, 100, 100];
$bplot->SetFillGradient($fcol, $tcol, Graph\Configs::getConfig('GRAD_HOR'));
$bplot->SetFillColor('orange');
$graph->Add($bplot);

// Set up the title for the graph$example_title=Bargraph which doesn't start from y=0; $graph->title->set($example_title);
$graph->title->SetColor('yellow');
$graph->title->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_BOLD'), 12);

// Setup color for axis and labels
$graph->xaxis->SetColor('black', 'white');
$graph->yaxis->SetColor('black', 'white');

// Setup font for axis
$graph->xaxis->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_NORMAL'), 10);
$graph->yaxis->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_NORMAL'), 10);

// Setup X-axis title (color & font)
$graph->xaxis->title->Set('X-axis');
$graph->xaxis->title->SetColor('white');
$graph->xaxis->title->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_BOLD'), 10);

// Finally send the graph to the browser
$graph->Stroke();
