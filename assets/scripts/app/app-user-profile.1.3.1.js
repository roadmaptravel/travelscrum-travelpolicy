/*
|--------------------------------------------------------------------------
| Sales Overview Template
|--------------------------------------------------------------------------
*/

'use strict';

(function ($) {

  //
  // Weekly performance
  //

  if ($('.user-profile-weekly-performance').length > 0) {

  var wpData = {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [{
      label: 'Flights',
      fill: 'start',
      data: [7, 5, 2, 9, 4, 9, 11, 3, 12, 8, 4, 2],
      backgroundColor: '#2F53A4',
      borderColor: '#2F53A4',
      pointBackgroundColor: '#FFFFFF',
      pointHoverBackgroundColor: '#2F53A4',
      borderWidth: 0
    }]
  };

  var wpOptions = {
    responsive: true,
    scaleBeginsAtZero: true,
    legend: false,
    tooltips: {
      enabled: false,
      mode: 'index',
      position: 'nearest'
    },
    elements: {
      line: {
        tension: 0
      }
    },
    scales: {
      xAxes: [{
        stacked: true,
        gridLines: false
      }],
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    }
  };

  var soCtx = document.getElementsByClassName('user-profile-weekly-performance')[0];
  window.WeeklyPerformanceChart = new Chart(soCtx, {
    type: 'bar',
    data: wpData,
    options: wpOptions
  });
  
  }

  $('#userTags').tagsinput('items', {
	  typeahead: {
	    source: function(query) {
	      return $.get('https://tpt.getroadmap.com/airlines.php');
	    }
	  }
  });

})(jQuery);
