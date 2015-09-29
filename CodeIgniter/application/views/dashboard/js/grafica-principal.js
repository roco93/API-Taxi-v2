google.load('visualization', '1', {packages: ['corechart', 'line']});
google.setOnLoadCallback(drawTrendlines);

function drawTrendlines() {
      var data = new google.visualization.DataTable();
       data.addColumn('timeofday', 'Time of Day');
      data.addColumn('number', 'Motivation Level');
      

      data.addRows([
        [{v: [8, 0, 0], f: '8 am'}, 10 ],
        [{v: [9, 0, 0], f: '9 am'}, 24 ],
        [{v: [10, 0, 0], f:'10 am'}, 12],
        [{v: [11, 0, 0], f:'10 am'}, 16],
        [{v: [12, 0, 0], f:'10 am'}, 22],
        [{v: [13, 0, 0], f:'10 am'}, 28],
        [{v: [14, 0, 0], f:'10 am'}, 25],
        [{v: [15, 0, 0], f:'10 am'}, 19],
        
      ]);

      var options = {
        hAxis: {
          title: 'Tiempo'
        },
        vAxis: {
          title: 'Viajes'
        },
        colors: ['#AB0D06', ],
   
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }