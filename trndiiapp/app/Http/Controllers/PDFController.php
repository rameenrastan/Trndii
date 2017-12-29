<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\PdfRepositoryInterface as PdfRepositoryInterface;

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


    public function getPdfByItem($itemId)
    {


        $data = ['data' => $this->pdfRepo->findAddressByItemId($itemId)];

        $pdf = PDF::loadView('pdf.addresses', $data);

        return $pdf->download('addresses.pdf');


    }
    public function getPdfByItemTest(PdfRepositoryInterface $pdfRepo)
    {



        $itemId = 1;


        $data = ['data' => $pdfRepo->findAddressByItemId($itemId)];

        $pdf = PDF::loadView('pdf.addresses', $data);

        return $pdf->download('addresses.pdf');


    }
}
