document.addEventListener('DOMContentLoaded', function() {

  /**
   * Display fullcalendar
   */
  let calendar = document.getElementById('calendar');
  let full_calendar = new FullCalendar.Calendar(calendar, {
    initialView: 'dayGridMonth',
    showNonCurrentDates: false
  });
  
  full_calendar.render();

  /**
   * Retrieve timeslots data on page load
   */
  function get_timeslots_data() {

    let data = null;
    let wpsb_booking_page_nonce = document.getElementById('wpsb_booking_page_nonce').value;

    let request = new XMLHttpRequest;
    let url = 'https://wp-staging.simonjiloma.com/wp-json/wpsb_booking/v1/timeslots/?wpsb_booking_page_nonce='+ wpsb_booking_page_nonce;

    request.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById('timeslots_data').value = this.responseText;
      }
    }

    request.open('GET', url);
    request.send();

    return data;
  }
  
  get_timeslots_data();


  /**
   * Update timeslots on date selection
   */
  document.querySelectorAll('.fc-day-future').forEach(function(day) {

    day.addEventListener('click', function() {

      if (day.dataset.date) {

        let date = day.dataset.date;
        let timeslots = JSON.parse(document.getElementById('timeslots_data').value);
        timeslots = Object.keys(timeslots)

        //  Do assignment of date on timeslots in the frontend
      }
    });
  });

});