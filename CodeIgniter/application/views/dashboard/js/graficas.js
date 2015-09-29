 // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          ['Álvaro Obregón', 3],
          ['Azcapotzalco', 1],
          ['Benito Juárez', 1],
          ['Coyoacán', 1],
          ['Cuauhtémoc', 2],
          ['Cuauhtémoc', 3],
          ['Iztapalapa', 4],
          ['Tláhuac', 1],
          ['Xochimilco', 5],
        ]);

        // Set chart options
        var options = {'title':'Viajes por delegaciones',
                                              };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }