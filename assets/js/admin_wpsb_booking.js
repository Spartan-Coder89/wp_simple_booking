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
      '<p>'+ date +'</p>' +
      '<p>'+ time_text +'</p>' +
      '<input type="hidden" name="wpsb_timeslots[]" value="'+ date +'T'+ time +'L'+ time_text +'">' +
      '<button type="button" class="remove">Remove</button>';
  
      document.getElementById('avail_time_list').append(div);
    }
  });

});