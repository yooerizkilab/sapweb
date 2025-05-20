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
                // '$filter' => "startswith(CardCode, 'C00') and CardType eq 'C' and CreateDate ge datetime'" . date('Y-01-01T00:00:00') . "' and CreateDate le datetime'" . date('Y-12-31T23:59:59') . "'",
                '$orderby' => 'CreateDate desc'
            ];
            $businessPartners = $this->sapService->get('BusinessPartners', $paramsBusessinessMaster);
            // return $businessPartners;
            return view('business-partner.business-master.index', compact('businessPartners'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Get a listing of the resource API.
     */
    public function apiBusinessPartners(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $paramsBusinessPartnerGroups = [
                '$select' => 'Code,Name'
            ];
            $BusinessPartnerGroups = $this->sapService->get('BusinessPartnerGroups', $paramsBusinessPartnerGroups);
            $paramsSalesPersons = [
                '$select' => 'SalesEmployeeCode,SalesEmployeeName',
                '$orderby' => 'SalesEmployeeName asc'
            ];
            $SalesPersons = $this->sapService->get('SalesPersons', $paramsSalesPersons);
            $paramsPaymentTermsTypes = [
                '$select' => 'GroupNumber,PaymentTermsGroupName',
                '$orderby' => 'PaymentTermsGroupName asc'
            ];
            $PaymentTermsTypes = $this->sapService->get('PaymentTermsTypes', $paramsPaymentTermsTypes);
            $paramsStates = [
                '$select' => 'Code,Name',
                '$filter' => "Country eq 'ID'",
                '$orderby' => 'Name asc'
            ];
            $States = $this->sapService->get('States', $paramsStates);
            return view('business-partner.business-master.create', compact('BusinessPartnerGroups', 'SalesPersons', 'PaymentTermsTypes'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $request->all();

        // Validation
        $request->validate([
            //
        ]);

        try {
            $file = [
                'FileExtension' => '',
                'FileName' => '',
                'SourcePath' => '',
                'UserID' => '',
            ];
            $attachemnts = $this->sapService->post('Attachments2', $file);

            $businessPartners = [
                // Business Partner
                'Series' => '103',
                'CardType' => $request->CardType,
                'GroupCode' => $request->GroupCode,
                'CardName' => $request->CardName,
                'Cellular' => $request->Cellular,
                'FederalTaxID' => $request->FederalTaxID,
                'ContactPerson' => $request->CardName,
                // Contact Address
                'Country' => 'ID',
                'City' => $request->CityBill,
                'County' => $request->CountyBill,
                'Address' => $request->StreetBill,
                // Sales
                'SalesPersonCode' => $request->SalesPersonCode,
                // Payment 
                'PayTermsGrpCode' => $request->PayTermsGrpCode,
                'CreditLimit' => $request->CreditLimit,
                'MaxCommitment' => $request->CreditLimit,
                // Affiliate
                'Affiliate' => $request->Affiliate,
                // 'AffiliateFor' => $request->AffiliateFor, to create new Business Partner in other DB
                // Notes 
                'Notes' => $request->Notes,
                // Attachment
                'AttachmentEntry' => $attachemnts['AttachmentEntry'],
                // Contact Address Bill and Ship
                'BPAddresses' => [
                    [
                        'AddressName' => 'BILL TO',
                        'AddressType' => 'bo_BillTo',
                        'Country' => 'ID',
                        'State' => $request->StateBill,
                        'City' => $request->CityBill,
                        'County' => $request->CountyBill,
                        'Street' => $request->StreetBill
                    ],
                    [
                        'AddressName' => 'SHIP TO',
                        'AddressType' => 'bo_ShipTo',
                        'Country' => 'ID',
                        'State' => $request->StateShip,
                        'City' => $request->CityShip,
                        'County' => $request->CountyShip,
                        'Street' => $request->StreetShip
                    ]
                ],
                // Contact
                'ContactEmployees' => [
                    [
                        'Name' => $request->CardName,
                        'MobilePhone' => $request->Cellular,
                        'Address' => $request->StreetBill,
                    ]
                ]
            ];

            $businessPartner = $this->sapService->post('BusinessPartners', $businessPartners);
            return $businessPartner;
            // return redirect()->back()->with('success', 'Business Partner ' . $businessPartner['CardCode'] . ' created successfully.');
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
        try {
            $paramsBusessinessMaster = [
                // '$select' => 'CardCode,CardName,CardType,',
            ];
            $BusinessPartners = $this->sapService->getById('BusinessPartners', $id, $paramsBusessinessMaster);
            $paramsBusinessPartnerGroups = [
                '$select' => 'Code,Name'
            ];
            $BusinessPartnerGroups = $this->sapService->get('BusinessPartnerGroups', $paramsBusinessPartnerGroups);
            $paramsSalesPersons = [
                '$select' => 'SalesEmployeeCode,SalesEmployeeName',
                '$orderby' => 'SalesEmployeeName asc'
            ];
            $SalesPersons = $this->sapService->get('SalesPersons', $paramsSalesPersons);
            $paramsPaymentTermsTypes = [
                '$select' => 'GroupNumber,PaymentTermsGroupName',
                '$orderby' => 'PaymentTermsGroupName asc'
            ];
            $PaymentTermsTypes = $this->sapService->get('PaymentTermsTypes', $paramsPaymentTermsTypes);
            $Attachments = $this->sapService->getById('Attachments2', $BusinessPartners['AttachmentEntry']);
            return view('business-partner.business-master.edit', compact('BusinessPartners', 'BusinessPartnerGroups', 'SalesPersons', 'PaymentTermsTypes'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $request->all();

        $request->validate([
            //
        ]);

        try {
            $businessPartners = [
                'CardType' => $request->CardType,
                'GroupCode' => $request->GroupCode,
                'CardName' => $request->CardName,
                'Cellular' => $request->Cellular,
                'FederalTaxID' => $request->FederalTaxID,
                'ContactPerson' => $request->CardName,
                // Contact Address
                'Country' => 'ID',
                'City' => $request->CityBill,
                'County' => $request->CountyBill,
                'Address' => $request->StreetBill,
                // Sales
                'SalesPersonCode' => $request->SalesPersonCode,
                // Payment 
                'PayTermsGrpCode' => $request->PayTermsGrpCode,
                'CreditLimit' => $request->CreditLimit,
                'MaxCommitment' => $request->CreditLimit,
                // Affiliate
                'Affiliate' => $request->Affiliate,
                // 'AffiliateFor' => $request->AffiliateFor, to create new Business Partner in other DB
                // Notes 
                'Notes' => $request->Notes,
                // Attachment
                // 'AttachmentEntry' => $attachemnts['AttachmentEntry'], // to update attachment
                // Contact Address Bill and Ship
                'BPAddresses' => [
                    [
                        'AddressName' => 'BILL TO',
                        'AddressType' => 'bo_BillTo',
                        'Country' => 'ID',
                        'State' => $request->StateBill,
                        'City' => $request->CityBill,
                        'County' => $request->CountyBill,
                        'Street' => $request->StreetBill
                    ],
                    [
                        'AddressName' => 'SHIP TO',
                        'AddressType' => 'bo_ShipTo',
                        'Country' => 'ID',
                        'State' => $request->StateShip,
                        'City' => $request->CityShip,
                        'County' => $request->CountyShip,
                        'Street' => $request->StreetShip
                    ]
                ],
                // Contact
                'ContactEmployees' => [
                    [
                        'Name' => $request->CardName,
                        'MobilePhone' => $request->Cellular,
                        'Address' => $request->StreetBill,
                    ]
                ]
            ];
            $BusinessPartners = $this->sapService->patch('BusinessPartners', $id, $businessPartners);
            return redirect()->back()->with('success', 'Business Partner ' . $BusinessPartners['CardCode'] . ' updated successfully.');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $id;
        try {
            $BusinessPartners = $this->sapService->delete('BusinessPartners', $id);
            return redirect()->back()->with('success', 'Business Partner ' . $BusinessPartners['CardCode'] . ' deleted successfully.');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
