<?php

namespace App\Http\Controllers\BusinessPartners;

use App\Http\Controllers\Controller;
use App\Services\SAPServices;
use Illuminate\Http\Request;

class BusinessPartnerMasterController extends Controller
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
            $paramsBusessinessMaster = [
                '$select' => 'CardCode,CardName,CardType',
                '$filter' => "startswith(CardCode, 'C00') and CardType eq 'C'",
                '$orderby' => 'CreateDate desc'
            ];
            $businessPartners = $this->sapService->get('BusinessPartners', $paramsBusessinessMaster);
            return view('business-partner.business-master.index', compact('businessPartners'));
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
        try {
            $paramsBusessinessMaster = [
                // '$select' => 'CardCode,CardName,CardType',
            ];
            $businessPartners = $this->sapService->getById('BusinessPartners', $id, $paramsBusessinessMaster);
            $paramsBussinesGroups = [
                '$select'  => 'Name'
            ];
            $businessGroups = $this->sapService->getById('BusinessPartnerGroups', $businessPartners['GroupCode'], $paramsBussinesGroups);
            $paramsSales = [
                '$select' => 'SalesEmployeeName,Telephone'
            ];
            $businessSales = $this->sapService->getById('SalesPersons', $businessPartners['SalesPersonCode'], $paramsSales);
            $paramsPaymentTerms = [
                '$select'  => 'GroupNumber,PaymentTermsGroupName',
            ];
            $businessPaymentTermsTypes = $this->sapService->getById('PaymentTermsTypes', $businessPartners['PayTermsGrpCode'], $paramsPaymentTerms);
            $paramsCountry = [
                '$select' => 'Name'
            ];
            $countries = $this->sapService->getById('Countries', $businessPartners['Country'], $paramsCountry);
            $paramsStates = [
                '$select' => 'Name'
            ];
            $states = $this->sapService->getById('States', $businessPartners['Country'], $paramsStates);
            return view('business-partner.business-master.show', compact('businessPartners', 'businessGroups', 'businessSales', 'businessPaymentTermsTypes', 'countries', 'states'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
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
