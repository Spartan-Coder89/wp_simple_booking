<div id="wp_simple_booking">
  <h1 class="wp-heading-inline">WP Simple Booking</h1>

  <div>

    <div id="tab_nav">
      <div class="tab active" data-tabcontent="meeting_links">Meeting Links</div>
      <div class="tab" data-tabcontent="add_time">Add Timeslot</div>
      <div class="tab" data-tabcontent="meetings">Meetings</div>
    </div>
    <div id="tab_container">

      <div id="meeting_links" class="tab_content active">
        <form class="set_meeting_links" action="<?php echo admin_url('admin-post.php') .'?action=wpsb_meeting_links'; ?>" method="POST">
          <p class="content_title">Your Meeting links</p>
          <div>
            <p>Zoom:</p>
            <input type="text" name="zoom_link" value="<?php echo get_option('_wpsb_zoom_meeting_link'); ?>">
          </div>
          <div>
            <p>Google Meet:</p>
            <input type="text" name="google_meet_link" value="<?php echo get_option('_wpsb_gmeet_meeting_link'); ?>">
          </div>
          <div>
            <p>Skype:</p>
            <input type="text" name="skype_link" value="<?php echo get_option('_wpsb_skype_meeting_link'); ?>">
          </div>
          <input type="submit" name="submit" value="Save">
          <input type="hidden" name="wpsb_admin_post_nonce" value="<?php echo wp_create_nonce('wpsb_admin_post_nonce'); ?>">
          <input type="hidden" name="redirect_url" value="<?php echo admin_url('admin.php?page='. $_GET['page']); ?>">
        </form>
      </div>

      <div id="add_time" class="tab_content">
        <p class="content_title">Add your time</p>
        <div class="set_your_time">
          <input type="date" id="date">
          <div>
            <select id="time">
              <option value="01:00:00-02:00:00">01:00 AM - 02:00 AM</option>
              <option value="02:00:00-03:00:00">02:00 AM - 03:00 AM</option>
              <option value="03:00:00-04:00:00">03:00 AM - 04:00 AM</option>
              <option value="04:00:00-05:00:00">04:00 AM - 05:00 AM</option>
              <option value="05:00:00-06:00:00">05:00 AM - 06:00 AM</option>
              <option value="06:00:00-07:00:00">06:00 AM - 07:00 AM</option>
              <option value="07:00:00-08:00:00">07:00 AM - 08:00 AM</option>
              <option value="08:00:00-09:00:00">08:00 AM - 09:00 AM</option>
              <option value="09:00:00-10:00:00">09:00 AM - 10:00 AM</option>
              <option value="10:00:00-11:00:00">10:00 AM - 11:00 AM</option>
              <option value="11:00:00-12:00:00">11:00 AM - 12:00 PM</option>
              <option value="12:00:00-13:00:00">12:00 PM - 01:00 PM</option>
              <option value="13:00:00-14:00:00">01:00 PM - 02:00 PM</option>
              <option value="14:00:00-15:00:00">02:00 PM - 03:00 PM</option>
              <option value="15:00:00-16:00:00">03:00 PM - 04:00 PM</option>
              <option value="16:00:00-17:00:00">04:00 PM - 05:00 PM</option>
              <option value="17:00:00-18:00:00">05:00 PM - 06:00 PM</option>
              <option value="18:00:00-19:00:00">06:00 PM - 07:00 PM</option>
              <option value="19:00:00-20:00:00">07:00 PM - 08:00 PM</option>
              <option value="20:00:00-21:00:00">08:00 PM - 09:00 PM</option>
              <option value="21:00:00-22:00:00">09:00 PM - 10:00 PM</option>
              <option value="22:00:00-23:00:00">10:00 PM - 11:00 PM</option>
              <option value="23:00:00-24:00:00">11:00 PM - 12:00 AM</option>
            </select>
          </div>
          <button type="button" id="add_timeslot">Add</button>
        </div>

        <form class="your_timeslots" action="<?php echo admin_url('admin-post.php') .'?action=wpsb_timeslots'; ?>" method="POST">
          <div id="avail_time_list">
          <?php 
            $wpsb_timeslots = get_option('_wpsb_timeslots');

            if (!empty($wpsb_timeslots) and is_array($wpsb_timeslots)) {

              foreach ($wpsb_timeslots as $key => $value) {
                
                $expl_value = explode('T', $value);
                $expl_time_value = explode('L', $expl_value[1]);

                echo '
                <div class="time" data-datetime="'. $expl_value[0] .'T'. $expl_time_value[0] .'">
                  <div>
                    <p class="meeting_date">'. $expl_value[0] .'</p>
                    <p class="meeting_time">'. $expl_time_value[1] .'</p>
                    <input type="hidden" name="wpsb_timeslots[]" value="'. $value .'">
                  </div>
                  <button type="button" class="remove">Remove</button>
                </div>';
              }
            }
          ?>
          </div>
          <input type="submit" name="submit" value="Save">
          <input type="hidden" name="wpsb_admin_post_nonce" value="<?php echo wp_create_nonce('wpsb_admin_post_nonce'); ?>">
          <input type="hidden" name="redirect_url" value="<?php echo admin_url('admin.php?page='. $_GET['page']); ?>">
        </form>
      </div>

      <div id="meetings" class="tab_content">
        <p class="content_title">Your Meetings</p>
        <div class="meeting_list">
        <?php 
          $wpsb_meetings = get_option('_wpsb_meetings');

          if (!empty($wpsb_meetings) and is_array($wpsb_meetings)) {

            foreach ($wpsb_meetings as $key => $value) {
              
              $details = $value[0];

              echo '
              <div class="meeting">
                <div class="name">
                  <p class="label">Name:</p>
                  <p class="value">'. $details['name'] .'</p>
                </div>
                <div class="email">
                  <p class="label">Email:</p>
                  <p class="value">'. $details['email'] .'</p>
                </div>
                <div class="date_time">
                  <div class="start_time">
                    <p class="label">Start Date:</p>
                    <p class="value">'. $details['start_time'] .'</p>
                  </div>
                  <div class="end_time">
                    <p class="label">End Date:</p>
                    <p class="value">'. $details['end_time'] .'</p>
                  </div>
                </div>
                <div class="meeting_link">
                  <p class="label">Meeting Link:</p>
                  <p class="value">'. $details['meeting_link'] .'</p>
                </div>
              </div>';
            }
          
          } else {
            echo '<p>No meetings listed</p>';
          }
        ?>
        </div>
      </div>

    </div>
  </div>
</div>