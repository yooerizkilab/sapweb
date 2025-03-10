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
            // return $quotations;
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
                '$select' => 'ItemCode,ItemName',
                '$filter' => "ItemsGroupCode eq 101 or ItemsGroupCode eq 102",
            ];
            $items = $this->sapService->get('Items', $paramsItems);
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
            return view('sales.quotation.create', compact('businessPartners', 'items', 'warehouses', 'chartOfAccounts', 'projects', 'unitOfMeasures', 'salesPersons'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
            return $quotation;
            return view('sales.quotation.show', compact('quotation'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('sales.quotation.edit');
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
