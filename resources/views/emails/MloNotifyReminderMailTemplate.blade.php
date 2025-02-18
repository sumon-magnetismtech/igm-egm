@component('mail::message')
<strong>Dear Sir,</strong>

<p>
    Re: Unclaimed Cargo in (Location) <br>
    VSL/VOY : {{$blInformation->mlofeederInformation->feederVessel}} / {{$blInformation->mlofeederInformation->voyageNumber}} <br>
    POL/POD : {{$blInformation->mlofeederInformation->depPortName}} ({{$blInformation->mlofeederInformation->depPortCode}}) / {{$blInformation->mlofeederInformation->desPortName}} ({{$blInformation->mlofeederInformation->desPortCode}}) <br>
    B/L No : {{$blInformation->bolreference}} <br>
    CNTR No :
    @if ($blInformation->containernumber<=3)
        @foreach($blInformation->blcontainers as $container)
            <nobr><strong> {{$container->contref}}/{{$container->type}}-{{$container->status}}</strong>,</nobr>
        @endforeach
        <br>
    @else
        @php
        $typeCount = $blInformation->blcontainers->groupBy('type')->map(function($item,$key){
        return collect($item)->count();
        });
        @endphp
        @foreach($typeCount as $type => $count)
            <nobr>{{$count}} x {{$type}}</nobr>{{$loop->last ? null : ',' }}
        @endforeach
        <br>
    @endif
    Cargo(es) : {{Str::limit($blInformation->description, 100)}}
</p>

This is to notify that as you are concerned well the above-mentioned cargo was discharged at <strong>{{$blInformation->unloadingName}} ({{$blInformation->PUloding}})</strong> under the date of <strong>{{$blInformation->mlofeederInformation->arrivalDate ? date('d-m-Y', strtotime($blInformation->mlofeederInformation->arrivalDate)) : "----"}}</strong> and despite our repeated requests, the cargo has still been lying at the port of discharged as uncollected until now, as {{now()->format('d-m-Y')}}, as a result, the container demurrage has run to remarkable amount and the storage (rent) should be considered as well, and such costs are accumulating on a daily basis.


As such this letter serves as a reminder for you to respond to us in writing whether you going to take delivery of the shipment or give us the plan to settle this matter within <strong>7</strong> days of this letter, falling which the shipment shall be auction or disposed off according to relevant law.

Failing to reply to us within the date given, we will take that you and your customer are no longer interested in the shipment and we shall not be held liable for any consequences therafter. All relevant Port Charges will be billed to your account when this notice expires.

Please confirm by return that you are making immediate arrangements to take delivery of the cargo with payment of all relevant charges.

Your kind and prompt attention would be hightly appreciated, and we look forward to hearing from you in due course.


Thanks,<br>
{{ config('app.name') }}
@endcomponent
