/*
|--------------------------------------------------------------------------
| eCommerce Overview Template
|--------------------------------------------------------------------------
*/

'use strict';

(function ($) {
  $(document).ready(function() {
	
    //
    // Users by country statistics
    //

    google.charts.load('current', {
      'packages': ['geochart'],
      'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
    });

    google.charts.setOnLoadCallback(function () {
      var data = google.visualization.arrayToDataTable([
        ['Country', 'Travelers'],
        ['Spain', 12219],
        ['United Kingdom', 11192],
        ['United States', 9291],
        ['Japan', 2291],
        ['Netherlands', 42],
        ['France', 142],
        ['Canada', 4142],
      ]);

      var options = {
        colorAxis: {
          colors: ['#ffffff', '#14CBA4']
        },
        legend: false
      };

      var chart = new google.visualization.GeoChart(document.getElementById('users-by-country-map'));

      function drawGeochart() {
        chart.draw(data, options);
      }

      drawGeochart();
      window.addEventListener('resize', drawGeochart);
    });
    
  })
  
})(jQuery);
