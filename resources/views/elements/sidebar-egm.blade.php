<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <ul class="pcoded-item pcoded-left-item">
            @role('super-admin')
                <li
                    class="pcoded-hasmenu {{ in_array(request()->route()->getName(), ['users.index', 'roles.index', 'permissions.index']) ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="ti-settings"></i><b>D</b></span>
                        <span class="pcoded-mtext">Users</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('users.index') ? 'active' : null }}">
                            <a href="{{ route('users.index') }}"> <span class="pcoded-micon"><i
                                        class="ti-angle-right"></i></span><span class="pcoded-mtext">User</span><span
                                    class="pcoded-mcaret"></span></a>
                        </li>
                        <li class="{{ request()->routeIs('roles.index') ? 'active' : null }}">
                            <a href="{{ route('roles.index') }}"> <span class="pcoded-micon"><i
                                        class="ti-angle-right"></i></span><span class="pcoded-mtext">Role</span><span
                                    class="pcoded-mcaret"></span></a>
                        </li>
                        <li class="{{ request()->routeIs('permissions.index') ? 'active' : null }}">
                            <a href="{{ route('permissions.index') }}"> <span class="pcoded-micon"><i
                                        class="ti-angle-right"></i></span><span class="pcoded-mtext">Permission</span><span
                                    class="pcoded-mcaret"></span></a>
                        </li>
                    </ul>
                </li>
            @endrole
            <li
                class="pcoded-hasmenu  ? {{ request()->routeIs(['officenames.*', 'vatregs.*', 'packages.*', 'locations.*', 'containertypes.*', 'commoditys.*', 'offdocks.*', 'cnfagents.*', 'principals.*']) ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-panel"></i><b>P</b></span>
                    <span class="pcoded-mtext">Data Encoding</span>
                    {{-- <span class="pcoded-badge label label-warning">NEW</span> --}}
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    @can('officename-view')
                        <li class="{{ request()->routeIs('officenames.*') ? 'active' : null }}"><a
                                href="{{ route('officenames.index') }}"><span class="pcoded-micon"><i
                                        class="icon-pie-chart"></i></span><span class="pcoded-mtext"> Office Name
                                </span><span class="pcoded-mcaret"></span></a></li>
                    @endcan

                    @can('vatreg-view')
                        <li class="{{ request()->routeIs('vatregs.*') ? 'active' : null }}"><a
                                href="{{ route('vatregs.index') }}"><span class="pcoded-micon"><i
                                        class="icon-pie-chart"></i></span><span class="pcoded-mtext"> Vat Registration
                                </span><span class="pcoded-mcaret"></span></a></li>
                    @endcan

                    @can('package-view')
                        <li class="{{ request()->routeIs('packages.*') ? 'active' : null }}"><a
                                href="{{ route('packages.index') }}"><span class="pcoded-micon"><i
                                        class="icon-pie-chart"></i></span><span class="pcoded-mtext"> Package </span><span
                                    class="pcoded-mcaret"></span></a></li>
                    @endcan

                    @can('location-view')
                        <li class="{{ request()->routeIs('locations.*') ? 'active' : null }}"><a
                                href="{{ route('locations.index') }}"><span class="pcoded-micon"><i
                                        class="icon-pie-chart"></i></span><span class="pcoded-mtext"> Location </span><span
                                    class="pcoded-mcaret"></span></a></li>
                    @endcan

                    @can('containertype-view')
                        <li class="{{ request()->routeIs('containertypes.*') ? 'active' : null }}"><a
                                href="{{ route('containertypes.index') }}"><span class="pcoded-micon"><i
                                        class="icon-pie-chart"></i></span><span class="pcoded-mtext"> Container Type
                                </span><span class="pcoded-mcaret"></span></a></li>
                    @endcan

                    @can('commodity-view')
                        <li class="{{ request()->routeIs('commoditys.*') ? 'active' : null }}"><a
                                href="{{ route('commoditys.index') }}"><span class="pcoded-micon"><i
                                        class="icon-pie-chart"></i></span><span class="pcoded-mtext"> Commodity </span><span
                                    class="pcoded-mcaret"></span></a></li>
                    @endcan

                    @can('offdock-view')
                        <li class="{{ request()->routeIs('offdocks.*') ? 'active' : null }}"><a
                                href="{{ route('offdocks.index') }}"><span class="pcoded-micon"><i
                                        class="icon-pie-chart"></i></span><span class="pcoded-mtext"> Off-Dock </span><span
                                    class="pcoded-mcaret"></span></a></li>
                    @endcan

                    @can('cnfagent-view')
                        <li class="{{ request()->routeIs('cnfagents.*') ? 'active' : null }}"><a
                                href="{{ route('cnfagents.index') }}"><span class="pcoded-micon"><i
                                        class="icon-pie-chart"></i></span><span class="pcoded-mtext"> C&F Office
                                </span><span class="pcoded-mcaret"></span></a></li>
                    @endcan

                    @can('principal-view')
                        <li class="{{ request()->routeIs('principals.*') ? 'active' : null }}"><a
                                href="{{ route('principals.index') }}"><span class="pcoded-micon"><i
                                        class="icon-pie-chart"></i></span><span class="pcoded-mtext"> Principal </span><span
                                    class="pcoded-mcaret"></span></a></li>
                    @endcan

                    @can('moneyreceipthead-view')
                        <li class="{{ request()->routeIs('moneyreceiptheads.*') ? 'active' : null }}"><a
                                href="{{ route('moneyreceiptheads.index') }}"><span class="pcoded-micon"><i
                                        class="icon-pie-chart"></i></span><span class="pcoded-mtext"> MR Heads </span><span
                                    class="pcoded-mcaret"></span></a></li>
                    @endcan
                </ul>
            </li>
        </ul>


        @canany(['mlo-feederinformation-view', 'mlo-mloblinformation-view', 'mlo-moneyreceipt-view',
            'mlo-deliveryorder-view', 'mlo-report'])
            <div class="pcoded-navigation-label bg-warning text-uppercase">Main Line Operation</div>
            <ul class="pcoded-item pcoded-left-item">

                @can('mlo-feederinformation-view')
                    <li class="pcoded-hasmenu pcoded-trigger" aria-hidden="true">
                        <a href="javascript:void(0)"> <span class="pcoded-micon"><i
                                    class="ti-layout-grid2"></i><b>BC</b></span><span class="pcoded-mtext">Feeder
                                Information</span><span class="pcoded-mcaret"></span></a>
                        <ul class="pcoded-submenu">
                            @can('mlo-feederinformation-create')
                                <li class="{{ request()->routeIs('egmfeederinformations.create') ? 'active' : null }}"><a
                                        href="{{ route('egmfeederinformations.create') }}"> <span class="pcoded-micon"><i
                                                class="ti-angle-right"></i></span><span class="pcoded-mtext">Create
                                            Feeder</span><span class="pcoded-mcaret"></span></a></li>
                            @endcan
                            <li class="{{ request()->routeIs('egmfeederinformations.index') ? 'active' : null }}"><a
                                    href="{{ route('egmfeederinformations.index') }}"><span class="pcoded-micon"><i
                                            class="ti-angle-right"></i></span><span class="pcoded-mtext">List of
                                        Feeder</span><span class="pcoded-mcaret"></span></a></li>
                            @can('mlo-mloblinformation-view')
                                <li class="{{ request()->routeIs('egmmloblinformations.index') ? 'active' : null }}"><a
                                        href="{{ route('egmmloblinformations.index') }}"> <span class="pcoded-micon"><i
                                                class="ti-angle-right"></i></span><span class="pcoded-mtext">List of BL
                                            Information</span><span class="pcoded-mcaret"></span></a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('mlo-moneyreceipt-view')
                    <li
                        class="pcoded-hasmenu pcoded-trigger {{ in_array(request()->route()->getName(), ['egmmlomoneyreceipts.create', 'egmmlomoneyreceipts.index', 'egmmlomrreport', 'egmfeederListForCustomUpdate']) ? 'active pcoded-trigger' : null }}">
                        <a href="javascript:void(0)"> <span class="pcoded-micon"><i
                                    class="ti-layout-grid2"></i><b>BC</b></span><span class="pcoded-mtext">Money
                                Receipts</span><span class="pcoded-mcaret"></span></a>
                        <ul class="pcoded-submenu">
                            @can('mlo-moneyreceipt-create')
                                <li class="{{ request()->routeIs('egmmlomoneyreceipts.create') ? 'active' : null }}"><a
                                        href="{{ route('egmmlomoneyreceipts.create') }}" target="_blank"> <span
                                            class="pcoded-micon"><i class="ti-angle-right"></i></span><span
                                            class="pcoded-mtext">Create Money Receipt</span><span
                                            class="pcoded-mcaret"></span></a></li>
                            @endcan
                            <li class="{{ request()->routeIs('egmmlomoneyreceipts.index') ? 'active' : null }}"><a
                                    href="{{ route('egmmlomoneyreceipts.index') }}"> <span class="pcoded-micon"><i
                                            class="ti-angle-right"></i></span><span class="pcoded-mtext">List of Money
                                        Receipts</span><span class="pcoded-mcaret"></span></a></li>
                            <li class="{{ request()->routeIs('egmmlomrreport') ? 'active' : null }}"><a
                                    href="{{ route('egmmlomrreport') }}"> <span class="pcoded-micon"><i
                                            class="ti-angle-right"></i></span><span class="pcoded-mtext">Money Receipts
                                        Report</span><span class="pcoded-mcaret"></span></a></li>
                            <li class="{{ request()->routeIs('egmfeederListForCustomUpdate') ? 'active' : null }}"><a
                                    href="{{ url('egmfeederListForCustomUpdate') }}"> <span class="pcoded-micon"><i
                                            class="ti-angle-right"></i></span><span class="pcoded-mtext">Feeder
                                        Update</span><span class="pcoded-mcaret"></span></a></li>
                        </ul>
                    </li>
                @endcan

                @can('mlo-deliveryorder-view')
                    <li
                        class="pcoded-hasmenu pcoded-trigger {{ in_array(request()->route()->getName(), ['egmmlodeliveryorders.create', 'egmmlodeliveryorders.index', 'egmMloDoReport', 'egmMloDoContainerReport']) ? 'active pcoded-trigger' : null }}">
                        <a href="javascript:void(0)"> <span class="pcoded-micon"><i
                                    class="ti-layout-grid2"></i><b>BC</b></span><span class="pcoded-mtext">Delivery
                                Order</span><span class="pcoded-mcaret"></span></a>
                        <ul class="pcoded-submenu">
                            @can('mlo-deliveryorder-create')
                                <li class="{{ request()->routeIs('egmmlodeliveryorders.create') ? 'active' : null }}"><a
                                        href="{{ route('egmmlodeliveryorders.create') }}" target="_blank"> <span
                                            class="pcoded-micon"><i class="ti-angle-right"></i></span><span
                                            class="pcoded-mtext">Create Delivery Order</span><span
                                            class="pcoded-mcaret"></span></a>
                                </li>
                            @endcan
                            <li class="{{ request()->routeIs('egmmlodeliveryorders.index') ? 'active' : null }}"><a
                                    href="{{ route('egmmlodeliveryorders.index') }}"> <span class="pcoded-micon"><i
                                            class="ti-angle-right"></i></span><span class="pcoded-mtext">List of Delivery
                                        Order</span><span class="pcoded-mcaret"></span></a></li>
                            <li class="{{ request()->routeIs('egmMloDoReport') ? 'active' : null }}"><a
                                    href="{{ route('egmMloDoReport') }}"> <span class="pcoded-micon"><i
                                            class="ti-angle-right"></i></span><span class="pcoded-mtext">Delivery Order
                                        Report</span><span class="pcoded-mcaret"></span></a></li>
                            <li class="{{ request()->routeIs('egmMloDoContainerReport') ? 'active' : null }}"><a
                                    href="{{ route('egmMloDoContainerReport') }}"> <span class="pcoded-micon"><i
                                            class="ti-angle-right"></i></span><span class="pcoded-mtext">DO Container
                                        Report</span><span class="pcoded-mcaret"></span></a></li>

                        </ul>
                    </li>
                @endcan
                @can('mlo-report')
                    <li
                        class="pcoded-hasmenu pcoded-trigger {{ in_array(request()->route()->getName(), ['egmMloinboundPerformanceReport', 'egmcommitmentPDF', 'egmMloladenReport']) ? 'active pcoded-trigger' : null }}">
                        <a href="javascript:void(0)"> <span class="pcoded-micon"><i
                                    class="ti-layout-grid2"></i><b>BC</b></span><span class="pcoded-mtext">MLO
                                Reports</span><span class="pcoded-mcaret"></span></a>
                        <ul class="pcoded-submenu">
                            <li class="{{ request()->routeIs('egmMloinboundPerformanceReport') ? 'active' : null }}"><a
                                    href="{{ route('egmMloinboundPerformanceReport') }}"> <span class="pcoded-micon"><i
                                            class="ti-angle-right"></i></span><span class="pcoded-mtext">Inbound
                                        Performance</span><span class="pcoded-mcaret"></span></a></li>
                            <li class="{{ request()->routeIs('egmcommitmentPDF') ? 'active' : null }}"><a
                                    href="{{ route('egmcommitmentPDF') }}"> <span class="pcoded-micon"><i
                                            class="ti-angle-right"></i></span><span class="pcoded-mtext">Commitment Letter
                                        (Bengali)</span><span class="pcoded-mcaret"></span></a></li>
                            <li class="{{ request()->routeIs('egmMloladenReport') ? 'active' : null }}"><a
                                    href="{{ route('egmMloladenReport') }}"> <span class="pcoded-micon"><i
                                            class="ti-angle-right"></i></span><span class="pcoded-mtext">Laden Containers
                                        Stock Report</span><span class="pcoded-mcaret"></span></a></li>
                        </ul>
                    </li>
                @endcan
            </ul>
        @endcan

        <div class="pcoded-navigation-label text-uppercase bg-primary">Forwarding</div>
        <ul class="pcoded-item pcoded-left-item">
            @can('masterbl-view')
                <li
                    class="pcoded-hasmenu {{ in_array(request()->route()->getName(), ['egmmasterbls.create', 'egmmasterbls.index']) ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="ti-package"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Master BL</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('masterbl-create')
                            <li class="{{ request()->routeIs('egmmasterbls.create') ? 'active' : null }}">
                                <a href="{{ route('egmmasterbls.create') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Create Master BL</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        @endcan

                        <li class="{{ request()->routeIs('egmmasterbls.index') ? 'active' : null }}">
                            <a href="{{ route('egmmasterbls.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">List of Master BL</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('housebl-view')
                <li
                    class="pcoded-hasmenu {{ in_array(request()->route()->getName(), ['housebls.create', 'housebls.index', 'searchhouseblcontainersForm', 'searchhouseblcontainers', 'houseblstatus', 'houseblstatusPDF']) ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="ti-package"></i><b>BC</b></span>
                        <span class="pcoded-mtext">House BL</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('housebl-create')
                            <li class="{{ request()->routeIs('housebls.create') ? 'active' : null }}">
                                <a href="{{ route('egmhousebls.create') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Create House BL</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        @endcan
                        <li class="{{ request()->routeIs('housebls.index') ? 'active' : null }}">
                            <a href="{{ route('egmhousebls.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">List of House BL</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li
                            class="{{ request()->routeIs(['egmsearchhouseblcontainersForm', 'egmsearchhouseblcontainers']) ? 'active' : null }}">
                            <a href="{{ route('egmsearchhouseblcontainersForm') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Container Bulk Edit </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li
                            class="{{ request()->routeIs(['egmhouseblstatus', 'egmhouseblstatusPDF']) ? 'active' : null }}">
                            <a href="{{ route('egmhouseblstatus') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">House BL Tracking</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('moneyreceipt-view')
                <li
                    class="pcoded-hasmenu {{ in_array(request()->route()->getName(), ['egmmoneyreceipts.create', 'egmmoneyreceipts.index', 'mrreport']) ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="ti-package"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Money Receipt</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('moneyreceipt-create')
                            <li class="{{ request()->routeIs('egmmoneyreceipts.create') ? 'active' : null }}">
                                <a href="{{ route('egmmoneyreceipts.create') }}" target="_blank">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Create Money Receipt</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        @endcan
                        <li class="{{ request()->routeIs('egmmoneyreceipts.index') ? 'active' : null }}">
                            <a href="{{ route('egmmoneyreceipts.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">List of Money Receipts</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('egmmrreport') ? 'active' : null }}">
                            <a href="{{ route('egmmrreport') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Money Receipts Report</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('deliveryorder-view')
                <li
                    class="pcoded-hasmenu {{ in_array(request()->route()->getName(), ['egmdeliveryorders.create', 'egmdeliveryorders.index', 'doreport']) ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="ti-package"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Delivery Order</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('deliveryorder-create')
                            <li class="{{ request()->routeIs('egmdeliveryorders.create') ? 'active' : null }}">
                                <a href="{{ route('egmdeliveryorders.create') }}" target="_blank">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Create Delivery Order</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        @endcan
                        <li class="{{ request()->routeIs('egmdeliveryorders.index') ? 'active' : null }}">
                            <a href="{{ route('egmdeliveryorders.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">List of Delivery Order</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('egmdoreport') ? 'active' : null }}">
                            <a href="{{ route('egmdoreport') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Delivery Order Report</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            <li
                class="pcoded-hasmenu {{ in_array(request()->route()->getName(), ['egmsearchFrdLetter', 'egmextensionLetter', 'eDeliverySearch', 'onChassisLetter', 'egmvesselpositioning', 'egmmailList']) ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-package"></i><b>BC</b></span>
                    <span class="pcoded-mtext">Forwarding Reports</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('egmsearchFrdLetter') ? 'active' : null }}">
                        <a href="{{ route('egmsearchFrdLetter') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Forwarding Letter</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    {{-- <li class="{{ request()->routeIs('egmextensionLetter') ? 'active' : null }}">
                        <a href="{{ route('egmextensionLetter') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Extension Letter</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('eDeliverySearch') ? 'active' : null }}">
                        <a href="{{ route('eDeliverySearch') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">E-Forwarding Letter</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('onChassisLetter') ? 'active' : null }}">
                        <a href="{{ route('onChassisLetter') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">On-Chassis Letter</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li> --}}
                    <li class="{{ request()->routeIs('egmvesselpositioning') ? 'active' : null }}">
                        <a href="{{ route('egmvesselpositioning') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Vessel Positioning</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('egmmailList') ? 'active' : null }}">
                        <a href="{{ url('egmmailList') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Mail List</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>

        @role('super-admin')
            {{-- <div class="pcoded-navigation-label">C-Track</div>
            <ul class="pcoded-item pcoded-left-item">
                <li
                    class="pcoded-hasmenu {{ in_array(request()->route()->getName(), ['emptycontainers.index', 'stfcontainerlist', 'exports.index']) ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)"> <span class="pcoded-micon"><i
                                class="ti-layout-grid2-alt"></i><b>BC</b></span><span class="pcoded-mtext">Container
                            Movement</span><span class="pcoded-mcaret"></span></a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('emptycontainers.index') ? 'active' : null }}"><a
                                href="{{ route('emptycontainers.index') }}"> <span class="pcoded-micon"><i
                                        class="ti-angle-right"></i></span><span class="pcoded-mtext">Movement</span><span
                                    class="pcoded-mcaret"></span></a></li>
                        <li class="{{ request()->routeIs('stfcontainerlist') ? 'active' : null }}"><a
                                href="{{ route('stfcontainerlist') }}"><span class="pcoded-micon"><i
                                        class="ti-angle-right"></i></span><span class="pcoded-mtext">Vessel
                                    Load</span><span class="pcoded-mcaret"></span></a></li>
                        <li class="{{ request()->routeIs('exports.index') ? 'active' : null }}"><a
                                href="{{ route('exports.index') }}"><span class="pcoded-micon"><i
                                        class="ti-angle-right"></i></span><span class="pcoded-mtext">Exports</span><span
                                    class="pcoded-mcaret"></span></a></li>
                    </ul>
                </li>
                <li
                    class="pcoded-hasmenu {{ in_array(request()->route()->getName(), ['searchDoReport', 'containerReport', 'containerStatus', 'containerSummary']) ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)"> <span class="pcoded-micon"><i
                                class="ti-layout-grid2-alt"></i><b>BC</b></span><span class="pcoded-mtext">C-Track
                            Reports</span><span class="pcoded-mcaret"></span></a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('searchDoReport') ? 'active' : null }}"><a
                                href="{{ route('searchDoReport') }}"> <span class="pcoded-micon"><i
                                        class="ti-angle-right"></i></span><span class="pcoded-mtext">Do Report
                                </span><span class="pcoded-mcaret"></span></a></li>
                        <li class="{{ request()->routeIs('containerReport') ? 'active' : null }}"><a
                                href="{{ route('containerReport') }}"> <span class="pcoded-micon"><i
                                        class="ti-angle-right"></i></span><span class="pcoded-mtext">Container Report
                                </span><span class="pcoded-mcaret"></span></a></li>
                        <li class="{{ request()->routeIs('containerStatus') ? 'active' : null }}"><a
                                href="{{ route('containerStatus') }}"> <span class="pcoded-micon"><i
                                        class="ti-angle-right"></i></span><span class="pcoded-mtext">Container Status
                                </span><span class="pcoded-mcaret"></span></a></li>
                        <li class="{{ request()->routeIs('containerSummary') ? 'active' : null }}"><a
                                href="{{ route('containerSummary') }}"> <span class="pcoded-micon"><i
                                        class="ti-angle-right"></i></span><span class="pcoded-mtext">Summary </span><span
                                    class="pcoded-mcaret"></span></a></li>
                    </ul>
                </li>
            </ul> --}}
        @endrole


    </div>
</nav>
