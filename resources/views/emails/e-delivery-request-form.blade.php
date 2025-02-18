@component('mail::message', ['header_url' => "", 'header_title' => "QC Logistics Limited."])

To
{{$masterbl->name}} <br>
{{$masterbl->mloaddress}}
<br>

<p>
    <strong> Sub: Request for issuing E-Delivery Order B/L: {{$masterbl->mblno}}. </strong>
</p>

<p>
    Dear Sir,<br>
    We shall be highly obliged if you kindly issue an e-delivery order against the below mentioned Bill of Lading after collection of all relevant charges settled by us.
</p>


<p>
    Feeder Vessel (Voy) : {{$masterbl->fvessel}} ({{$masterbl->voyage}}) <br>
    Imp Reg No : {{$masterbl->rotno}} <br>
    MBL Line No: {{$masterbl->mloLineNo}} <br>
    Cargo Description : {{$masterbl->mloCommodity}} <br>
    Container No: @foreach($countContTypes as $key => $countContType) {{$key}}({{$countContType}}) @endforeach <br>
    Detention Charges upto: {{$masterbl->freetime}} <br>
    Service Mode: {{$masterbl->contMode}} <br>
    House Bill of Lading No : (Optional) <br>
    HBL Line No : (Optional)
</p>

<p>Thanks for your cooperation and take necessary action on this.</p>


<p>
    Thanking you, <br>
    Yours faithfully,
</p>

<p>
    Full Name: <strong>QC Logistics Limited (Mohammad Yeakub)</strong> <br>
    Full Address : C & F Tower (4th Floor), 1222, <br>
    SK Mujib Road, Agrabad, Chittagong. <br>
    Tel No: 25155926-7, 720415, 2510220 <br>
    For: QC Logistics Limited <br>
    Customs License Number : 0083/2008 <br>
    AIN Number : 301080083 <br>
</p>

@endcomponent

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} QC Logistics Limited. All rights reserved.
@endcomponent
@endslot