<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Services\SAPServices;
use Illuminate\Http\Request;

class SalesOrderController extends Controller
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
            $paramsOrders = [
                '$select' => 'DocEntry,DocNum,DocType,DocDate,CardCode,CardName,DocTotal,DocumentStatus',
                // '$filter' => "DocDate ge datetime'" . date('Y-01-01T00:00:00') . "' and DocDate le datetime'" . date('Y-12-31T23:59:59') . "'",
                '$orderby' => 'CreationDate desc'
            ];
            $orders = $this->sapService->get('Orders', $paramsOrders);
            return view('sales.order.index', compact('orders'));
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
            //
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
            $paramsOrders = [
                '$select' => 'DocEntry,DocNum,DocType,DocDate,DocDueDate,CardCode,CardName,Address,NumAtCard,VatSum,DocTotal,Comments,PaymentGroupCode,SalesPersonCode,DocumentStatus,DocumentLines',
            ];
            $Orders = $this->sapService->getById('Orders', $id, $paramsOrders);
            $paramsPaymentTermsTypes = [
                '$select' => 'GroupNumber,PaymentTermsGroupName',
            ];
            $PaymentTermsTypes = $this->sapService->getById('PaymentTermsTypes', $Orders['PaymentGroupCode'], $paramsPaymentTermsTypes);
            $paramsSalesPersons = [
                '$select' => 'SalesEmployeeCode,SalesEmployeeName',
            ];
            $SalesPersons = $this->sapService->getById('SalesPersons', $Orders['SalesPersonCode'], $paramsSalesPersons);
            return $Orders;
            return view('sales.order.show', compact('Orders', 'PaymentTermsTypes', 'SalesPersons'));
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
            //
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
}
