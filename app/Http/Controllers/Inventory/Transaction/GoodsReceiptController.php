<?php

namespace App\Http\Controllers\Inventory\Transaction;

use App\Http\Controllers\Controller;
use App\Services\SAP\Facades\SAP;
use Illuminate\Http\Request;

class GoodsReceiptController extends Controller
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
            $paramsGoodsReceipt = [
                '$select' => 'DocEntry,DocNum,DocType,DocDate,DocTotal,DocumentStatus',
                '$orderby' => 'CreationDate desc'
            ];
            $goodsReceipts = SAP::get('InventoryGenEntries', $paramsGoodsReceipt);
            return view('inventory.transaction.goods-receipt.index', compact('goodsReceipts'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
