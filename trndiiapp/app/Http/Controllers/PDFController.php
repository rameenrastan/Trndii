<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Repositories\Interfaces\PdfRepositoryInterface;

class PDFController extends Controller
{


    protected $pdfRepo;

    public function _construct(PdfRepositoryInterface $pdfRepo){

        $this->pdfRepo = $pdfRepo;
    }

    public function makePDF()
    {

        $data = ['data' => 'Addresses'];

        $pdf = PDF::loadView('pdf.addresses', $data);

        return $pdf->download('addresses.pdf');
    }

    public function getPdfByItem(item $item)
    {


        $data = ['data' => $this->pdfRepo->findAddressByItem($item)];

        $pdf = PDF::loadView('pdf.addresses', $data);

        return $pdf->download('addresses.pdf');


    }
}
