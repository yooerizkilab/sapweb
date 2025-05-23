<?php

namespace App\Http\Controllers\Purchasing;

use App\Http\Controllers\Controller;
use App\Services\SAP\Facades\SAP;
use Illuminate\Http\Request;

class PurchasesOrderController extends Controller
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
            $paramsPurchasesOrder = [
                '$select' => 'DocEntry,DocNum,DocType,DocDate,CardCode,CardName,DocumentStatus',
                // '$filter' => "CreationDate ge datetime'" . date('Y-01-01T00:00:00') . "' and CreationDate le datetime'" . date('Y-12-31T23:59:59') . "'",
                '$orderby' => 'CreationDate desc'
            ];
            $purchasesOrders = SAP::get('PurchaseOrders', $paramsPurchasesOrder);
            return view('purchasing.purchases-order.index', compact('purchasesOrders'));
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
