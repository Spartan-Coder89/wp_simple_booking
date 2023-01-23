<div id="wp_simple_booking">
  <h1>Set your availabilty</h1>
  <form action="<?php echo admin_url('admin-post.php') .'?action=wpsb_timeslots'; ?>" method="POST">
    <p>Your Meeting links</p>
    <div id="meeting_links">
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
    </div>
    <p>Add your time</p>
    <div id="add_time">
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
    <div id="avail_time_list">
    <?php 
      $wpsb_timeslots = get_option('_wpsb_timeslots');

      if (!empty($wpsb_timeslots) and is_array($wpsb_timeslots)) {

        foreach ($wpsb_timeslots as $key => $value) {
          
          $expl_value = explode('T', $value);
          $expl_time_value = explode('L', $expl_value[1]);

          echo '
          <div class="time" data-datetime="'. $expl_value[0] .'T'. $expl_time_value[0] .'">
            <p>'. $expl_value[0] .'</p>
            <p>'. $expl_time_value[1] .'</p>
            <input type="hidden" name="wpsb_timeslots[]" value="'. $value .'">
            <button type="button" class="remove">Remove</button>
          </div>';
        }
      }
    ?>
    </div>
    <input type="hidden" name="wpsb_admin_post_nonce" value="<?php echo wp_create_nonce('wpsb_admin_post_nonce'); ?>">
    <input type="hidden" name="redirect_url" value="<?php echo admin_url('admin.php?page='. $_GET['page']); ?>">
    <input type="submit" name="submit" value="Save">
  </form>
</div>

<?php
$wpsb_meetings = get_option('_wpsb_meetings');

echo '<pre>';
print_r($wpsb_meetings);
echo '</pre>';