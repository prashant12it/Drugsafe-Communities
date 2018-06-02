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
                        <span class="active">Client Comparison Chart</span>
                    </li>
                </ul>

                <div class="portlet light bordered about-text" id="user_info">

                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-red-sunglo"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase">
                                    Client Comparison Chart
                                </span>
                        </div>

                    </div>
                    <div class="portlet-body alert">
                        <div class="row">
                            <div>

                                <div class="portlet-body">
                                    <div class="table-responsive">
                                        <div id="comparesionchart">
                                            <p class="group-title col-md-9"><?php echo $testType = ($testtype == '1' ? 'Alcohol' : ($testtype == '3' ? 'Urine AS/NZA 4308:2001' : ($testtype == '2' ? 'Oral Fluid AS 4760:2006' : ($testtype == '4' ? 'As/NZA 4308:2008' : '')))); ?></p>
                                            <p class="group-title col-md-3"><a id="comparision-pie"
                                                                               class="btn green-meadow custom-save-img">Save
                                                    Image</a>
                                                <a id="comparision-pie-pdf" class="btn green-meadow custom-save-img">Save
                                                    PDF</a></p>
                                        </div>
                                        <div id="img-out"></div>
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

if (!empty($compareresultarr)) {
    foreach ($compareresultarr as $comparisondata) {
        $comparesionCat[] = ($comparetype == 1 ? $comparisondata['month'] . ' ' . $comparisondata['year'] : $comparisondata['year']);
        $TotalDonors[] = ($testtype == '1' ? $comparisondata['totalAlcohol'] : ($testtype == '3' ? $comparisondata['totalDonarUrine'] : ($testtype == '2' ? $comparisondata['totalDonarOral'] : ($testtype == '4' ? $comparisondata['totalDonarUrine'] : '0'))));
        $Positive[] = ($testtype == '1' ? $comparisondata['totalPositiveAlcohol'] : ($testtype == '3' ? ($comparisondata['totalDonarUrine'] - $comparisondata['totalNegativeUrine']) : ($testtype == '2' ? ($comparisondata['totalDonarOral'] - $comparisondata['totalNegativeOral']) : ($testtype == '4' ? ($comparisondata['totalDonarUrine'] - $comparisondata['totalNegativeUrine']) : '0'))));
        $Negative[] = ($testtype == '1' ? $comparisondata['totalNegativeAlcohol'] : ($testtype == '3' ? $comparisondata['totalNegativeUrine'] : ($testtype == '2' ? $comparisondata['totalNegativeOral'] : ($testtype == '4' ? $comparisondata['totalNegativeUrine'] : '0'))));

    }
    $comparesionCat = "'" . implode("','", $comparesionCat) . "'";
    $TotalDonors = "" . implode(",", $TotalDonors) . "";
    $Positive = "" . implode(",", $Positive) . "";
    $Negative = "" . implode(",", $Negative) . "";

}
$testType = ($testtype == '1' ? 'Alcohol' : ($testtype == '3' ? 'Urine AS/NZA 4308:2001' : ($testtype == '2' ? 'Oral Fluid AS 4760:2006' : ($testtype == '4' ? 'As/NZA 4308:2008' : ''))));
?>
<input type="hidden" id="charttesttype" value="<?php echo $testType; ?>"/>
<script src="<?php echo __BASE_JS_URL__; ?>/html2canvas.js?<?php echo time(); ?>" rel="jquery"
        type="text/javascript"></script>
<script type="text/javascript">
    var testtype = '<?php echo $testType;?>';
    var DrugcategoriesArr = [<?php echo $comparesionCat;?>];
    var TotPosDoner = [<?php echo $Positive;?>];
    var TotNegDoner = [<?php echo $Negative;?>];
    var alcdivwidth = parseInt(100 / (DrugcategoriesArr.length < 4 ? DrugcategoriesArr.length : 3)) + '%';
    var custchart = [];
    $(function () {
        for (var i = 0; i < DrugcategoriesArr.length; i++) {
            var $div = $("<div>", {id: "Alco" + i, "class": "inds", "width": alcdivwidth});
            $("#comparesionchart").append($div);
            custchart[i] = Highcharts.chart("Alco" + i, {
                chart: {
                    type: 'pie',
                    margin: [0, 0, 0, 0],
                    spacingTop: 20,
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
                    text: DrugcategoriesArr[i] + ' <span class="pie-title" style="font-size: 12px;">(' + testtype + ')</span>'
                },
                tooltip: {
                    pointFormat: '<span style="font-size:13px">{series.name}:</span> <b>{point.y}</b>'
                },
                colors: ['#696969','#4169E1'],
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

        $('#comparision-pie').click(function () {
            Highcharts.exportCharts(custchart);
        });

        $('#comparision-pie-pdf').click(function () {
            Highcharts.exportCharts(custchart, {
                type: 'application/pdf'
            });
        });
    });
    /*setTimeout(function () {
     getDivImage('comparesionchart','comparision-pie');
     },5000);*/

</script>
