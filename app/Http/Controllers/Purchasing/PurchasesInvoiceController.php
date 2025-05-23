<?php

namespace App\Http\Controllers\Purchasing;

use App\Http\Controllers\Controller;
use App\Services\SAP\Facades\SAP;
use Illuminate\Http\Request;

class PurchasesInvoiceController extends Controller
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
            $paramsInvoices = [
                '$select' => 'DocEntry,DocNum,DocType,DocDate,CardCode,CardName,DocTotal,DocumentStatus',
                '$orderby' => 'CreationDate desc'
            ];
            $invoices = SAP::get('PurchaseInvoices', $paramsInvoices);
            return view('purchasing.invoice.index', compact('invoices'));
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
            //
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
