<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" href="{{asset('plugins/apex/apexcharts.css')}}">

        @vite(['resources/scss/light/assets/components/list-group.scss'])
        @vite(['resources/scss/light/assets/widgets/modules-widgets.scss'])

        @vite(['resources/scss/dark/assets/components/list-group.scss'])
        @vite(['resources/scss/dark/assets/widgets/modules-widgets.scss'])

        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">

        <!-- Sales -->

        <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-chart-one title="Revenue"/>
        </div>

        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-chart-two title="Sales by Category"/>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
            <x-widgets._w-two title="Daily sales"/>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
            <x-widgets._w-three title="Summary" :totalOrderPrice="$totalOrderPrice" :priceOfStatus="$priceOfStatus"/>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-one title="" :totalOrder="$totalOrder"/>
        </div>

        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-table-two title="Recent Orders" :recentOrders="$recentOrders"/>
        </div>

        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-table-three title="Top Selling Product" :topProducts="$topProducts"/>
        </div>

    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>

        <script src="{{asset('plugins/apex/apexcharts.min.js')}}"></script>

        {{-- Sales --}}

        <script>
            /**
             *
             * Sales
             *
             **/

            window.addEventListener("load", function(){
                try {

                    let getcorkThemeObject = sessionStorage.getItem("theme");
                    let getParseObject = JSON.parse(getcorkThemeObject)
                    let ParsedObject = getParseObject;

                    if (ParsedObject.settings.layout.darkMode) {

                        var Theme = 'dark';

                        Apex.tooltip = {
                            theme: Theme
                        }

                        /**
                         ==============================
                         |    @Options Charts Script   |
                         ==============================
                         */

                        /*
                            =================================
                                Revenue Monthly | Options
                            =================================
                        */
                        var options1 = {
                            chart: {
                                fontFamily: 'Nunito, sans-serif',
                                height: 365,
                                type: 'area',
                                zoom: {
                                    enabled: false
                                },
                                dropShadow: {
                                    enabled: true,
                                    opacity: 0.2,
                                    blur: 10,
                                    left: -7,
                                    top: 22
                                },
                                toolbar: {
                                    show: false
                                },
                            },
                            colors: ['#e7515a', '#2196f3'],
                            dataLabels: {
                                enabled: false
                            },
                            markers: {
                                discrete: [{
                                    seriesIndex: 0,
                                    dataPointIndex: 7,
                                    fillColor: '#000',
                                    strokeColor: '#000',
                                    size: 5
                                }, {
                                    seriesIndex: 2,
                                    dataPointIndex: 11,
                                    fillColor: '#000',
                                    strokeColor: '#000',
                                    size: 4
                                }]
                            },
                            subtitle: {
                                text: `${{ $total_revenue }}`,
                                align: 'left',
                                margin: 0,
                                offsetX: 130,
                                offsetY: 20,
                                floating: false,
                                style: {
                                    fontSize: '18px',
                                    color:  '#00ab55'
                                }
                            },
                            title: {
                                text: 'Total Revenue',
                                align: 'left',
                                margin: 0,
                                offsetX: -10,
                                offsetY: 20,
                                floating: false,
                                style: {
                                    fontSize: '18px',
                                    color:  '#bfc9d4'
                                },
                            },
                            stroke: {
                                show: true,
                                curve: 'smooth',
                                width: 2,
                                lineCap: 'square'
                            },
                            series: [{
                                name: 'Discount Price',
                                data: [
                                    @foreach ($months as $month)
                                        {{ $totalDiscountByMonth['revenue_' . $month] }},
                                    @endforeach
                                ]
                            }, {
                                name: 'Final Price',
                                data: [
                                    @foreach ($months as $month)
                                        {{ $totalRevenueByMonth['revenue_' . $month] }},
                                    @endforeach
                                ]
                            }],
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                            xaxis: {
                                axisBorder: {
                                    show: false
                                },
                                axisTicks: {
                                    show: false
                                },
                                crosshairs: {
                                    show: true
                                },
                                labels: {
                                    offsetX: 0,
                                    offsetY: 5,
                                    style: {
                                        fontSize: '12px',
                                        fontFamily: 'Nunito, sans-serif',
                                        cssClass: 'apexcharts-xaxis-title',
                                    },
                                }
                            },
                            yaxis: {
                                labels: {
                                    formatter: function(value, index) {
                                        return (value / 1000) + 'K'
                                    },
                                    offsetX: -15,
                                    offsetY: 0,
                                    style: {
                                        fontSize: '12px',
                                        fontFamily: 'Nunito, sans-serif',
                                        cssClass: 'apexcharts-yaxis-title',
                                    },
                                }
                            },
                            grid: {
                                borderColor: '#191e3a',
                                strokeDashArray: 5,
                                xaxis: {
                                    lines: {
                                        show: true
                                    }
                                },
                                yaxis: {
                                    lines: {
                                        show: false,
                                    }
                                },
                                padding: {
                                    top: -50,
                                    right: 0,
                                    bottom: 0,
                                    left: 5
                                },
                            },
                            legend: {
                                position: 'top',
                                horizontalAlign: 'right',
                                offsetY: -50,
                                fontSize: '16px',
                                fontFamily: 'Quicksand, sans-serif',
                                markers: {
                                    width: 10,
                                    height: 10,
                                    strokeWidth: 0,
                                    strokeColor: '#fff',
                                    fillColors: undefined,
                                    radius: 12,
                                    onClick: undefined,
                                    offsetX: -5,
                                    offsetY: 0
                                },
                                itemMargin: {
                                    horizontal: 10,
                                    vertical: 20
                                }

                            },
                            tooltip: {
                                theme: Theme,
                                marker: {
                                    show: true,
                                },
                                x: {
                                    show: false,
                                }
                            },
                            fill: {
                                type:"gradient",
                                gradient: {
                                    type: "vertical",
                                    shadeIntensity: 1,
                                    inverseColors: !1,
                                    opacityFrom: .19,
                                    opacityTo: .05,
                                    stops: [100, 100]
                                }
                            },
                            responsive: [{
                                breakpoint: 575,
                                options: {
                                    legend: {
                                        offsetY: -50,
                                    },
                                },
                            }]
                        }

                    } else {

                        var Theme = 'dark';

                        Apex.tooltip = {
                            theme: Theme
                        }

                        /**
                         ==============================
                         |    @Options Charts Script   |
                         ==============================
                         */

                        /*
                            =================================
                                Revenue Monthly | Options
                            =================================
                        */
                        var options1 = {
                            chart: {
                                fontFamily: 'Nunito, sans-serif',
                                height: 365,
                                type: 'area',
                                zoom: {
                                    enabled: false
                                },
                                dropShadow: {
                                    enabled: true,
                                    opacity: 0.2,
                                    blur: 10,
                                    left: -7,
                                    top: 22
                                },
                                toolbar: {
                                    show: false
                                },
                            },
                            colors: ['#1b55e2', '#e7515a'],
                            dataLabels: {
                                enabled: false
                            },
                            markers: {
                                discrete: [{
                                    seriesIndex: 0,
                                    dataPointIndex: 7,
                                    fillColor: '#000',
                                    strokeColor: '#000',
                                    size: 5
                                }, {
                                    seriesIndex: 2,
                                    dataPointIndex: 11,
                                    fillColor: '#000',
                                    strokeColor: '#000',
                                    size: 4
                                }]
                            },
                            subtitle: {
                                text: '$10,840',
                                align: 'left',
                                margin: 0,
                                offsetX: 100,
                                offsetY: 20,
                                floating: false,
                                style: {
                                    fontSize: '18px',
                                    color:  '#4361ee'
                                }
                            },
                            title: {
                                text: 'Total Profit',
                                align: 'left',
                                margin: 0,
                                offsetX: -10,
                                offsetY: 20,
                                floating: false,
                                style: {
                                    fontSize: '18px',
                                    color:  '#0e1726'
                                },
                            },
                            stroke: {
                                show: true,
                                curve: 'smooth',
                                width: 2,
                                lineCap: 'square'
                            },
                            series: [{
                                name: 'Discount Price',
                                data: [
                                    @foreach ($months as $month)
                                        {{ $totalDiscountByMonth['revenue_' . $month] }},
                                    @endforeach
                                ]
                            }, {
                                name: 'Final Price',
                                data: [
                                    @foreach ($months as $month)
                                        {{ $totalRevenueByMonth['revenue_' . $month] }},
                                    @endforeach
                                ]
                            }],
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                            xaxis: {
                                axisBorder: {
                                    show: false
                                },
                                axisTicks: {
                                    show: false
                                },
                                crosshairs: {
                                    show: true
                                },
                                labels: {
                                    offsetX: 0,
                                    offsetY: 5,
                                    style: {
                                        fontSize: '12px',
                                        fontFamily: 'Nunito, sans-serif',
                                        cssClass: 'apexcharts-xaxis-title',
                                    },
                                }
                            },
                            yaxis: {
                                labels: {
                                    formatter: function(value, index) {
                                        return (value / 1000) + 'K'
                                    },
                                    offsetX: -15,
                                    offsetY: 0,
                                    style: {
                                        fontSize: '12px',
                                        fontFamily: 'Nunito, sans-serif',
                                        cssClass: 'apexcharts-yaxis-title',
                                    },
                                }
                            },
                            grid: {
                                borderColor: '#e0e6ed',
                                strokeDashArray: 5,
                                xaxis: {
                                    lines: {
                                        show: true
                                    }
                                },
                                yaxis: {
                                    lines: {
                                        show: false,
                                    }
                                },
                                padding: {
                                    top: -50,
                                    right: 0,
                                    bottom: 0,
                                    left: 5
                                },
                            },
                            legend: {
                                position: 'top',
                                horizontalAlign: 'right',
                                offsetY: -50,
                                fontSize: '16px',
                                fontFamily: 'Quicksand, sans-serif',
                                markers: {
                                    width: 10,
                                    height: 10,
                                    strokeWidth: 0,
                                    strokeColor: '#fff',
                                    fillColors: undefined,
                                    radius: 12,
                                    onClick: undefined,
                                    offsetX: -5,
                                    offsetY: 0
                                },
                                itemMargin: {
                                    horizontal: 10,
                                    vertical: 20
                                }

                            },
                            tooltip: {
                                theme: Theme,
                                marker: {
                                    show: true,
                                },
                                x: {
                                    show: false,
                                }
                            },
                            fill: {
                                type:"gradient",
                                gradient: {
                                    type: "vertical",
                                    shadeIntensity: 1,
                                    inverseColors: !1,
                                    opacityFrom: .19,
                                    opacityTo: .05,
                                    stops: [100, 100]
                                }
                            },
                            responsive: [{
                                breakpoint: 575,
                                options: {
                                    legend: {
                                        offsetY: -50,
                                    },
                                },
                            }]
                        }

                    }


                    /**
                     ==============================
                     |    @Render Charts Script    |
                     ==============================
                     */

                    /*
                        ================================
                            Revenue Monthly | Render
                        ================================
                    */
                    var chart1 = new ApexCharts(
                        document.querySelector("#revenueMonthly"),
                        options1
                    );

                    chart1.render();


                    /**
                     * =================================================================================================
                     * |     @Re_Render | Re render all the necessary JS when clicked to switch/toggle theme           |
                     * =================================================================================================
                     */

                    document.querySelector('.theme-toggle').addEventListener('click', function() {

                        // console.log(sessionStorage);

                        let getcorkThemeObject = sessionStorage.getItem("theme");
                        let getParseObject = JSON.parse(getcorkThemeObject)
                        let ParsedObject = getParseObject;

                        if (ParsedObject.settings.layout.darkMode) {

                            /*
                            =================================
                                Revenue Monthly | Options
                            =================================
                          */

                            chart1.updateOptions({
                                colors: ['#e7515a', '#2196f3'],
                                subtitle: {
                                    style: {
                                        color:  '#00ab55'
                                    }
                                },
                                title: {
                                    style: {
                                        color:  '#bfc9d4'
                                    }
                                },
                                grid: {
                                    borderColor: '#191e3a',
                                }
                            })

                        } else {

                            /*
                            =================================
                                Revenue Monthly | Options
                            =================================
                          */

                            chart1.updateOptions({
                                colors: ['#1b55e2', '#e7515a'],
                                subtitle: {
                                    style: {
                                        color:  '#4361ee'
                                    }
                                },
                                title: {
                                    style: {
                                        color:  '#0e1726'
                                    }
                                },
                                grid: {
                                    borderColor: '#e0e6ed',
                                }
                            })

                        }

                    })


                } catch(e) {
                    console.log(e);
                }
            })
        </script>

        <script>
            /**
             *
             * Sales
             *
             **/

            window.addEventListener("load", function(){
                try {

                    let getcorkThemeObject = sessionStorage.getItem("theme");
                    let getParseObject = JSON.parse(getcorkThemeObject)
                    let ParsedObject = getParseObject;

                    if (ParsedObject.settings.layout.darkMode) {

                        var Theme = 'dark';

                        Apex.tooltip = {
                            theme: Theme
                        }

                        /**
                         ==============================
                         |    @Options Charts Script   |
                         ==============================
                         */

                        /*
                            ==================================
                                Sales By Category | Options
                            ==================================
                        */

                        var series = [];
                        var labels = [];

                        @foreach ($categoryCounts as $categorySlug => $data)
                        var name = "{{ $data['name'] }}";
                        var count = {{ $data['count'] }};

                        series.push(count);
                        labels.push(name);
                        @endforeach

                        var options = {
                            chart: {
                                type: 'donut',
                                width: 370,
                                height: 430
                            },
                            colors: ['#622bd7', '#e2a03f', '#e7515a', '#e2a03f'],
                            dataLabels: {
                                enabled: false
                            },
                            legend: {
                                position: 'bottom',
                                horizontalAlign: 'center',
                                fontSize: '12px',
                                markers: {
                                    width: 10,
                                    height: 10,
                                    offsetX: -5,
                                    offsetY: 0
                                },
                                itemMargin: {
                                    horizontal: 10,
                                    vertical: 30
                                }
                            },
                            plotOptions: {
                                pie: {
                                    donut: {
                                        size: '75%',
                                        background: 'transparent',
                                        labels: {
                                            show: true,
                                            name: {
                                                show: true,
                                                fontSize: '29px',
                                                fontFamily: 'Nunito, sans-serif',
                                                color: undefined,
                                                offsetY: -10
                                            },
                                            value: {
                                                show: true,
                                                fontSize: '26px',
                                                fontFamily: 'Nunito, sans-serif',
                                                color: '#1ad271',
                                                offsetY: 16,
                                                formatter: function (val) {
                                                    return val
                                                }
                                            },
                                            total: {
                                                show: true,
                                                showAlways: true,
                                                label: 'Total',
                                                color: '#888ea8',
                                                formatter: function (w) {
                                                    return w.globals.seriesTotals.reduce( function(a, b) {
                                                        return a + b
                                                    }, 0)
                                                }
                                            }
                                        }
                                    }
                                }
                            },
                            stroke: {
                                show: true,
                                width: 15,
                                colors: '#0e1726'
                            },
                            series: series,
                            labels: labels,

                            responsive: [
                                {
                                    breakpoint: 1440, options: {
                                        chart: {
                                            width: 325
                                        },
                                    }
                                },
                                {
                                    breakpoint: 1199, options: {
                                        chart: {
                                            width: 380
                                        },
                                    }
                                },
                                {
                                    breakpoint: 575, options: {
                                        chart: {
                                            width: 320
                                        },
                                    }
                                },
                            ],
                        }

                    } else {

                        var Theme = 'dark';

                        Apex.tooltip = {
                            theme: Theme
                        }

                        /**
                         ==============================
                         |    @Options Charts Script   |
                         ==============================
                         */

                        /*
                            ==================================
                                Sales By Category | Options
                            ==================================
                        */

                        var series = [];
                        var labels = [];

                        @foreach ($categoryCounts as $categorySlug => $data)
                        var name = "{{ $data['name'] }}";
                        var count = {{ $data['count'] }};

                        series.push(count);
                        labels.push(name);
                        @endforeach

                        var options = {
                            chart: {
                                type: 'donut',
                                width: 370,
                                height: 430
                            },
                            colors: ['#622bd7', '#e2a03f', '#e7515a', '#e2a03f'],
                            dataLabels: {
                                enabled: false
                            },
                            legend: {
                                position: 'bottom',
                                horizontalAlign: 'center',
                                fontSize: '12px',
                                markers: {
                                    width: 10,
                                    height: 10,
                                    offsetX: -5,
                                    offsetY: 0
                                },
                                itemMargin: {
                                    horizontal: 10,
                                    vertical: 30
                                }
                            },
                            plotOptions: {
                                pie: {
                                    donut: {
                                        size: '75%',
                                        background: 'transparent',
                                        labels: {
                                            show: true,
                                            name: {
                                                show: true,
                                                fontSize: '29px',
                                                fontFamily: 'Nunito, sans-serif',
                                                color: undefined,
                                                offsetY: -10
                                            },
                                            value: {
                                                show: true,
                                                fontSize: '26px',
                                                fontFamily: 'Nunito, sans-serif',
                                                color: '#0e1726',
                                                offsetY: 16,
                                                formatter: function (val) {
                                                    return val
                                                }
                                            },
                                            total: {
                                                show: true,
                                                showAlways: true,
                                                label: 'Total',
                                                color: '#888ea8',
                                                formatter: function (w) {
                                                    return w.globals.seriesTotals.reduce( function(a, b) {
                                                        return a + b
                                                    }, 0)
                                                }
                                            }
                                        }
                                    }
                                }
                            },
                            stroke: {
                                show: true,
                                width: 15,
                                colors: '#fff'
                            },
                            series: series,
                            labels: labels,

                            responsive: [
                                {
                                    breakpoint: 1440, options: {
                                        chart: {
                                            width: 325
                                        },
                                    }
                                },
                                {
                                    breakpoint: 1199, options: {
                                        chart: {
                                            width: 380
                                        },
                                    }
                                },
                                {
                                    breakpoint: 575, options: {
                                        chart: {
                                            width: 320
                                        },
                                    }
                                },
                            ],
                        }
                    }


                    /**
                     ==============================
                     |    @Render Charts Script    |
                     ==============================
                     */

                    /*
                        =================================
                            Sales By Category | Render
                        =================================
                    */
                    var chart = new ApexCharts(
                        document.querySelector("#chart-2"),
                        options
                    );

                    chart.render();

                    /**
                     * =================================================================================================
                     * |     @Re_Render | Re render all the necessary JS when clicked to switch/toggle theme           |
                     * =================================================================================================
                     */

                    document.querySelector('.theme-toggle').addEventListener('click', function() {

                        // console.log(sessionStorage);

                        let getcorkThemeObject = sessionStorage.getItem("theme");
                        let getParseObject = JSON.parse(getcorkThemeObject)
                        let ParsedObject = getParseObject;

                        if (ParsedObject.settings.layout.darkMode) {

                            /*
                            ==================================
                                Sales By Category | Options
                            ==================================
                            */

                            chart.updateOptions({
                                stroke: {
                                    colors: '#0e1726'
                                },
                                plotOptions: {
                                    pie: {
                                        donut: {
                                            labels: {
                                                value: {
                                                    color: '#bfc9d4'
                                                }
                                            }
                                        }
                                    }
                                }
                            })

                        } else {


                            /*
                            ==================================
                                Sales By Category | Options
                            ==================================
                            */

                            chart.updateOptions({
                                stroke: {
                                    colors: '#fff'
                                },
                                plotOptions: {
                                    pie: {
                                        donut: {
                                            labels: {
                                                value: {
                                                    color: '#0e1726'
                                                }
                                            }
                                        }
                                    }
                                }
                            })

                        }

                    })


                } catch(e) {
                    console.log(e);
                }
            })
        </script>

        <script>
            /**
             *
             * Sales
             *
             **/

            window.addEventListener("load", function(){
                try {

                    let getcorkThemeObject = sessionStorage.getItem("theme");
                    let getParseObject = JSON.parse(getcorkThemeObject)
                    let ParsedObject = getParseObject;

                    if (ParsedObject.settings.layout.darkMode) {

                        var Theme = 'dark';

                        Apex.tooltip = {
                            theme: Theme
                        }

                        /**
                         ==============================
                         |    @Options Charts Script   |
                         ==============================
                         */

                        /*
                            =============================
                                Daily Sales | Options
                            =============================
                        */
                        var d_2options1 = {
                            chart: {
                                height: 160,
                                type: 'bar',
                                stacked: true,
                                stackType: '100%',
                                toolbar: {
                                    show: false,
                                }
                            },
                            dataLabels: {
                                enabled: false,
                            },
                            stroke: {
                                show: true,
                                width: [3, 4],
                                curve: "smooth",
                            },
                            colors: ['#e2a03f', '#e0e6ed'],
                            series: [{
                                name: 'Processing',
                                data: [{{ implode(', ', array_values($paidCounts)) }}]
                            },{
                                name: 'Paid',
                                data: [{{ implode(', ', array_values($processCount)) }}]
                            }],
                            xaxis: {
                                labels: {
                                    show: false,
                                },
                                categories: ['Sun', 'Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat'],
                                crosshairs: {
                                    show: false
                                }
                            },
                            yaxis: {
                                show: false
                            },
                            fill: {
                                opacity: 1
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: false,
                                    columnWidth: '25%',
                                    borderRadius: 8,
                                }
                            },
                            legend: {
                                show: false,
                            },
                            grid: {
                                show: false,
                                xaxis: {
                                    lines: {
                                        show: false
                                    }
                                },
                                padding: {
                                    top: -20,
                                    right: 0,
                                    bottom: -40,
                                    left: 0
                                },
                            },
                            responsive: [
                                {
                                    breakpoint: 575,
                                    options: {
                                        plotOptions: {
                                            bar: {
                                                borderRadius: 5,
                                                columnWidth: '35%'
                                            }
                                        },
                                    }
                                },
                            ],
                        }

                    } else {

                        var Theme = 'dark';

                        Apex.tooltip = {
                            theme: Theme
                        }

                        /**
                         ==============================
                         |    @Options Charts Script   |
                         ==============================
                         */

                        /*
                            =============================
                                Daily Sales | Options
                            =============================
                        */
                        var d_2options1 = {
                            chart: {
                                height: 160,
                                type: 'bar',
                                stacked: true,
                                stackType: '100%',
                                toolbar: {
                                    show: false,
                                }
                            },
                            dataLabels: {
                                enabled: false,
                            },
                            stroke: {
                                show: true,
                                width: [3, 4],
                                curve: "smooth",
                            },
                            colors: ['#e2a03f', '#e0e6ed'],
                            series: [{
                                name: 'Processing',
                                data: [{{ implode(', ', array_values($paidCounts)) }}]
                            },{
                                name: 'Paid',
                                data: [{{ implode(', ', array_values($processCount)) }}]
                            }],
                            xaxis: {
                                labels: {
                                    show: false,
                                },
                                categories: ['Sun', 'Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat'],
                                crosshairs: {
                                    show: false
                                }
                            },
                            yaxis: {
                                show: false
                            },
                            fill: {
                                opacity: 1
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: false,
                                    columnWidth: '25%',
                                    borderRadius: 8,
                                }
                            },
                            legend: {
                                show: false,
                            },
                            grid: {
                                show: false,
                                xaxis: {
                                    lines: {
                                        show: false
                                    }
                                },
                                padding: {
                                    top: -20,
                                    right: 0,
                                    bottom: -40,
                                    left: 0
                                },
                            },
                            responsive: [
                                {
                                    breakpoint: 575,
                                    options: {
                                        plotOptions: {
                                            bar: {
                                                borderRadius: 5,
                                                columnWidth: '35%'
                                            }
                                        },
                                    }
                                },
                            ],
                        }

                    }


                    /**
                     ==============================
                     |    @Render Charts Script    |
                     ==============================
                     */


                    /*
                        ============================
                            Daily Sales | Render
                        ============================
                    */
                    var d_2C_1 = new ApexCharts(document.querySelector("#daily-sales"), d_2options1);
                    d_2C_1.render();


                } catch(e) {
                    console.log(e);
                }
            })
        </script>

        <script>
            /**
             *
             * Sales
             *
             **/

            window.addEventListener("load", function(){
                try {

                    let getcorkThemeObject = sessionStorage.getItem("theme");
                    let getParseObject = JSON.parse(getcorkThemeObject)
                    let ParsedObject = getParseObject;

                    if (ParsedObject.settings.layout.darkMode) {

                        var Theme = 'dark';

                        Apex.tooltip = {
                            theme: Theme
                        }

                        /**
                         ==============================
                         |    @Options Charts Script   |
                         ==============================
                         */

                        /*
                            =============================
                                Total Orders | Options
                            =============================
                        */
                        var d_2options2 = {
                            chart: {
                                id: 'sparkline1',
                                group: 'sparklines',
                                type: 'area',
                                height: 290,
                                sparkline: {
                                    enabled: true
                                },
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 2
                            },
                            fill: {
                                type:"gradient",
                                gradient: {
                                    type: "vertical",
                                    shadeIntensity: 1,
                                    inverseColors: !1,
                                    opacityFrom: .30,
                                    opacityTo: .05,
                                    stops: [100, 100]
                                }
                            },
                            series: [{
                                name: 'Order',
                                data: [{{ implode(', ', array_values($ordersCreated)) }}]
                            }],
                            labels: ['1', '2', '3', '4', '5', '6', '7'],
                            yaxis: {
                                min: 0
                            },
                            grid: {
                                padding: {
                                    top: 125,
                                    right: 0,
                                    bottom: 0,
                                    left: 0
                                },
                            },
                            tooltip: {
                                x: {
                                    show: false,
                                },
                                theme: Theme
                            },
                            colors: ['#00ab55']
                        }

                    } else {

                        var Theme = 'dark';

                        Apex.tooltip = {
                            theme: Theme
                        }

                        /**
                         ==============================
                         |    @Options Charts Script   |
                         ==============================
                         */

                        /*
                            =============================
                                Total Orders | Options
                            =============================
                        */
                        var d_2options2 = {
                            chart: {
                                id: 'sparkline1',
                                group: 'sparklines',
                                type: 'area',
                                height: 290,
                                sparkline: {
                                    enabled: true
                                },
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 2
                            },
                            fill: {
                                opacity: 1,
                                // type:"gradient",
                                // gradient: {
                                //     type: "vertical",
                                //     shadeIntensity: 1,
                                //     inverseColors: !1,
                                //     opacityFrom: .30,
                                //     opacityTo: .05,
                                //     stops: [100, 100]
                                // }
                            },
                            series: [{
                                name: 'Order',
                                data: [{{ implode(', ', array_values($ordersCreated)) }}]
                            }],
                            labels: ['1', '2', '3', '4', '5', '6', '7'],
                            yaxis: {
                                min: 0
                            },
                            grid: {
                                padding: {
                                    top: 125,
                                    right: 0,
                                    bottom: 0,
                                    left: 0
                                },
                            },
                            tooltip: {
                                x: {
                                    show: false,
                                },
                                theme: Theme
                            },
                            colors: ['#00ab55']
                        }

                    }


                    /**
                     ==============================
                     |    @Render Charts Script    |
                     ==============================
                     */


                    /*
                        ============================
                            Total Orders | Render
                        ============================
                    */
                    var d_2C_2 = new ApexCharts(document.querySelector("#total-orders"), d_2options2);
                    d_2C_2.render();

                    /**
                     * =================================================================================================
                     * |     @Re_Render | Re render all the necessary JS when clicked to switch/toggle theme           |
                     * =================================================================================================
                     */

                    document.querySelector('.theme-toggle').addEventListener('click', function() {

                        // console.log(sessionStorage);

                        let getcorkThemeObject = sessionStorage.getItem("theme");
                        let getParseObject = JSON.parse(getcorkThemeObject)
                        let ParsedObject = getParseObject;

                        if (ParsedObject.settings.layout.darkMode) {

                            /*
                                =============================
                                    Total Orders | Options
                                =============================
                            */

                            d_2C_2.updateOptions({
                                fill: {
                                    type:"gradient",
                                    gradient: {
                                        type: "vertical",
                                        shadeIntensity: 1,
                                        inverseColors: !1,
                                        opacityFrom: .30,
                                        opacityTo: .05,
                                        stops: [100, 100]
                                    }
                                }
                            })

                        } else {

                            /*
                                =============================
                                    Total Orders | Options
                                =============================
                            */

                            d_2C_2.updateOptions({
                                fill: {
                                    type:"gradient",
                                    opacity: 0.9,
                                    gradient: {
                                        type: "vertical",
                                        shadeIntensity: 1,
                                        inverseColors: !1,
                                        opacityFrom: .45,
                                        opacityTo: 0.1,
                                        stops: [100, 100]
                                    }
                                }
                            })

                        }

                    })


                } catch(e) {
                    console.log(e);
                }
            })

        </script>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
