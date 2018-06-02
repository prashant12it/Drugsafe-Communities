<script type='text/javascript'>
    $(function () {
        $("#szIndustry").customselect();
        $("#szTestType").customselect();
    });
</script>
<div class="page-content-wrapper">
    <div class="page-content">
        <?php //test ?>

        <div id="page_content" class="row">
            <div class="col-md-12">
                <ul class="page-breadcrumb breadcrumb">

                    <li>
                        <a href="<?php echo __BASE_URL__; ?>">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>

                    <li>
                        <span class="active">Industry Chart</span>
                    </li>
                </ul>

                <div class="portlet light bordered about-text" id="user_info">

                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-red-sunglo"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase">
                                    Industry Chart
                                </span>
                        </div>
                    </div>
                    <div class="portlet-body alert">
                        <div class="row">
                            <div>

                                <div class="portlet-body">
                                    <div class="table-responsive">
                                        <?php
                                        if ($szTestType == '' || $szTestType == 'A') {
                                            ?>
                                            <div id="alcohal">
                                                <p class="group-title col-md-9">Alcohol Test, Industry Comparison</p>
                                                <p class="group-title col-md-3"><a id="alcohol-pie"
                                                                                   class="btn green-meadow custom-save-img">Save
                                                        Image</a>
                                                    <a id="alcohol-pie-pdf" class="btn green-meadow custom-save-img">Save
                                                        PDF</a></p>
                                            </div>
                                            <?php
                                        }
                                        if ($szTestType == '' || $szTestType == 'U') {
                                            ?>
                                            <div id="Urine" style="clear: both">
                                                <p class="group-title col-md-9">Urine AS/NZA 4308:2001/ As/NZA
                                                    4308:2008</p>
                                                <p class="group-title col-md-3"><a id="urine-pie"
                                                                                   class="btn green-meadow custom-save-img">Save
                                                        Image</a>
                                                    <a id="urine-pie-pdf" class="btn green-meadow custom-save-img">Save
                                                        PDF</a></p>
                                            </div>
                                            <?php
                                        }
                                        if ($szTestType == '' || $szTestType == 'O') {
                                            ?>
                                            <div id="oral" style="clear: both">
                                                <p class="group-title col-md-9">Oral Fluid AS 4760:2006</p>
                                                <p class="group-title col-md-3"><a id="oral-pie"
                                                                                   class="btn green-meadow custom-save-img">Save
                                                        Image</a>
                                                    <a id="oral-pie-pdf" class="btn green-meadow custom-save-img">Save
                                                        PDF</a></p>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>

    </div>

</div>
</div>
</div>
</div>
</div>
<div id="popup_box"></div>
<?php
$alcohalCat = '';
$totalAlcohalDoner = '';
$totalPositiveAlcohol = '';
$totalNegativeAlcohol = '';
$totalDonarUrine = '';
$totalPositiveUrine = '';
$totalDonarOral = '';
$totalPositiveDonarOral = '';
$totalNegativeOral = '';
if (!empty($getSosAndClientDetils)) {
    $totalPositiveDonarOralNeg = '';
    $totalPositiveUrine = '';
    $FinalTotalAlcPos = 0;
    $FinalTotalAlcNeg = 0;
    $FinalTotalUriPos = 0;
    $FinalTotalUriNeg = 0;
    $FinalTotalOrlPos = 0;
    $FinalTotalOrlNeg = 0;
    foreach ($getSosAndClientDetils as $getSosAndClientData) {
        $industryname = $this->Admin_Model->getIndustryNameByid($getSosAndClientData['industry']);
        $alcohalCat[] = $industryname['szName'];
        $totalAlcohalDoner[] = $getSosAndClientData['totalPositiveAlcohol'] + $getSosAndClientData['totalNegativeAlcohol'];
        $totalPositiveAlcohol[] = $getSosAndClientData['totalPositiveAlcohol'];
        $FinalTotalAlcPos += $getSosAndClientData['totalPositiveAlcohol'];
        $totalNegativeAlcohol[] = $getSosAndClientData['totalNegativeAlcohol'];
        $FinalTotalAlcNeg += $getSosAndClientData['totalNegativeAlcohol'];
        $totalDonarUrine[] = $getSosAndClientData['totalDonarUrine'];
        $totalPositiveUrineNeg = ($getSosAndClientData['totalDonarUrine'] - $getSosAndClientData['totalNegativeUrine']);
        $totalPositiveUrine[] = $totalPositiveUrineNeg < 0 ? 0 : $totalPositiveUrineNeg;
        $FinalTotalUriPos += $totalPositiveUrineNeg < 0 ? 0 : $totalPositiveUrineNeg;
        $totalNegativeUrine[] = $getSosAndClientData['totalNegativeUrine'];
        $FinalTotalUriNeg += $getSosAndClientData['totalNegativeUrine'];
        $totalDonarOral[] = $getSosAndClientData['totalDonarOral'];
        $totalPositiveDonarOralNeg = ($getSosAndClientData['totalDonarOral'] - $getSosAndClientData['totalNegativeOral']);
        $totalPositiveDonarOral[] = $totalPositiveDonarOralNeg < 0 ? 0 : $totalPositiveDonarOralNeg;
        $FinalTotalOrlPos += $totalPositiveDonarOralNeg < 0 ? 0 : $totalPositiveDonarOralNeg;
        $totalNegativeOral[] = $getSosAndClientData['totalNegativeOral'];
        $FinalTotalOrlNeg += $getSosAndClientData['totalNegativeOral'];
    }
    
    $alcohalCat = "'" . implode("','", $alcohalCat) . "'";
    $alcohalCat = $alcohalCat . ",'Total'";
 
    $totalAlcohalDoner = "" . implode(",", $totalAlcohalDoner) . "";
     
    $totalPositiveAlcohol = "" . implode(",", $totalPositiveAlcohol) . "";
    $totalPositiveAlcohol = $totalPositiveAlcohol . ',' . $FinalTotalAlcPos;
    $totalNegativeAlcohol = "" . implode(",", $totalNegativeAlcohol) . "";
    $totalNegativeAlcohol = $totalNegativeAlcohol . ',' . $FinalTotalAlcNeg;
    
    $totalDonarUrine = "" . implode(",", $totalDonarUrine) . "";
    $totalPositiveUrine = "" . implode(",", $totalPositiveUrine) . "";
    $totalPositiveUrine = $totalPositiveUrine . ',' . $FinalTotalUriPos;
    $totalNegativeUrine = "" . implode(",", $totalNegativeUrine) . "";
    $totalNegativeUrine = $totalNegativeUrine . ',' . $FinalTotalUriNeg;
     
    $totalDonarOral = "" . implode(",", $totalDonarOral) . "";
    $totalPositiveDonarOral = "" . implode(",", $totalPositiveDonarOral) . "";
    $totalPositiveDonarOral = $totalPositiveDonarOral . ',' . $FinalTotalOrlPos;
    $totalNegativeOral = "" . implode(",", $totalNegativeOral) . "";
    $totalNegativeOral = $totalNegativeOral . ',' . $FinalTotalOrlNeg;
    
}

?>

<script type="text/javascript">
    var testtype = '<?php echo $szTestType;?>';
    var DrugcategoriesArr = [<?php echo $alcohalCat;?>];
    var TotPosDoner = [<?php echo $totalPositiveAlcohol;?>];
    var TotNegDoner = [<?php echo $totalNegativeAlcohol;?>];
    var alcdivwidth = parseInt(100 / (DrugcategoriesArr.length < 4 ? DrugcategoriesArr.length : 3)) + '%';
    var UrTotPosDoner = [<?php echo $totalPositiveUrine;?>];
    var UrTotNegDoner = [<?php echo $totalNegativeUrine;?>];
    var OrTotPosDoner = [<?php echo $totalPositiveDonarOral;?>];
    var OrTotNegDoner = [<?php echo $totalNegativeOral;?>];
    var custchartAlc = [];
    var custchartUri = [];
    var custchartOrl = [];
    
    $(function () {
        Highcharts.getSVG = function (charts) {
            var svgArr = [],
                top = 0,
                width = 200;

            Highcharts.each(charts, function (chart) {
                var svg = chart.getSVG(),
                    // Get width/height of SVG for export
                    svgWidth = +svg.match(
                        /^<svg[^>]*width\s*=\s*\"?(\d+)\"?[^>]*>/
                    )[1],
                    svgHeight = +svg.match(
                        /^<svg[^>]*height\s*=\s*\"?(\d+)\"?[^>]*>/
                    )[1];

                svg = svg.replace(
                    '<svg',
                    '<g transform="translate(0,' + top + ')" '
                );
                svg = svg.replace('</svg>', '</g>');

                top += svgHeight;
                width = Math.max(width, svgWidth);

                svgArr.push(svg);
            });

            return '<svg height="' + top + '" width="' + width +
                '" version="1.1" xmlns="http://www.w3.org/2000/svg">' +
                svgArr.join('') + '</svg>';
        };

        /**
         * Create a global exportCharts method that takes an array of charts as an
         * argument, and exporting options as the second argument
         */
        Highcharts.exportCharts = function (charts, options) {

            // Merge the options
            options = Highcharts.merge(Highcharts.getOptions().exporting, options);

            // Post to export server
            Highcharts.post(options.url, {
                filename: options.filename || 'chart',
                type: options.type,
                width: options.width,
                svg: Highcharts.getSVG(charts)
            });
        };


        if (testtype == '' || testtype == 'A') {
            var hideA = true;
            for (var i = 0; i < DrugcategoriesArr.length; i++) {
                if (TotPosDoner[i] > 0 || TotNegDoner[i] > 0) {
                    hideA = false;
                    var $div = $("<div>", {id: "Alco" + i, "class": "inds", "width": alcdivwidth});
                    $("#alcohal").append($div);
                    custchartAlc[i] = Highcharts.chart("Alco" + i, {
                        chart: {
                            type: 'pie',
                            margin: [0, 0, 0, 0],
                            spacingTop: 10,
                            spacingBottom: 0,
                            spacingLeft: 0,
                            spacingRight: 0,
                            options3d: {
                                enabled: true,
                                alpha: 45,
                                beta: 0
                            }
                        },
                        credits: {
                            enabled: false
                        },
                        title: {
                            text: DrugcategoriesArr[i] + ' <span class="pie-title" style="font-size: 12px;">(Alcohol Test)</span>'
                        },
                        tooltip: {
                            pointFormat: '<span style="font-size:13px">{series.name}:</span> <b>{point.y}</b>'
                        },
                        colors: ['#4169E1', '#696969'],
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                depth: 40,
                                dataLabels: {
                                    distance: -60,
                                    enabled: true,
                                    format: '{point.name}: <span style="font-size:13px">{point.y}</span>'
                                }
                            }
                        },
                        series: [{
                            type: 'pie',
                            name: DrugcategoriesArr[i],
                            data: [
                                ['<span style="font-size:13px">Positive</span>', TotPosDoner[i]],
                                ['<span style="font-size:13px">Negative</span>', TotNegDoner[i]]
                            ]
                        }],
                        exporting: {
                            buttons: {
                                contextButton: {
                                    menuItems: [{
                                        text: 'Download JPEG Image',
                                        onclick: function () {
                                            this.exportChart({
                                                type: 'jpeg'
                                            });
                                        }
                                    }, {
                                        text: 'Download PNG Image',
                                        onclick: function () {
                                            this.exportChart();
                                        },
                                        separator: false
                                    }, {
                                        text: 'Download SVG Vector Image',
                                        onclick: function () {
                                            this.exportChart({
                                                type: 'image/svg+xml'
                                            });
                                        },
                                        separator: false
                                    }, {
                                        text: 'Download PDF Document',
                                        onclick: function () {
                                            this.exportChart({
                                                type: 'application/pdf'
                                            });
                                        },
                                        separator: false
                                    }]
                                }
                            }
                        }
                    });
                }
                if(hideA){
                    $('#alcohal').hide();
                }
            }
            $('#alcohol-pie').click(function () {
                Highcharts.exportCharts(custchartAlc);
            });

            $('#alcohol-pie-pdf').click(function () {
                Highcharts.exportCharts(custchartAlc, {
                    type: 'application/pdf'
                });
            });
        }
 
        if (testtype == '' || testtype == 'U') {
            var hideU = true;
            for (var i = 0; i < DrugcategoriesArr.length; i++) {
                
                if(UrTotPosDoner[i]>0 || UrTotNegDoner[i]>0) {
                    hideU = false;
                    var $div = $("<div>", {id: "uri" + i, "class": "inds", "width": alcdivwidth});
                    $("#Urine").append($div);
                    custchartUri[i] = Highcharts.chart("uri" + i, {
                        chart: {
                            type: 'pie',
                            margin: [0, 0, 0, 0],
                            spacingTop: 10,
                            spacingBottom: 0,
                            spacingLeft: 0,
                            spacingRight: 0,
                            options3d: {
                                enabled: true,
                                alpha: 45,
                                beta: 0
                            }
                        },
                        credits: {
                            enabled: false
                        },
                        title: {
                            text: DrugcategoriesArr[i] + ' <span class="pie-title" style="font-size: 12px;">(Urine Test)</span>'
                        },
                        tooltip: {
                            pointFormat: '<span style="font-size:13px">{series.name}:</span> <b>{point.y}</b>'
                        },
                        colors: ['#4169E1', '#696969'],
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                depth: 40,
                                dataLabels: {
                                    distance: -60,
                                    enabled: true,
                                    format: '{point.name}: <span style="font-size:13px">{point.y}</span>'
                                }
                            }
                        },
                        series: [{
                            type: 'pie',
                            name: DrugcategoriesArr[i],
                            data: [
                                ['<span style="font-size:13px">Positive</span>', UrTotPosDoner[i]],
                                ['<span style="font-size:13px">Negative</span>', UrTotNegDoner[i]]
                            ]
                        }],
                        exporting: {
                            buttons: {
                                contextButton: {
                                    menuItems: [{
                                        text: 'Download JPEG Image',
                                        onclick: function () {
                                            this.exportChart({
                                                type: 'jpeg'
                                            });
                                        }
                                    }, {
                                        text: 'Download PNG Image',
                                        onclick: function () {
                                            this.exportChart();
                                        },
                                        separator: false
                                    }, {
                                        text: 'Download SVG Vector Image',
                                        onclick: function () {
                                            this.exportChart({
                                                type: 'image/svg+xml'
                                            });
                                        },
                                        separator: false
                                    }, {
                                        text: 'Download PDF Document',
                                        onclick: function () {
                                            this.exportChart({
                                                type: 'application/pdf'
                                            });
                                        },
                                        separator: false
                                    }]
                                }
                            }
                        }
                    });
                }

                if(hideU){
                    $('#Urine').hide();
                }
            }
            $('#urine-pie').click(function () {
                Highcharts.exportCharts(custchartUri);
            });

            $('#urine-pie-pdf').click(function () {
                Highcharts.exportCharts(custchartUri, {
                    type: 'application/pdf'
                });
            });
        }
        if (testtype == '' || testtype == 'O') {
            var hideO = true;
            for (var i = 0; i < DrugcategoriesArr.length; i++) {
                if(OrTotPosDoner[i]>0 || OrTotNegDoner[i]>0) {
                    hideO = false;
                    var $div = $("<div>", {id: "orl" + i, "class": "inds", "width": alcdivwidth});
                    $("#oral").append($div);
                    custchartOrl[i] = Highcharts.chart("orl" + i, {
                        chart: {
                            type: 'pie',
                            margin: [0, 0, 0, 0],
                            spacingTop: 10,
                            spacingBottom: 0,
                            spacingLeft: 0,
                            spacingRight: 0,
                            options3d: {
                                enabled: true,
                                alpha: 45,
                                beta: 0
                            }
                        },
                        credits: {
                            enabled: false
                        },
                        title: {
                            text: DrugcategoriesArr[i] + ' <span class="pie-title" style="font-size: 12px;">(Oral Test)</span>'
                        },
                        tooltip: {
                            pointFormat: '<span style="font-size:13px">{series.name}:</span> <b>{point.y}</b>'
                        },
                        colors: ['#4169E1', '#696969'],
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                depth: 40,
                                dataLabels: {
                                    distance: -60,
                                    enabled: true,
                                    format: '{point.name}: <span style="font-size:13px">{point.y}</span>'
                                }
                            }
                        },
                        series: [{
                            type: 'pie',
                            name: DrugcategoriesArr[i],
                            data: [
                                ['<span style="font-size:13px">Positive</span>', OrTotPosDoner[i]],
                                ['<span style="font-size:13px">Negative</span>', OrTotNegDoner[i]]
                            ]
                        }],
                        exporting: {
                            buttons: {
                                contextButton: {
                                    menuItems: [{
                                        text: 'Download JPEG Image',
                                        onclick: function () {
                                            this.exportChart({
                                                type: 'jpeg'
                                            });
                                        }
                                    }, {
                                        text: 'Download PNG Image',
                                        onclick: function () {
                                            this.exportChart();
                                        },
                                        separator: false
                                    }, {
                                        text: 'Download SVG Vector Image',
                                        onclick: function () {
                                            this.exportChart({
                                                type: 'image/svg+xml'
                                            });
                                        },
                                        separator: false
                                    }, {
                                        text: 'Download PDF Document',
                                        onclick: function () {
                                            this.exportChart({
                                                type: 'application/pdf'
                                            });
                                        },
                                        separator: false
                                    }]
                                }
                            }
                        }
                    });
                }
                if(hideO){
                    $('#oral').hide();
                }
            }
            $('#oral-pie').click(function () {
                Highcharts.exportCharts(custchartOrl);
            });

            $('#oral-pie-pdf').click(function () {
                Highcharts.exportCharts(custchartOrl, {
                    type: 'application/pdf'
                });
            });
        }
    });
</script>
