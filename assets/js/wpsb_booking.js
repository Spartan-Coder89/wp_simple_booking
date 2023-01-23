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

    let request = new XMLHttpRequest;
    let url = 'https://wp-staging.simonjiloma.com/wp-json/wpsb_booking/v1/timeslots/';

    request.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {

        console.log(this.responseText);

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

      document.getElementById('event_start').value = '';
      document.getElementById('event_end').value = '';
      document.getElementById('time_available_list').innerHTML = '';

      if (day.dataset.date && document.getElementById('timeslots_data').value != '') {

        let date = day.dataset.date;
        let timeslots = JSON.parse(document.getElementById('timeslots_data').value);
        timeslots = Object.entries(timeslots);

        for (let i=0; i <= timeslots.length; i++) {

          const element = timeslots[i];
          
          if (day.dataset.date == element[0]) {

            if (element[1].length != 0) {

              let times = element[1];

              times.forEach( function(time) {
  
                let time_split = time.split('L');
                let div = document.createElement('div');
                
                div.dataset.datetime = day.dataset.date +'T'+ time_split[0];
                div.classList.add('time');
                div.innerHTML = time_split[1];
                
                document.getElementById('time_available_list').append(div);
              });

            }
          }
        }
      }
    });
  });


  /**
   * Update hidden inputs on time selection
   */
  document.getElementById('time_available_list').addEventListener('click', function(e) {

    let target_element = e.target;

    if (target_element.classList.contains('time')) {

      let datetime = target_element.dataset.datetime;
      let datetime_split = datetime.split('T');
      let time = datetime_split[1];
      let time_split = time.split('-');
  
      document.getElementById('event_start').value = datetime_split[0] +'T'+ time_split[0];
      document.getElementById('event_end').value = datetime_split[0] +'T'+ time_split[1];

      document.querySelectorAll('#time_available_list .time').forEach( function(time_button) {
        time_button.classList.remove('active');
      });

      target_element.classList.add('active');
    }
  });


  /**
   * Empty time_available_list child nodes and event_start and event_end element
   */
  function fc_nav_events(nav_element) {
    
    nav_element.addEventListener('click', function() {
      document.getElementById('time_available_list').innerHTML = '';
      document.getElementById('event_start').value = '';
      document.getElementById('event_end').value = '';
    });
  }

  fc_nav_events(document.querySelector('.fc-prev-button'));
  fc_nav_events(document.querySelector('.fc-next-button'));
});