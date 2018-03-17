<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Log;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\PdfRepositoryInterface as PdfRepositoryInterface;
use Psy\Util\Json;

class PDFController extends Controller
{


    protected $pdfRepo;
    protected $logger;

    public function _construct(PdfRepositoryInterface $pdfRepo){

        $this->pdfRepo = $pdfRepo;
    }

    public function makePDF()
    {

        $data = ['data' => 'Addresses'];

        $pdf = PDF::loadView('pdf.addresses', $data);

        return $pdf->download('addresses.pdf');
    }


    public function getPdfByItem(PdfRepositoryInterface $pdfRepo , $itemId, $itemName)
    {

        Log::info(session()->getId() . ' | [Download PDF Started] | ' . $itemName);

        $data = ['data' => $pdfRepo->findAddressByItemId($itemId)];

        $pdf = PDF::loadView('pdf.addresses', $data);

        $pdfName = $itemName . "_Addresses.pdf";

        Log::info(session()->getId() . ' | [Download PDF Finished] | ' . $itemName);

        return $pdf->download($pdfName);

    }


}
