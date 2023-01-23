<?php

class Booking
{
  function book() {
    
    if (!isset($_POST['wpsb_booking_page_nonce'])) {
      return;
    }

    if (!wp_verify_nonce($_POST['wpsb_booking_page_nonce'], 'wpsb_booking_page_nonce')) {
      return;
    }

    $attendee_email = htmlspecialchars(strip_tags($_POST['attendee_email']));
    $attendee_name = htmlspecialchars(strip_tags($_POST['attendee_name']));
    $event_start = htmlspecialchars(strip_tags($_POST['event_start']));
    $event_end = htmlspecialchars(strip_tags($_POST['event_end']));

    $expl_event_start = explode('T', $event_start);

    if ($_POST['type_of_meeting'] == 'zoom') {
      $meeting_link = get_option('_wpsb_zoom_meeting_link');

    } else if ($_POST['type_of_meeting'] == 'google_meet') {
      $meeting_link = get_option('_wpsb_gmeet_meeting_link');

    } else if ($_POST['type_of_meeting'] == 'skype') {
      $meeting_link = get_option('_wpsb_skype_meeting_link');

    } else {
      $meeting_link = 'Office';
    }

    //  Add to meetings option
    $wpsb_meetings = get_option('_wpsb_meetings');

    $meeting_details = [
      'date' => $expl_event_start[0],
      [
        'start_time' => date('m-d-Y - h:i:s A', strtotime($event_start)),
        'end_time' => date('m-d-Y - h:i:s A', strtotime($event_end)),
        'name' => $attendee_name,
        'email' => $attendee_email,
        'meeting_link' => $meeting_link
      ]
    ];

    if (!empty($wpsb_meetings) and is_array($wpsb_meetings)) {
      $wpsb_meetings[] = $meeting_details;
      update_option('_wpsb_meetings', $wpsb_meetings);
    } else {
      update_option('_wpsb_meetings', array($meeting_details));
    }

    //  Remove time from available timeslots option
    $wpsb_timeslots = get_option('_wpsb_timeslots');

    if (!empty($wpsb_timeslots) and is_array($wpsb_timeslots)) {
      
      foreach ($wpsb_timeslots as $key => $value) {

        if (str_contains($value, $event_start)) {
          unset($wpsb_timeslots[$key]);
          update_option('_wpsb_timeslots', $wpsb_timeslots);
          break;
        }
      }
    }

    //  Send email to client
    $attendee_mail_to = $attendee_email;
    $attendee_mail_subject = 'Appoinment Set';
    $attendee_mail_headers = array(
      'From: '. get_bloginfo('name') .' <'. get_bloginfo('admin_email') .'>',
      'Content-Type: text/html; charset=UTF-8'
    );
    $attendee_mail_body = 
    '<div style="background-color: #ececec; width: 100%; height: 100%; padding: 50px 20px;">
      <table style="width: 600px; margin: 0 auto;">
        <thead>
            <tr style="border: 0; background-color: #fff;">
              <td style="padding: 30px 10px 20px 10px; text-align: center;" colspan="2">
                <img style="width:100%; max-width:180px;" src="'. wp_get_attachment_image_url(get_theme_mod('custom_logo')) .'" />
              </td>
            </tr>
        </thead>
        <tbody>
          <tr style="background-color: #fff;">
            <td style="padding: 20px;" colspan="2">
              Hello '. $attendee_name .', your appoinment with us has been set.
              Please see details below:
            </td>
          </tr>
          <tr style="background-color: #fff;">
            <td style="padding: 10px 20px;">Meeting Date and Time:</td>
            <td style="padding: 10px 10px;">'. date('m-d-Y - h:i:s A', strtotime($event_start)) .' - '. date('m-d-Y - h:i:s A', strtotime($event_end)) .'</td>
          </tr>
          <tr style="background-color: #fff;">
            <td style="padding: 10px 20px; width: 200px;">Full Name:</td>
            <td style="padding: 10px 10px;">'. $attendee_name .'</td>
          </tr>
          <tr style="background-color: #fff;">
            <td style="padding: 10px 20px;">Email Address:</td>
            <td style="padding: 10px 10px;">'. $attendee_email .'</td>
          </tr>
          <tr style="background-color: #fff;">
            <td style="padding: 10px 20px;">Meeting Link:</td>
            <td style="padding: 10px 10px;">'. $meeting_link .'</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td style="text-align: center; padding: 10px; font-size: 12px; background: #FF9F1C; color: #fff;" colspan="2">'. get_bloginfo('name') .' - '. date('Y') .'</td>
          </tr>
        </tfoot>
      </table>
    </div>';
    
    wp_mail($attendee_mail_to, $attendee_mail_subject, $attendee_mail_body, $attendee_mail_headers);

    //  Send email to admin
    $admin_to = get_bloginfo('admin_email');
    $admin_subject = 'A client has set an appointment with you';
    $admin_headers = array(
      'From: '. get_bloginfo('name') .' <'. get_bloginfo('admin_email') .'>',
      'Content-Type: text/html; charset=UTF-8'
    );
    $admin_body = 
    '<div style="background-color: #ececec; width: 100%; height: 100%; padding: 50px 20px;">
      <table style="width: 600px; margin: 0 auto;">
        <thead>
            <tr style="border: 0; background-color: #fff;">
              <td style="padding: 30px 10px 20px 10px; text-align: center;" colspan="2">
                <img style="width:100%; max-width:180px;" src="'. wp_get_attachment_image_url(get_theme_mod('custom_logo')) .'" />
              </td>
            </tr>
        </thead>
        <tbody>
          <tr style="background-color: #fff;">
            <td style="padding: 20px;" colspan="2">
              Hello admin, a client has set an appointment with you.
              Please see details below:
            </td>
          </tr>
          <tr style="background-color: #fff;">
            <td style="padding: 10px 20px;">Meeting Date and Time:</td>
            <td style="padding: 10px 10px;">'. date('m-d-Y - h:i:s A', strtotime($event_start)) .' - '. date('m-d-Y - h:i:s A', strtotime($event_end)) .'</td>
          </tr>
          <tr style="background-color: #fff;">
            <td style="padding: 10px 20px; width: 200px;">Full Name:</td>
            <td style="padding: 10px 10px;">'. $attendee_name .'</td>
          </tr>
          <tr style="background-color: #fff;">
            <td style="padding: 10px 20px;">Email Address:</td>
            <td style="padding: 10px 10px;">'. $attendee_email .'</td>
          </tr>
          <tr style="background-color: #fff;">
            <td style="padding: 10px 20px;">Meeting Link:</td>
            <td style="padding: 10px 10px;">'. $meeting_link .'</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td style="text-align: center; padding: 10px; font-size: 12px; background: #FF9F1C; color: #fff;" colspan="2">'. get_bloginfo('name') .' - '. date('Y') .'</td>
          </tr>
        </tfoot>
      </table>
    </div>';
    
    wp_mail( $admin_to, $admin_subject, $admin_body, $admin_headers );

    wp_safe_redirect($_POST['return_url'] .'?success='. urlencode('Your appointment has been set. Please your check the email you entered for the details'));
    exit;
  }
}