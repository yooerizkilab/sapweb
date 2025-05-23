<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SAP\Facades\SAP;

class ItemMasterDataController extends Controller
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
            // Ambil data item dari SAP
            $paramsItem = [
                '$select' => 'ItemCode,ItemName,ForeignName,ItemsGroupCode,ItemType',
                '$orderby' => 'CreateDate desc',
            ];
            $items = SAP::get('Items', $paramsItem);

            // Pastikan $items adalah array sebelum memproses
            if (empty($items) || !is_array($items)) {
                return view('inventory.item-master.index', ['items' => [], 'groups' => []]);
            }

            // Ambil daftar kode grup unik
            $groupCodes = array_unique(array_column($items, 'ItemsGroupCode'));

            if (!empty($groupCodes)) {
                // Format filter untuk multiple "Number"
                $filterGroups = count($groupCodes) == 1
                    ? "Number eq '{$groupCodes[0]}'"
                    : implode(' or ', array_map(fn($code) => "Number eq $code", $groupCodes));

                // Query ke ItemGroups
                $paramsGroup = [
                    '$select' => 'Number,GroupName',
                    '$filter' => $filterGroups,
                ];
                $groups = SAP::get('ItemGroups', $paramsGroup);

                // Jika hasilnya dalam nested array "value", ambil datanya
                $groups = $groups['value'] ?? $groups;
            } else {
                $groups = [];
            }

            return view('inventory.item-master.index', compact('items', 'groups'));
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
            return view('inventory.item-master.create');
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
            $paramsItem = [
                // '$select' => 'ItemCode,ItemName,ForeignName,ItemsGroupCode,ItemType',
                // '$orderby' => 'CreateDate desc',
            ];
            $items = SAP::getById('Items', $id, $paramsItem);
            return $items;
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
