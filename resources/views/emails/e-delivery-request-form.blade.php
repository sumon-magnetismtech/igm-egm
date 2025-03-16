@component('mail::message', ['header_url' => '', 'header_title' => ' Magnetism Tech Ltd.'])
    To
    {{ $masterbl->name }} <br>
    {{ $masterbl->mloaddress }}
    <br>

    <p>
        <strong> Sub: Request for issuing E-Delivery Order B/L: {{ $masterbl->mblno }}. </strong>
    </p>

    <p>
        Dear Sir,<br>
        We shall be highly obliged if you kindly issue an e-delivery order against the below mentioned Bill of Lading after
        collection of all relevant charges settled by us.
    </p>


    <p>
        Feeder Vessel (Voy) : {{ $masterbl->fvessel }} ({{ $masterbl->voyage }}) <br>
        Imp Reg No : {{ $masterbl->rotno }} <br>
        MBL Line No: {{ $masterbl->mloLineNo }} <br>
        Cargo Description : {{ $masterbl->mloCommodity }} <br>
        Container No: @foreach ($countContTypes as $key => $countContType)
            {{ $key }}({{ $countContType }})
        @endforeach <br>
        Detention Charges upto: {{ $masterbl->freetime }} <br>
        Service Mode: {{ $masterbl->contMode }} <br>
        House Bill of Lading No : (Optional) <br>
        HBL Line No : (Optional)
    </p>

    <p>Thanks for your cooperation and take necessary action on this.</p>


    <p>
        Thanking you, <br>
        Yours faithfully,
    </p>

    <p>
        Full Name: <strong> Magnetism Tech Ltd (Mohammad Yeakub)</strong> <br>
        Full Address : Admin Future Park, 5th Floor<br>
        Barik Building, Chittagong<br>
        Tel No: +88 02333315926-7.<br>
        For: Magnetism Tech Ltd <br>
        Customs License Number : 0083/2008 <br>
        AIN Number : 301080083 <br>
    </p>
@endcomponent

{{-- Footer --}}
@slot('footer')
    @component('mail::footer')
        © {{ date('Y') }} Magnetism Tech Ltd. All rights reserved.
    @endcomponent
@endslot
