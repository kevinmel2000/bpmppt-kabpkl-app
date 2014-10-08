<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;">Your new email address on <?php echo get_app_config('skpd_name') ?></h2>
You have changed your email address for <?php echo get_app_config('skpd_name') ?>.<br/>
Follow this link to confirm your new email address:<br/>
<br/>
<big style="font: 16px/18px Arial, Helvetica, sans-serif;"><b><a href="<?php echo site_url('/auth/reset_email/'.$user_id.'/'.$new_email_key); ?>" style="color: #3366cc;">Confirm your new email</a></b></big><br/>
<br/>
Link doesn't work? Copy the following link to your browser address bar:<br/>
<nobr><a href="<?php echo site_url('/auth/reset_email/'.$user_id.'/'.$new_email_key); ?>" style="color: #3366cc;"><?php echo site_url('/auth/reset_email/'.$user_id.'/'.$new_email_key); ?></a></nobr><br/>
<br/>
<br/>
Your email address: <?php echo $new_email; ?><br/>
<br/>
<br/>
You received this email, because it was requested by a <a href="<?php echo site_url(''); ?>" style="color: #3366cc;"><?php echo get_app_config('skpd_name') ?></a> user. If you have received this by mistake, please DO NOT click the confirmation link, and simply delete this email. After a short time, the request will be removed from the system.<br/>
