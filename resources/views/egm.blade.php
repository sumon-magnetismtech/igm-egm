@section('title', 'Dashboard - Magnetism Tech Ltd')


@include('elements.egmheader')
@include('elements.sidebar-chat')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        @include('elements.sidebar-egm')
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- Main-body start -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="page-body">
                            <div class="row">
                                <!-- Forwarding -->
                                <h4 class="col-12">Forwarding</h4>
                                <div class="col-md-6 col-xl-3">
                                    <div class="card bg-c-pink order-card">
                                        <div class="card-block">
                                            <h6 class="m-b-20">Total Master BL</h6>
                                            <h2 class="text-right"><i
                                                    class="ti-server f-left"></i><span>{{ $totalMasterbl }}</span></h2>
                                            <p class="m-b-0">This Month<span
                                                    class="f-right">{{ $masterblCurrentMonth }}</span></p>
                                        </div>
                                        @can('masterbl-create')
                                            <a href="{{ route('egmmasterbls.create') }}"
                                                class="btn btn-dark btn-sm btn-block">
                                                Add Master BL</a>
                                        @endcan
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="card bg-c-yellow order-card">
                                        <div class="card-block">
                                            <h6 class="m-b-20">Total House BL</h6>
                                            <h2 class="text-right"><i
                                                    class="ti-server f-left"></i><span>{{ $totalHousebl }}</span></h2>
                                            <p class="m-b-0">This Month<span
                                                    class="f-right">{{ $houseblCurrentMonth }}</span></p>
                                        </div>
                                        @can('housebl-create')
                                            <a href="{{ route('egmhousebls.create') }}"
                                                class="btn btn-dark btn-sm btn-block">
                                                Add House BL</a>
                                        @endcan
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="card bg-c-blue order-card">
                                        <div class="card-block">
                                            <h6 class="m-b-20">Total Money Receipt</h6>
                                            <h2 class="text-right"><i
                                                    class="ti-server f-left"></i><span>{{ $totalMoneyReceipts }}</span>
                                            </h2>
                                            <p class="m-b-0">This Month<span
                                                    class="f-right">{{ $moneyReceiptCurrentMonth }}</span></p>
                                        </div>
                                        @can('moneyreceipt-create')
                                            <a href="{{ route('egmmoneyreceipts.create') }}" target="_blank"
                                                class="btn btn-dark btn-sm btn-block"> Add Money Receipt</a>
                                        @endcan
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="card bg-c-green order-card">
                                        <div class="card-block">
                                            <h6 class="m-b-20">Total Delivery Order</h6>
                                            <h2 class="text-right"><i
                                                    class="ti-server f-left"></i><span>{{ $totalDeliveryOrders }}</span>
                                            </h2>
                                            <p class="m-b-0">This Month<span
                                                    class="f-right">{{ $deliveryOrderCurrentMonth }}</span></p>
                                        </div>
                                        @can('deliveryorder-create')
                                            <a href="{{ route('egmdeliveryorders.create') }}" target="_blank"
                                                class="btn btn-dark btn-sm btn-block"> Add Delivery Order</a>
                                        @endcan
                                    </div>
                                </div>
                                <!-- Forwarding -->
                            </div> <!-- end row -->
                            <div class="row">
                                <h4 class="col-12">Main Line</h4>
                                <!-- Main Line -->
                                <div class="col-md-6 col-xl-3">
                                    <div class="card bg-c-pink order-card">
                                        <div class="card-block">
                                            <h6 class="m-b-20">Total Feeder</h6>
                                            <h2 class="text-right"><i
                                                    class="ti-server f-left"></i><span>{{ $totalFeeder }}</span></h2>
                                            <p class="m-b-0">This Month<span
                                                    class="f-right">{{ $feederCurrentMonth }}</span></p>
                                        </div>
                                        @can('mlo-feederinformation-create')
                                            <a href="{{ route('egmfeederinformations.create') }}"
                                                class="btn btn-dark btn-sm btn-block"> Add Feeder</a>
                                        @endcan
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="card bg-c-yellow order-card">
                                        <div class="card-block">
                                            <h6 class="m-b-20">Total BL</h6>
                                            <h2 class="text-right"><i
                                                    class="ti-server f-left"></i><span>{{ $totalBlInformation }}</span>
                                            </h2>
                                            <p class="m-b-0">This Month<span
                                                    class="f-right">{{ $blInformationCurrentMonth }}</span></p>
                                        </div>
                                        @can('mlo-mloblinformation-view')
                                            <a href="{{ route('egmmloblinformations.index') }}"
                                                class="btn btn-dark btn-sm btn-block" disabled> Add BL</a>
                                        @endcan
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="card bg-c-blue order-card">
                                        <div class="card-block">
                                            <h6 class="m-b-20">Total Money Receipt</h6>
                                            <h2 class="text-right"><i
                                                    class="ti-server f-left"></i><span>{{ $totalMloMoneyReceipts }}</span>
                                            </h2>
                                            <p class="m-b-0">This Month<span
                                                    class="f-right">{{ $mloMoneyReceiptsCurrentMonth }}</span></p>
                                        </div>
                                        @can('mlo-moneyreceipt-create')
                                            <a href="{{ route('egmmlomoneyreceipts.create') }}" target="_blank"
                                                class="btn btn-dark btn-sm btn-block"> Add Money Receipt</a>
                                        @endcan
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="card bg-c-green order-card">
                                        <div class="card-block">
                                            <h6 class="m-b-20">Total Delivery Order</h6>
                                            <h2 class="text-right"><i
                                                    class="ti-server f-left"></i><span>{{ $totalMloDeliveryOrders }}</span>
                                            </h2>
                                            <p class="m-b-0">This Month<span
                                                    class="f-right">{{ $MloDeliveryOrderCurrentMonth }}</span></p>
                                        </div>
                                        @can('mlo-deliveryorder-create')
                                            <a href="{{ route('egmmlodeliveryorders.create') }}" target="_blank"
                                                class="btn btn-dark btn-sm btn-block"> Add Delivery Order</a>
                                        @endcan
                                    </div>
                                </div>
                                <!-- Main Line -->
                            </div> <!-- end row -->
                        </div>
                        <!-- Page-body end -->
                    </div>
                    {{-- <div id="styleSelector"> </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@include('elements.footer')
