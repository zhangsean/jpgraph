<?php

/**
 * JPGraph v4.1.0-beta.01
 */

// Include the library
require_once 'jpgraph/QR/qrencoder.inc.php';

// Data to be encoded
$data      = '01234567';
$version   = 12; // Use QR version 4
$corrlevel = QRCapacity::ErrH; // Level H error correction (the highest possible)

// Create a new instance of the encoder using the specified
// QR version and error correction
$encoder = new QREncoder($version, $corrlevel);

// Use the image backend
$backend = QRCodeBackendFactory::Create($encoder, Graph\Configs::getConfig('BACKEND_IMAGE'));

// Set the module size
$backend->SetModuleWidth(3);

// Store the barcode in the specifed file
$backend->Stroke($data);
