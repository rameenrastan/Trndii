<?php

namespace App\Http\Controllers;

use App\itemAddreses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Log;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\ExportRepositoryInterface as ExportRepositoryInterface;
use Psy\Util\Json;
use Excel;
class ExportController extends Controller
{


    protected $exportRepo;
    protected $logger;

    public function _construct(ExportRepositoryInterface $exportRepo){

        $this->exportRepo = $exportRepo;
    }

    public function makePDF()

    {

        $data = ['data' => 'Addresses'];

        $pdf = PDF::loadView('pdf.addresses', $data);

        return $pdf->download('addresses.pdf');
    }


    public function getPdfByItem(ExportRepositoryInterface $exportRepo , $itemId, $itemName)
    {

        Log::info(session()->getId() . ' | [Download PDF Started] | ' . $itemName);

        $data = ['data' => $exportRepo->findAddressByItemId($itemId)];

        $pdf = PDF::loadView('pdf.addresses', $data);

        $pdfName = $itemName . "_Addresses.pdf";

        Log::info(session()->getId() . ' | [Download PDF Finished] | ' . $itemName);

        return $pdf->download($pdfName);

    }

      public function getExcelByItem(ExportRepositoryInterface $exportRepo, $itemId, $itemName)
    {




        $data = ['data' => $exportRepo->findAddressByItemId($itemId)];




     return   Excel::create($itemName . "_Addresses.pdf", function($excel) use ($data){
            $excel->sheet('stuff', function($sheet) use ($data) {
                $sheet->loadView('excel.itemAddresses', $data);
            });
        })->download('csv');

    }


}
