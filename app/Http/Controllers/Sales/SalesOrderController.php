<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Services\SAP\Facades\SAP;
use Illuminate\Http\Request;

class SalesOrderController extends Controller
{
    /*
    * Create a new controller instance.
    */
    public function __construct()
    {
        $this->middleware('auth');
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
            $orders = SAP::get('Orders', $paramsOrders);
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
                '$select' => 'DocEntry,DocNum,DocType,DocDate,DocDueDate,CardCode,CardName,Address,PeriodIndicator,NumAtCard,VatSum,DocTotal,Comments,PaymentGroupCode,SalesPersonCode,DocumentStatus,DocumentLines',
            ];
            $orders = SAP::getById('Orders', $id, $paramsOrders);
            $paramsPaymentTermsTypes = [
                '$select' => 'GroupNumber,PaymentTermsGroupName',
            ];
            $paymentTermsTypes = SAP::getById('PaymentTermsTypes', $orders['PaymentGroupCode'], $paramsPaymentTermsTypes);
            $paramsSalesPersons = [
                '$select' => 'SalesEmployeeCode,SalesEmployeeName',
            ];
            $salesPersons = SAP::getById('SalesPersons', $orders['SalesPersonCode'], $paramsSalesPersons);
            // Pastikan DocumentLines ada sebelum mengambil AccountCode
            $coaGroup = isset($orders['DocumentLines'])
                ? array_unique(array_column($orders['DocumentLines'], 'AccountCode'))
                : [];

            if (!empty($coaGroup)) {
                $filter = count($coaGroup) === 1
                    ? "Code eq '{$coaGroup[0]}'"
                    : implode(' or ', array_map(fn($code) => "Code eq '{$code}'", $coaGroup));

                $chartOfAccounts = SAP::get('ChartOfAccounts', [
                    '$select' => 'Code,Name',
                    '$filter' => $filter
                ]);
            } else {
                $chartOfAccounts = [];
            }

            return view('sales.order.show', compact('orders', 'paymentTermsTypes', 'salesPersons', 'chartOfAccounts'));
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
