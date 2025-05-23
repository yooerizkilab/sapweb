<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Services\SAP\Facades\SAP;
use Illuminate\Http\Request;

class ProductionOrderController extends Controller
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
            $paramsProductionOrder = [
                '$select' => 'AbsoluteEntry,DocumentNumber,ItemNo,ProductionOrderStatus,PlannedQuantity,PostingDate,Warehouse,ProductDescription,U_IT_Panjang',
                '$orderby' => 'CreationDate desc'
            ];
            $productionOrders = SAP::get('ProductionOrders', $paramsProductionOrder);

            // Pastikan $items adalah array sebelum memproses
            if (empty($productionOrders) || !is_array($productionOrders)) {
                return view('production.production-order.index', ['productionOrders' => [], 'warehouses' => []]);
            }

            // Ambil daftar kode grup unik
            $warehouseCodes = array_unique(array_column($productionOrders, 'Warehouse'));

            if (!empty($warehouseCodes)) {
                // Format filter untuk multiple "Number"
                $filterCodes = count($warehouseCodes) == 1
                    ? "WarehouseCode eq '{$warehouseCodes[0]}'"
                    : implode(' or ', array_map(fn($code) => "WarehouseCode eq '$code'", $warehouseCodes));

                // Query ke ItemGroups
                $paramsWarehouse = [
                    '$select' => 'WarehouseCode,WarehouseName',
                    '$filter' => $filterCodes,
                ];
                $warehouses = SAP::get('Warehouses', $paramsWarehouse);

                // Jika hasilnya dalam nested array "value", ambil datanya
                $warehouses = $warehouses['value'] ?? $warehouses;
            } else {
                $warehouses = [];
            }

            return view('production.production-order.index', compact('productionOrders', 'warehouses'));
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
