<div id="wp_simple_booking">
  <h1>Set your availabilty</h1>
  <form action="<?php echo admin_url('admin-post.php') .'?action=wpsb_timeslots'; ?>" method="POST">
    <p>Add your time</p>
    <div id="add_time">
      <input type="date" id="date">
      <div>
        <select id="time">
          <option value="1:00-2:00">01:00 AM - 02:00 AM</option>
          <option value="2:00-3:00">02:00 AM - 03:00 AM</option>
          <option value="3:00-4:00">03:00 AM - 04:00 AM</option>
          <option value="4:00-5:00">04:00 AM - 05:00 AM</option>
          <option value="5:00-6:00">05:00 AM - 06:00 AM</option>
          <option value="6:00-7:00">06:00 AM - 07:00 AM</option>
          <option value="7:00-8:00">07:00 AM - 08:00 AM</option>
          <option value="8:00-9:00">08:00 AM - 09:00 AM</option>
          <option value="9:00-10:00">09:00 AM - 10:00 AM</option>
          <option value="10:00-11:00">10:00 AM - 11:00 AM</option>
          <option value="11:00-12:00">11:00 AM - 12:00 PM</option>
          <option value="12:00-13:00">12:00 PM - 01:00 PM</option>
          <option value="13:00-14:00">01:00 PM - 02:00 PM</option>
          <option value="14:00-15:00">02:00 PM - 03:00 PM</option>
          <option value="15:00-16:00">03:00 PM - 04:00 PM</option>
          <option value="16:00-17:00">04:00 PM - 05:00 PM</option>
          <option value="17:00-18:00">05:00 PM - 06:00 PM</option>
          <option value="18:00-19:00">06:00 PM - 07:00 PM</option>
          <option value="19:00-20:00">07:00 PM - 08:00 PM</option>
          <option value="20:00-21:00">08:00 PM - 09:00 PM</option>
          <option value="21:00-22:00">09:00 PM - 10:00 PM</option>
          <option value="22:00-23:00">10:00 PM - 11:00 PM</option>
          <option value="23:00-24:00">11:00 PM - 12:00 AM</option>
        </select>
      </div>
      <button type="button" id="add_timeslot">Add</button>
    </div>
    <div id="avail_time_list">
    <?php 
      echo '<pre>';
      print_r(get_option('_wpsb_timeslots'));
      echo '</pre>';
    ?>
    </div>
    <input type="hidden" name="wpsb_admin_post_nonce" value="<?php echo wp_create_nonce('wpsb_admin_post_nonce'); ?>">
    <input type="hidden" name="redirect_url" value="<?php echo admin_url('admin.php?page='. $_GET['page']); ?>">
    <input type="submit" name="submit" value="Save">
  </form>
</div>