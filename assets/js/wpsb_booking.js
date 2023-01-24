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
  document.getElementById('calendar').addEventListener('click', function(e) {

    let target_element = e.target;

    // console.log(target_element);

    document.getElementById('event_start').value = '';
    document.getElementById('event_end').value = '';
    document.getElementById('time_available_list').innerHTML = '';

    if (target_element.dataset.date && document.getElementById('timeslots_data').value != '') {

      let date = target_element.dataset.date;
      let timeslots = JSON.parse(document.getElementById('timeslots_data').value);
      timeslots = Object.entries(timeslots);

      for (let i=0; i < timeslots.length; i++) {

        const element = timeslots[i];
        
        if (target_element.dataset.date == element[0]) {

          if (element[1].length != 0) {

            let times = element[1];

            times.forEach( function(time) {

              let time_split = time.split('L');
              let div = document.createElement('div');
              
              div.dataset.datetime = target_element.dataset.date +'T'+ time_split[0];
              div.classList.add('time');
              div.innerHTML = time_split[1];
              
              document.getElementById('time_available_list').append(div);
            });

          }

          //  Remove other selected class on other element
          if (document.querySelector('.selected')) {
            document.querySelector('.selected').classList.remove('selected');
          }

          target_element.classList.add('selected');
          break;
        }
      }
    }

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


  /**
   * Input checking
   */
  document.getElementById('booking_form').addEventListener('submit', function(e) {
    
    let input_check = document.querySelectorAll('.input_check');

    if (input_check) {

      for (let i=0; i < input_check.length; i++) {

        const input = input_check[i];
        
        if (input.value == '' && input.id == 'attendee_email') {
          alert('Email is required');
          e.preventDefault();
          break;
  
        } else if (input.value == '' && input.id == 'attendee_name') {
          alert('Fullname is required');
          e.preventDefault();
          break;
  
        } else if (input.value == '' && (input.id == 'event_start' || input.id == 'event_end')) {
          alert('Please select a date and time');
          e.preventDefault();
          break;
  
        } else {
          // Do nothing
        }
      }
    }
  });


  /**
   * Close notif and remove success url variable
   */
  if (document.getElementById('close_notif')) {
    document.getElementById('close_notif').addEventListener('click', function() {
      document.getElementById('notif').remove();
      window.history.pushState({}, '', document.getElementById('return_url').value);
    });
  }

});