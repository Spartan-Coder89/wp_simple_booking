document.addEventListener('DOMContentLoaded', function() {

  let calendar = document.getElementById('calendar');
  let full_calendar = new FullCalendar.Calendar(calendar, {
    initialView: 'dayGridMonth',
    showNonCurrentDates: false
  });
  
  full_calendar.render();


  document.querySelectorAll('.fc-day').forEach(function(day) {
    day.addEventListener('click', function() {
      if (day.dataset.date) {

      }
    });
  });

});