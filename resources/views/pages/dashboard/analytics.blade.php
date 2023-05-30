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

        @vite(['resources/scss/light/assets/components/timeline.scss'])
        @vite(['resources/scss/dark/assets/components/timeline.scss'])
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- Analytics -->

    <div class="row layout-top-spacing">

        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-six title="Statistics" visits="{{ $total_visits }}" paids="{{ $total_paid }}"/>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-card-four title="Revenue" amount="{{ $paid_amount_by_week }}" total="{{ $total_paid_amount }}"/>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-card-five title="Total Revenue" balance="${{ $total_paid_amount }}" percentage="+ 13.6%" button="View Report" link="javascript:void(0);"/>
        </div>

        <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-chart-three title="Unique Visitors"/>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-activity-five title="Activity Log" :activityLogs="$activityLogs"/>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
             <x-widgets._w-four title="Favorites of Consumers" :totalFavorites="$total_favorites" :topFavorites="$top_favorites"/>
        </div>

        <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
            <x-widgets._w-hybrid-one title="Users Joined" chart-id="hybrid_followers" :userCreatedCounts="$userCreatedCounts" :totalUsers="$total_users"/>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-five title="Figma Design"/>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-card-one title="Jimmy Turner"/>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-card-two title="Dev Summit - New York"/>
        </div>

    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{asset('plugins/apex/apexcharts.min.js')}}"></script>

        {{-- Analytics --}}
{{--        @vite(['resources/assets/js/widgets/_wHybridOne.js'])--}}
        @vite(['resources/assets/js/widgets/_wActivityFive.js'])

        <script>
            /**
             *
             * Widget Six
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
                          ======================================
                              Visitor Statistics | Options
                          ======================================
                        */


                        // Total Visits

                        var spark1 = {
                            chart: {
                                id: 'unique-visits',
                                group: 'sparks2',
                                type: 'line',
                                height: 80,
                                sparkline: {
                                    enabled: true
                                },
                                dropShadow: {
                                    enabled: true,
                                    top: 1,
                                    left: 1,
                                    blur: 2,
                                    color: '#e2a03f',
                                    opacity: 0.7,
                                }
                            },
                            series: [{
                                data: [
                                    {{ implode(', ', array_values($visitCounts)) }}
                                ]
                            }],
                            stroke: {
                                curve: 'smooth',
                                width: 2,
                            },
                            markers: {
                                size: 0
                            },
                            grid: {
                                padding: {
                                    top: 35,
                                    bottom: 0,
                                    left: 40
                                }
                            },
                            colors: ['#e2a03f'],
                            tooltip: {
                                x: {
                                    show: false
                                },
                                y: {
                                    title: {
                                        formatter: function formatter(val) {
                                            return '';
                                        }
                                    }
                                }
                            },
                            responsive: [{
                                breakpoint: 1351,
                                options: {
                                    chart: {
                                        height: 95,
                                    },
                                    grid: {
                                        padding: {
                                            top: 35,
                                            bottom: 0,
                                            left: 0
                                        }
                                    },
                                },
                            },
                                {
                                    breakpoint: 1200,
                                    options: {
                                        chart: {
                                            height: 80,
                                        },
                                        grid: {
                                            padding: {
                                                top: 35,
                                                bottom: 0,
                                                left: 40
                                            }
                                        },
                                    },
                                },
                                {
                                    breakpoint: 576,
                                    options: {
                                        chart: {
                                            height: 95,
                                        },
                                        grid: {
                                            padding: {
                                                top: 45,
                                                bottom: 0,
                                                left: 0
                                            }
                                        },
                                    },
                                }

                            ]
                        }

                        // Paid Visits

                        var spark2 = {
                            chart: {
                                id: 'total-users',
                                group: 'sparks1',
                                type: 'line',
                                height: 80,
                                sparkline: {
                                    enabled: true
                                },
                                dropShadow: {
                                    enabled: true,
                                    top: 3,
                                    left: 1,
                                    blur: 3,
                                    color: '#009688',
                                    opacity: 0.7,
                                }
                            },
                            series: [{
                                data: [
                                    {{ implode(', ', array_values($paidCounts)) }}
                                ]
                            }],
                            stroke: {
                                curve: 'smooth',
                                width: 2,
                            },
                            markers: {
                                size: 0
                            },
                            grid: {
                                padding: {
                                    top: 35,
                                    bottom: 0,
                                    left: 40
                                }
                            },
                            colors: ['#009688'],
                            tooltip: {
                                x: {
                                    show: false
                                },
                                y: {
                                    title: {
                                        formatter: function formatter(val) {
                                            return '';
                                        }
                                    }
                                }
                            },
                            responsive: [{
                                breakpoint: 1351,
                                options: {
                                    chart: {
                                        height: 95,
                                    },
                                    grid: {
                                        padding: {
                                            top: 35,
                                            bottom: 0,
                                            left: 0
                                        }
                                    },
                                },
                            },
                                {
                                    breakpoint: 1200,
                                    options: {
                                        chart: {
                                            height: 80,
                                        },
                                        grid: {
                                            padding: {
                                                top: 35,
                                                bottom: 0,
                                                left: 40
                                            }
                                        },
                                    },
                                },
                                {
                                    breakpoint: 576,
                                    options: {
                                        chart: {
                                            height: 95,
                                        },
                                        grid: {
                                            padding: {
                                                top: 35,
                                                bottom: 0,
                                                left: 0
                                            }
                                        },
                                    },
                                }
                            ]
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
                          ======================================
                              Visitor Statistics | Options
                          ======================================
                        */


                        // Total Visits

                        var spark1 = {
                            chart: {
                                id: 'unique-visits',
                                group: 'sparks2',
                                type: 'line',
                                height: 80,
                                sparkline: {
                                    enabled: true
                                },
                                dropShadow: {
                                    enabled: true,
                                    top: 1,
                                    left: 1,
                                    blur: 2,
                                    color: '#e2a03f',
                                    opacity: 0.7,
                                }
                            },
                            series: [{
                                data: [21, 9, 36, 12, 44, 25, 59, 41, 66, 25]
                            }],
                            stroke: {
                                curve: 'smooth',
                                width: 2,
                            },
                            markers: {
                                size: 0
                            },
                            grid: {
                                padding: {
                                    top: 35,
                                    bottom: 0,
                                    left: 40
                                }
                            },
                            colors: ['#e2a03f'],
                            tooltip: {
                                x: {
                                    show: false
                                },
                                y: {
                                    title: {
                                        formatter: function formatter(val) {
                                            return '';
                                        }
                                    }
                                }
                            },
                            responsive: [{
                                breakpoint: 1351,
                                options: {
                                    chart: {
                                        height: 95,
                                    },
                                    grid: {
                                        padding: {
                                            top: 35,
                                            bottom: 0,
                                            left: 0
                                        }
                                    },
                                },
                            },
                                {
                                    breakpoint: 1200,
                                    options: {
                                        chart: {
                                            height: 80,
                                        },
                                        grid: {
                                            padding: {
                                                top: 35,
                                                bottom: 0,
                                                left: 40
                                            }
                                        },
                                    },
                                },
                                {
                                    breakpoint: 576,
                                    options: {
                                        chart: {
                                            height: 95,
                                        },
                                        grid: {
                                            padding: {
                                                top: 45,
                                                bottom: 0,
                                                left: 0
                                            }
                                        },
                                    },
                                }

                            ]
                        }

                        // Paid Visits

                        var spark2 = {
                            chart: {
                                id: 'total-users',
                                group: 'sparks1',
                                type: 'line',
                                height: 80,
                                sparkline: {
                                    enabled: true
                                },
                                dropShadow: {
                                    enabled: true,
                                    top: 3,
                                    left: 1,
                                    blur: 3,
                                    color: '#009688',
                                    opacity: 0.7,
                                }
                            },
                            series: [{
                                data: [22, 19, 30, 47, 32, 44, 34, 55, 41, 69]
                            }],
                            stroke: {
                                curve: 'smooth',
                                width: 2,
                            },
                            markers: {
                                size: 0
                            },
                            grid: {
                                padding: {
                                    top: 35,
                                    bottom: 0,
                                    left: 40
                                }
                            },
                            colors: ['#009688'],
                            tooltip: {
                                x: {
                                    show: false
                                },
                                y: {
                                    title: {
                                        formatter: function formatter(val) {
                                            return '';
                                        }
                                    }
                                }
                            },
                            responsive: [{
                                breakpoint: 1351,
                                options: {
                                    chart: {
                                        height: 95,
                                    },
                                    grid: {
                                        padding: {
                                            top: 35,
                                            bottom: 0,
                                            left: 0
                                        }
                                    },
                                },
                            },
                                {
                                    breakpoint: 1200,
                                    options: {
                                        chart: {
                                            height: 80,
                                        },
                                        grid: {
                                            padding: {
                                                top: 35,
                                                bottom: 0,
                                                left: 40
                                            }
                                        },
                                    },
                                },
                                {
                                    breakpoint: 576,
                                    options: {
                                        chart: {
                                            height: 95,
                                        },
                                        grid: {
                                            padding: {
                                                top: 35,
                                                bottom: 0,
                                                left: 0
                                            }
                                        },
                                    },
                                }
                            ]
                        }

                    }

                    /**
                     ==============================
                     |    @Render Charts Script    |
                     ==============================
                     */


                    /*
                        ======================================
                            Visitor Statistics | Script
                        ======================================
                    */

                    // Total Visits
                    let d_1C_1 = new ApexCharts(document.querySelector("#total-users"), spark1);
                    d_1C_1.render();

                    // Paid Visits
                    let d_1C_2 = new ApexCharts(document.querySelector("#paid-visits"), spark2);
                    d_1C_2.render();


                } catch(e) {
                    // statements
                    console.log(e);
                }
            })
        </script>

        <script>
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
                          ===================================
                              Unique Visitors | Options
                          ===================================
                        */

                        var d_1options1 = {
                            chart: {
                                height: 350,
                                type: 'bar',
                                toolbar: {
                                    show: false,
                                }
                            },
                            colors: ['#622bd7', '#ffbb44', '#4361ee'],
                            plotOptions: {
                                bar: {
                                    horizontal: false,
                                    columnWidth: '55%',
                                    endingShape: 'rounded',
                                    borderRadius: 10,

                                },
                            },
                            dataLabels: {
                                enabled: false
                            },
                            legend: {
                                position: 'bottom',
                                horizontalAlign: 'center',
                                fontSize: '14px',
                                markers: {
                                    width: 10,
                                    height: 10,
                                    offsetX: -5,
                                    offsetY: 0
                                },
                                itemMargin: {
                                    horizontal: 10,
                                    vertical: 8
                                }
                            },
                            grid: {
                                borderColor: '#191e3a',
                            },
                            stroke: {
                                show: true,
                                width: 2,
                                colors: ['transparent']
                            },
                            series: [
                                {
                                    name: 'EA',
                                    data: [
                                        @foreach ($months as $month)
                                            {{ $result['expert-advisor_unique_visit_' . $month] }},
                                        @endforeach
                                    ]
                                },
                                {
                                    name: 'POS System',
                                    data: [
                                        @foreach ($months as $month)
                                            {{ $result['pos-system_unique_visit_' . $month] }},
                                        @endforeach
                                    ]
                                },
                                {
                                    name: 'Web Template',
                                    data: [
                                        @foreach ($months as $month)
                                            {{ $result['web-template_unique_visit_' . $month] }},
                                        @endforeach
                                    ]
                                }
                            ],
                            xaxis: {
                                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                            },
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shade: Theme,
                                    type: 'vertical',
                                    shadeIntensity: 0.3,
                                    inverseColors: false,
                                    opacityFrom: 1,
                                    opacityTo: 0.8,
                                    stops: [0, 100]
                                }
                            },
                            tooltip: {
                                marker : {
                                    show: false,
                                },
                                theme: Theme,
                                y: {
                                    formatter: function (val) {
                                        return val
                                    }
                                }
                            },
                            responsive: [
                                {
                                    breakpoint: 767,
                                    options: {
                                        plotOptions: {
                                            bar: {
                                                borderRadius: 0,
                                                columnWidth: "50%"
                                            }
                                        }
                                    }
                                },
                            ]
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
                          ===================================
                              Unique Visitors | Options
                          ===================================
                        */

                        var d_1options1 = {
                            chart: {
                                height: 350,
                                type: 'bar',
                                toolbar: {
                                    show: false,
                                }
                            },
                            colors: ['#622bd7', '#ffbb44'],
                            plotOptions: {
                                bar: {
                                    horizontal: false,
                                    columnWidth: '55%',
                                    endingShape: 'rounded',
                                    borderRadius: 10,

                                },
                            },
                            dataLabels: {
                                enabled: false
                            },
                            legend: {
                                position: 'bottom',
                                horizontalAlign: 'center',
                                fontSize: '14px',
                                markers: {
                                    width: 10,
                                    height: 10,
                                    offsetX: -5,
                                    offsetY: 0
                                },
                                itemMargin: {
                                    horizontal: 10,
                                    vertical: 8
                                }
                            },
                            grid: {
                                borderColor: '#e0e6ed',
                            },
                            stroke: {
                                show: true,
                                width: 2,
                                colors: ['transparent']
                            },
                            series: [{
                                name: 'Direct',
                                data: [58, 44, 55, 57, 56, 61, 58, 63, 60, 66, 56, 63]
                            }, {
                                name: 'Organic',
                                data: [91, 76, 85, 101, 98, 87, 105, 91, 114, 94, 66, 70]
                            }],
                            xaxis: {
                                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                            },
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shade: Theme,
                                    type: 'vertical',
                                    shadeIntensity: 0.3,
                                    inverseColors: false,
                                    opacityFrom: 1,
                                    opacityTo: 0.8,
                                    stops: [0, 100]
                                }
                            },
                            tooltip: {
                                marker : {
                                    show: false,
                                },
                                theme: Theme,
                                y: {
                                    formatter: function (val) {
                                        return val
                                    }
                                }
                            },
                            responsive: [
                                {
                                    breakpoint: 767,
                                    options: {
                                        plotOptions: {
                                            bar: {
                                                borderRadius: 0,
                                                columnWidth: "50%"
                                            }
                                        }
                                    }
                                },
                            ]
                        }

                    }

                    /**
                     ==============================
                     |    @Render Charts Script    |
                     ==============================
                     */

                    /*
                        ===================================
                            Unique Visitors | Script
                        ===================================
                    */

                    let d_1C_3 = new ApexCharts(
                        document.querySelector("#uniqueVisits"),
                        d_1options1
                    );
                    d_1C_3.render();


                    /**
                     * =================================================================================================
                     * |     @Re_Render | Re render all the necessary JS when clicked to switch/toggle theme           |
                     * =================================================================================================
                     */

                    document.querySelector('.theme-toggle').addEventListener('click', function() {

                        let getcorkThemeObject = sessionStorage.getItem("theme");
                        let getParseObject = JSON.parse(getcorkThemeObject)
                        let ParsedObject = getParseObject;

                        // console.log(ParsedObject.settings.layout.darkMode)

                        if (ParsedObject.settings.layout.darkMode) {

                            /*
                               ==============================
                               |    @Re-Render Charts Script    |
                               ==============================
                           */

                            /*
                                ===================================
                                    Unique Visitors | Script
                                ===================================
                            */

                            d_1C_3.updateOptions({
                                grid: {
                                    borderColor: '#191e3a',
                                },
                            })

                        } else {

                            /*
                                ==============================
                                |    @Re-Render Charts Script    |
                                ==============================
                            */

                            /*
                                ===================================
                                    Unique Visitors | Script
                                ===================================
                            */

                            d_1C_3.updateOptions({
                                grid: {
                                    borderColor: '#e0e6ed',
                                },
                            })

                        }

                    })


                } catch(e) {
                    // statements
                    console.log(e);
                }
            })
        </script>

        <script>
            /**
             *
             * Widget Hybrid One
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
                          ==============================
                              Statistics | Options
                          ==============================
                        */

                        // Followers

                        var d_1options3 = {
                            chart: {
                                id: 'sparkline1',
                                type: 'area',
                                height: 160,
                                sparkline: {
                                    enabled: true
                                },
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 2,
                            },
                            series: [{
                                name: 'Users',
                                data: [{{ implode(', ', array_values($userCreatedCounts)) }}]
                            }],
                            labels: ['1', '2', '3', '4', '5', '6', '7'],
                            yaxis: {
                                min: 0
                            },
                            colors: ['#4361ee'],
                            tooltip: {
                                x: {
                                    show: false,
                                }
                            },
                            grid: {
                                show: false,
                                xaxis: {
                                    lines: {
                                        show: false
                                    }
                                },
                                padding: {
                                    top: 5,
                                    right: 0,
                                    left: 0
                                },
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
                            }
                        }

                        // Referral

                        var d_1options4 = {
                            chart: {
                                id: 'sparkline1',
                                type: 'area',
                                height: 160,
                                sparkline: {
                                    enabled: true
                                },
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 2,
                            },
                            series: [{
                                name: 'Sales',
                                data: [ 60, 28, 52, 38, 40, 36, 38]
                            }],
                            labels: ['1', '2', '3', '4', '5', '6', '7'],
                            yaxis: {
                                min: 0
                            },
                            colors: ['#e7515a'],
                            tooltip: {
                                x: {
                                    show: false,
                                }
                            },
                            grid: {
                                show: false,
                                xaxis: {
                                    lines: {
                                        show: false
                                    }
                                },
                                padding: {
                                    top: 5,
                                    right: 0,
                                    left: 0
                                },
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
                            }
                        }

                        // Engagement Rate

                        var d_1options5 = {
                            chart: {
                                id: 'sparkline1',
                                type: 'area',
                                height: 160,
                                sparkline: {
                                    enabled: true
                                },
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 2,
                            },
                            fill: {
                                opacity: 1,
                            },
                            series: [{
                                name: 'Sales',
                                data: [28, 50, 36, 60, 38, 52, 38 ]
                            }],
                            labels: ['1', '2', '3', '4', '5', '6', '7'],
                            yaxis: {
                                min: 0
                            },
                            colors: ['#00ab55'],
                            tooltip: {
                                x: {
                                    show: false,
                                }
                            },
                            grid: {
                                show: false,
                                xaxis: {
                                    lines: {
                                        show: false
                                    }
                                },
                                padding: {
                                    top: 5,
                                    right: 0,
                                    left: 0
                                },
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
                            }
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
                          ==============================
                              Statistics | Options
                          ==============================
                        */

                        // Followers

                        var d_1options3 = {
                            chart: {
                                id: 'sparkline1',
                                type: 'area',
                                height: 160,
                                sparkline: {
                                    enabled: true
                                },
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 2,
                            },
                            series: [{
                                name: 'Sales',
                                data: [38, 60, 38, 52, 36, 40, 28 ]
                            }],
                            labels: ['1', '2', '3', '4', '5', '6', '7'],
                            yaxis: {
                                min: 0
                            },
                            colors: ['#4361ee'],
                            tooltip: {
                                x: {
                                    show: false,
                                }
                            },
                            grid: {
                                show: false,
                                xaxis: {
                                    lines: {
                                        show: false
                                    }
                                },
                                padding: {
                                    top: 5,
                                    right: 0,
                                    left: 0
                                },
                            },
                            fill: {
                                type:"gradient",
                                gradient: {
                                    type: "vertical",
                                    shadeIntensity: 1,
                                    inverseColors: !1,
                                    opacityFrom: .40,
                                    opacityTo: .05,
                                    stops: [100, 100]
                                }
                            }
                        }

                        // Referral

                        var d_1options4 = {
                            chart: {
                                id: 'sparkline1',
                                type: 'area',
                                height: 160,
                                sparkline: {
                                    enabled: true
                                },
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 2,
                            },
                            series: [{
                                name: 'Sales',
                                data: [ 60, 28, 52, 38, 40, 36, 38]
                            }],
                            labels: ['1', '2', '3', '4', '5', '6', '7'],
                            yaxis: {
                                min: 0
                            },
                            colors: ['#e7515a'],
                            tooltip: {
                                x: {
                                    show: false,
                                }
                            },
                            grid: {
                                show: false,
                                xaxis: {
                                    lines: {
                                        show: false
                                    }
                                },
                                padding: {
                                    top: 5,
                                    right: 0,
                                    left: 0
                                },
                            },
                            fill: {
                                type:"gradient",
                                gradient: {
                                    type: "vertical",
                                    shadeIntensity: 1,
                                    inverseColors: !1,
                                    opacityFrom: .40,
                                    opacityTo: .05,
                                    stops: [100, 100]
                                }
                            }
                        }

                        // Engagement Rate

                        var d_1options5 = {
                            chart: {
                                id: 'sparkline1',
                                type: 'area',
                                height: 160,
                                sparkline: {
                                    enabled: true
                                },
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 2,
                            },
                            fill: {
                                opacity: 1,
                            },
                            series: [{
                                name: 'Sales',
                                data: [28, 50, 36, 60, 38, 52, 38 ]
                            }],
                            labels: ['1', '2', '3', '4', '5', '6', '7'],
                            yaxis: {
                                min: 0
                            },
                            colors: ['#00ab55'],
                            tooltip: {
                                x: {
                                    show: false,
                                }
                            },
                            grid: {
                                show: false,
                                xaxis: {
                                    lines: {
                                        show: false
                                    }
                                },
                                padding: {
                                    top: 5,
                                    right: 0,
                                    left: 0
                                },
                            },
                            fill: {
                                type:"gradient",
                                gradient: {
                                    type: "vertical",
                                    shadeIntensity: 1,
                                    inverseColors: !1,
                                    opacityFrom: .40,
                                    opacityTo: .05,
                                    stops: [100, 100]
                                }
                            }
                        }

                    }

                    /**
                     ==============================
                     |    @Render Charts Script    |
                     ==============================
                     */

                    /*
                        ==============================
                            Statistics | Script
                        ==============================
                    */


                    // Followers

                    let d_1C_5 = new ApexCharts(document.querySelector("#hybrid_followers"), d_1options3);
                    d_1C_5.render()

                    // Referral

                    let d_1C_6 = new ApexCharts(document.querySelector("#hybrid_followers1"), d_1options4);
                    d_1C_6.render()

                    // Engagement Rate

                    let d_1C_7 = new ApexCharts(document.querySelector("#hybrid_followers3"), d_1options5);
                    d_1C_7.render()


                    /**
                     * =================================================================================================
                     * |     @Re_Render | Re render all the necessary JS when clicked to switch/toggle theme           |
                     * =================================================================================================
                     */

                    document.querySelector('.theme-toggle').addEventListener('click', function() {

                        let getcorkThemeObject = sessionStorage.getItem("theme");
                        let getParseObject = JSON.parse(getcorkThemeObject)
                        let ParsedObject = getParseObject;

                        // console.log(ParsedObject.settings.layout.darkMode)

                        if (ParsedObject.settings.layout.darkMode) {

                            /*
                               ==============================
                               |    @Re-Render Charts Script    |
                               ==============================
                           */

                            /*
                                ==============================
                                    Statistics | Script
                                ==============================
                            */


                            // Followers

                            d_1C_5.updateOptions({
                                fill: {
                                    type:"gradient",
                                    gradient: {
                                        opacityFrom: .30,
                                    }
                                }
                            })

                            // Referral

                            d_1C_6.updateOptions({
                                fill: {
                                    type:"gradient",
                                    gradient: {
                                        opacityFrom: .30,
                                    }
                                }
                            })

                            // Engagement Rate

                            d_1C_7.updateOptions({
                                fill: {
                                    type:"gradient",
                                    gradient: {
                                        opacityFrom: .30,
                                    }
                                }
                            })

                        } else {

                            /*
                                ==============================
                                |    @Re-Render Charts Script    |
                                ==============================
                            */

                            /*
                                ==============================
                                    Statistics | Script
                                ==============================
                            */


                            // Followers

                            d_1C_5.updateOptions({
                                fill: {
                                    type:"gradient",
                                    gradient: {
                                        opacityFrom: .40,
                                    }
                                }
                            })

                            // Referral

                            d_1C_6.updateOptions({
                                fill: {
                                    type:"gradient",
                                    gradient: {
                                        opacityFrom: .40,
                                    }
                                }
                            })

                            // Engagement Rate

                            d_1C_7.updateOptions({
                                fill: {
                                    type:"gradient",
                                    gradient: {
                                        opacityFrom: .40,
                                    }
                                }
                            })

                        }

                    })


                } catch(e) {
                    // statements
                    console.log(e);
                }
            })
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
