<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PDF;

use App\Repositories\Interfaces\PdfRepositoryInterface as PdfRepositoryInterface;

class SupplierObtainAddressTest extends TestCase
{

    protected $pdfRepo;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function SupplierObtainAddressTest(PdfRepositoryInterface $pdfRepo)
    {
        $itemId = 1;

        $data = ['data' => $pdfRepo->findAddressByItemId($itemId)];

        $pdf = PDF::loadView('pdf.addresses', $data);

        $pdfName = $itemId . "Addresses.pdf";

        $this->assertTrue(true);
    }
}
