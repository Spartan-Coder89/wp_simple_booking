document.addEventListener('DOMContentLoaded', function() {

  /**
   * Remove timeslot from available list
   */
  document.getElementById('avail_time_list').addEventListener('click', function(e) {
    
    let target_element = e.target;
    if (target_element.classList.contains('remove')) {
      target_element.parentElement.remove();
    }
  });

  /**
   * Add timeslot to available time list
   */
  document.getElementById('add_timeslot').addEventListener('click', function() {
    
    let date = document.getElementById('date').value;
    let time = document.getElementById('time').value;
    let time_text = document.getElementById('time').options[document.getElementById('time').selectedIndex].text;

    //  Helper function to check for duplicate timeslot
    function is_duplicate(date, time) {

      let return_value = false;
      
      if (document.querySelector('.time')) {

        let timeslots = document.querySelectorAll('.time');

        for (let i = 0; i < timeslots.length; i++) {
          const element = timeslots[i];
          if (element.dataset.datetime == date +'T'+ time) {
            return_value = true;
            break;
          }
        }
      }

      return return_value;
    }

    if (date && time && is_duplicate(date, time) == false) {
  
      let div = document.createElement('div');
      div.classList.add('time');
      div.dataset.datetime = date +'T'+ time;
      div.innerHTML =
      '<div>' +
        '<p class="meeting_date">'+ date +'</p>' +
        '<p class="meeting_time">'+ time_text +'</p>' +
      '</div>' +
      '<input type="hidden" name="wpsb_timeslots[]" value="'+ date +'T'+ time +'L'+ time_text +'">' +
      '<button type="button" class="remove">Remove</button>';
  
      document.getElementById('avail_time_list').append(div);
    }
  });

  /**
   * Toggle tabs
   */
  document.querySelectorAll('#tab_nav .tab').forEach( function(tab) {

    tab.addEventListener('click', function() {

      //  Remove all active class on .tabcontent element
      document.querySelectorAll('#tab_container .tab_content').forEach( function(tab_content) {
        if (tab_content.classList.contains('active')) {
          tab_content.classList.remove('active');
        }
      });

      //  Remove all active class on .tab element
      document.querySelectorAll('#tab_nav .tab').forEach( function(tab) {
        if (tab.classList.contains('active')) {
          tab.classList.remove('active');
        }
      });

      tab.classList.add('active');
      document.getElementById(tab.dataset.tabcontent).classList.add('active');
    });
  });

});