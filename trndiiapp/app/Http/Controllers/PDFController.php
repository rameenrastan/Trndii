<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
    public function makePDF()
    {
        $data = ['data' => 'Addresses'];

        $pdf = PDF::loadView('pdf.addresses', $data);

        return $pdf->download('addresses.pdf');
    }
}
