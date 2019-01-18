<!--===============================================================-->
<!-- Plot -->
<!--===============================================================-->
<!--Chart JavaScript-->
<script type="text/javascript"
        src="https://www.google.com/jsapi?autoload={ 'modules':[{
        'name':'visualization', 'version':'1', 'packages':['corechart', 'controls'] }] }">
</script>

<script type="text/javascript">
  google.setOnLoadCallback(drawChart);

  function drawChart() {

    // Create the data table with data for all the charts
    var data = new google.visualization.arrayToDataTable([
        <?php echo $chart_data ?>
    ]);

    // Identify the unique charts to be displayed with appropriate labels
    var columnsTable = new google.visualization.DataTable();
        columnsTable.addColumn('number', 'colIndex');
        columnsTable.addColumn('string', 'colLabel');
    var initState= {selectedValues: []};
        <?php echo $chart_column ?> 

    // Chart Options
    var chart = new google.visualization.ChartWrapper({
        chartType:    'LineChart',
        containerId:  'chart_div',
        dataTable:     data,
        options: {
          title:      '',
          curveType:  'function',
          legend:     { position: 'top' },
          chartArea:  { width: '80%', height: '80%' },
          hAxis:      { textStyle: { fontSize: '10' } },
          vAxis:      { textStyle: { fontSize: '10' } },
		  explorer: { actions: ['dragToZoom', 'rightClickToReset']}
        }
    });
    
    var columnFilter = new google.visualization.ControlWrapper({
        controlType:   'CategoryFilter',
        containerId:   'colFilter',
        dataTable:      columnsTable,
        options: {
            filterColumnLabel: 'colLabel',
            ui: {
                label:         'Chart :  ',
                allowTyping:   false,
                allowMultiple: false,
                allowNone:     false,
                sortValues:    false,
                selectedValuesLayout: 'belowStacked'
            }
        },
        state: initState
    });
    
    function setChartView () {
        var state = columnFilter.getState();
        var row;
        var view = {
            columns: [0]
        };
        for (var i = 0; i < state.selectedValues.length; i++) {
            row = columnsTable.getFilteredRows([{column: 1, value: state.selectedValues[i]}])[0];
            <?php echo $chart_views ?>
        }
        chart.setView(view);
        chart.draw();
    }
    google.visualization.events.addListener(columnFilter, 'statechange', setChartView);
    
    setChartView();
    columnFilter.draw();

  }
</script>
<div id="colFilter"></div>
<div id="chart_div"></div>
