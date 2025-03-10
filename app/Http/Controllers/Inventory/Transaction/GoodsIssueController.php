<?php

namespace App\Http\Controllers\Inventory\Transaction;

use App\Http\Controllers\Controller;
use App\Services\SAPServices;
use Illuminate\Http\Request;

class GoodsIssueController extends Controller
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

            $paramsGoodsIssue = [
                '$select' => 'DocEntry,DocNum,DocType,DocDate,DocTotal,DocumentStatus',
                '$orderby' => 'CreationDate desc'
            ];
            $goodsIssues = $this->sapService->get('InventoryGenExits', $paramsGoodsIssue);
            return view('inventory.transaction.goods-issue.index', compact('goodsIssues'));
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
