<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Services\SAPServices;
use Illuminate\Http\Request;

class SalesQuotationController extends Controller
{
    /*
    * @var $sapService
    */
    protected $sapService;

    /*
    * Create a new controller instance.
    */
    public function __construct(SAPServices $sapService)
    {
        $this->middleware('auth');
        $this->sapService = $sapService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $paramsQuotations = [
                '$select' => 'DocEntry,DocNum,DocType,DocDate,CardCode,CardName,DocTotal,DocumentStatus',
                // '$filter' => "DocDate ge datetime'" . date('Y-01-01T00:00:00') . "' and DocDate le datetime'" . date('Y-12-31T23:59:59') . "'",
                '$orderby' => 'CreationDate desc'
            ];
            $quotations = $this->sapService->get('Quotations', $paramsQuotations);
            return view('sales.quotation.index', compact('quotations'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $paramsSalesPersons = [
                '$select' => 'SalesEmployeeCode,SalesEmployeeName',
            ];
            $salesPersons = $this->sapService->getById('SalesPersons', 1, $paramsSalesPersons);
            $paramsBusinessPartners = [
                '$select' => 'CardCode,CardName',
                '$filter' => "startswith(CardCode, 'C00') and CardType eq 'C'",
                '$orderby' => 'CreateDate desc'
            ];
            $businessPartners = $this->sapService->get('BusinessPartners', $paramsBusinessPartners);
            $paramsItems = [
                '$expand' => 'Items($select=ItemCode,ItemName,ItemsGroupCode,U_IT_Profil,U_IT_Tebal,U_HR_AZ,Properties1,Properties2,Properties3,Properties4,Properties5,Properties6,Properties7,Properties8,Properties9,Properties10,Properties11,Properties12,Properties13,Properties14,Properties15,Properties16,Properties17,Properties18),U_HR_GRP_PROFILE($select=Code,Name,U_GrpName)',
                '$filter' => 'Items/U_IT_Profil eq U_HR_GRP_PROFILE/Code and Items/SalesItem eq \'tYES\' and Items/Valid eq \'tYES\' and (Items/ItemsGroupCode eq 101 or Items/ItemsGroupCode eq 102)',
                '$orderby' => 'Items/ItemCode asc'
            ];
            $items = $this->sapService->crossJoin(['Items,U_HR_GRP_PROFILE'], $paramsItems);
            $paramsPrice = [
                '$select' => 'Code,Name,U_Harga1,U_Harga2,U_Harga3,U_HET,U_Tebal',
            ];
            $price = $this->sapService->get('U_HR_GRP_PRICE');

            $priceCollection = collect($price);

            // Calculate Item for Price
            $itemPrice = [];

            foreach ($items as $item) {
                // Formula get price
                $profile = $item['Items']['U_IT_Profil'];
                $thick = $item['Items']['U_IT_Tebal'];
                $az = $item['Items']['U_HR_AZ'];
                $color = $item['Items']['Properties2'] == 'Y' ? 'WARNA' : 'NATUR';

                // Format ketebalan agar sesuai dengan format kode harga
                $convertThick = str_replace('.', '', (string) number_format($thick, 2, '.', ''));
                $pricekode = $item['U_HR_GRP_PROFILE']['U_GrpName'] . '-' . $color . '#' . $az . '#' . $convertThick;

                // Ambil semua harga yang cocok
                $matchedPrices = $priceCollection->where('Code', $pricekode);

                // Default harga jika tidak ditemukan
                $harga1 = 0;
                $harga2 = 0;
                $harga3 = 0;
                $hargahet = 0;

                if ($matchedPrices->isNotEmpty()) {
                    foreach ($matchedPrices as $priceItem) {
                        $harga1 += (float) $priceItem['U_Harga1'];
                        $harga2 += (float) $priceItem['U_Harga2'];
                        $harga3 += (float) $priceItem['U_Harga3'];
                        $hargahet += (float) $priceItem['U_HET'];
                    }
                }

                // Simpan harga sebelum penyesuaian
                $harga1x = $harga1;
                $harga2x = $harga2;
                $harga3x = $harga3;
                $hargahetx = $hargahet;

                $harga1xx = $harga1;
                $harga2xx = $harga2;
                $harga3xx = $harga3;
                $hargahetxx = $hargahet;

                // Periksa properti tambahan dan sesuaikan harga
                if ($item['Items']['Properties1'] == 'Y') { // Batik
                    $harga1xx += 1000;
                    $harga2xx += 1000;
                    $harga3xx += 1000;
                    $hargahetxx += 1000;
                }

                if ($item['Items']['Properties3'] == 'Y') { // Radial
                    $harga1xx += 14500;
                    $harga2xx += 14500;
                    $harga3xx += 14500;
                    $hargahetxx += 14500;
                }

                if ($item['Items']['Properties4'] == 'Y') { // Crimping
                    $harga1xx += 14500;
                    $harga2xx += 14500;
                    $harga3xx += 14500;
                    $hargahetxx += 14500;
                }

                if ($item['Items']['Properties9'] == 'Y') { // PU
                    $harga1xx += 170000;
                    $harga2xx += 170000;
                    $harga3xx += 170000;
                    $hargahetxx += 170000;
                }

                if ($item['Items']['Properties10'] == 'Y') { // PE
                    $harga1xx += 50000;
                    $harga2xx += 50000;
                    $harga3xx += 50000;
                    $hargahetxx += 50000;
                }

                // Penyesuaian lebih lanjut
                if ($item['Items']['Properties11'] == 'Y' || $item['Items']['Properties5'] == 'Y') {
                    $harga1xx = round($harga1xx * 1.3);
                    $harga2xx = round($harga2xx * 1.3);
                    $harga3xx = round($harga3xx * 1.3);
                    $hargahetxx = round($hargahetxx * 1.3);
                }

                if ($item['Items']['Properties13'] == 'Y' || $item['Items']['Properties14'] == 'Y' || $item['Items']['Properties16'] == 'Y' || $item['Items']['Properties17'] == 'Y') {
                    $harga1xx = round($harga1xx / 2);
                    $harga2xx = round($harga2xx / 2);
                    $harga3xx = round($harga3xx / 2);
                    $hargahetxx = round($hargahetxx / 2);
                }

                if ($item['Items']['Properties12'] == 'Y' || $item['Items']['Properties15'] == 'Y') {
                    $harga1xx = round($harga1xx / 3);
                    $harga2xx = round($harga2xx / 3);
                    $harga3xx = round($harga3xx / 3);
                    $hargahetxx = round($hargahetxx / 3);
                }

                // Simpan hasil akhir ke dalam array
                $itemPrice[] = [
                    'itemCode' => $item['Items']['ItemCode'],
                    'itemName' => $item['Items']['ItemName'],
                    'harga1' => 'HARGA1',
                    'harga2' => 'HARGA2',
                    'harga3' => 'HARGA3',
                    'hargahet' => 'HET',
                    'price1' => number_format($harga1xx / 1.11, 2),
                    'price2' => number_format($harga2xx / 1.11, 2),
                    'price3' => number_format($harga3xx / 1.11, 2),
                    'pricehet' => number_format($hargahetxx / 1.11, 2),
                ];
            }

            $paramsWarehouses = [
                '$select' => 'WarehouseCode,WarehouseName',
            ];
            $warehouses = $this->sapService->get('Warehouses', $paramsWarehouses);
            $paramsChartOfAccounts = [
                '$select' => 'Code,Name',
            ];
            $chartOfAccounts = $this->sapService->get('ChartOfAccounts', $paramsChartOfAccounts);
            $paramsProjects = [
                '$select' => 'Code,Name',
            ];
            $projects = $this->sapService->get('Projects', $paramsProjects);
            $paramsUnitOfMeasures = [
                '$select' => 'Code,Name',
            ];
            $unitOfMeasures = $this->sapService->get('UnitOfMeasurements', $paramsUnitOfMeasures);
            return view('sales.quotation.create', compact('businessPartners', 'itemPrice', 'warehouses', 'chartOfAccounts', 'projects', 'unitOfMeasures', 'salesPersons'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $request->all();
        try {
            //
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $paramsQuotation = [
                // '$select' => 'DocEntry,DocNum,DocType,DocDate,CardCode,CardName,DocTotal,DocumentStatus',  
            ];
            $quotation = $this->sapService->getById('Quotations', $id, $paramsQuotation);
            $paramsSalesPersons = [
                '$select' => 'SalesEmployeeCode,SalesEmployeeName',
            ];
            $salesPersons = $this->sapService->getById('SalesPersons', $quotation['SalesPersonCode'], $paramsSalesPersons);

            // Pastikan DocumentLines ada sebelum mengambil AccountCode
            $coaGroup = isset($quotation['DocumentLines'])
                ? array_unique(array_column($quotation['DocumentLines'], 'AccountCode'))
                : [];

            if (!empty($coaGroup)) {
                $filter = count($coaGroup) === 1
                    ? "Code eq '{$coaGroup[0]}'"
                    : implode(' or ', array_map(fn($code) => "Code eq '{$code}'", $coaGroup));

                $chartOfAccounts = $this->sapService->get('ChartOfAccounts', [
                    '$select' => 'Code,Name',
                    '$filter' => $filter
                ]);
            } else {
                $chartOfAccounts = [];
            }
            return view('sales.quotation.show', compact('quotation', 'salesPersons', 'chartOfAccounts'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $paramsQuotation = [
                // '$select' => 'DocEntry,DocNum,DocType,DocDate,CardCode,CardName,DocTotal,DocumentStatus',  
            ];
            $quotation = $this->sapService->getById('Quotations', $id, $paramsQuotation);
            return view('sales.quotation.edit', compact('quotation'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            //
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            //
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Close the specified resource.
     */
    public function close(string $id)
    {
        try {
            //
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Cancel the specified resource.
     */
    public function cancel(string $id)
    {
        try {
            //
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Download the specified resource.
     */
    public function downloadPDF(string $id)
    {
        try {
            //
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
