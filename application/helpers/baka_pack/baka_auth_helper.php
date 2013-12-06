<?php

function is_logged_in()
{
	$BAKA_auth =& get_instance()->baka_auth;

	if ( uri_string() !== 'auth/login' )
	{
		if ( ! $BAKA_auth->is_logged_in() AND ! $BAKA_auth->is_logged_in(FALSE) )
			redirect( 'auth/login' );

		else if ( $BAKA_auth->is_logged_in(FALSE) )
			redirect( 'auth/resend' );
	}
}

function is_permited( $permission )
{
	$BAKA_auth =& get_instance()->baka_auth;

	return $BAKA_auth->permit( $permission );
}