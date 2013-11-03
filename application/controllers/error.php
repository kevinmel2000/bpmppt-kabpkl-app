<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends BAKA_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index( $page = '' )
	{
		$this->notice( $page );
	}

	public function e404()
	{
		$this->data['heading'] = $this->baka_theme->set_title('404 Halaman tidak ditemukan');
		$this->data['message'] = '';

		log_message('error', '404 Page Not Found --> '.current_url());

		$this->baka_theme->load('errors/error_view', $this->data);
	}

	public function notice( $page = '' )
	{
		switch( $page )
		{	
			// Registration
			case '404':
				$page_title		= '404 Halaman tidak ditemukan';
				$page_message	= 'The page you requested was not found.';
				break;

			// Registration
			case 'registration-success':
				$page_title		= 'Successful Registration';
				$page_message	= 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim, at animi error porro alias nesciunt rem explicabo a vitae voluptas officiis sint delectus blanditiis repellat velit voluptatum natus dolor amet! ';
				break;
			case 'registration-disabled':
				$page_title		= 'Registration Disabled';
				$page_message	= 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis, suscipit, dicta sint tempore accusantium unde assumenda autem fugiat adipisci molestiae sequi praesentium soluta consequatur facilis similique blanditiis non et perferendis. ';
				break;

			// Activation
			case 'activation-sent':
				$page_title		= 'Activation Email Sent';
				$page_message	= 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, distinctio, accusamus, aut repellendus odio numquam est quos incidunt quaerat magni facere labore mollitia qui natus asperiores beatae quas sed ut. ';
				break;
			case 'activation-complete':
				$page_title		= 'Activation Complete';
				$page_message	= 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus, voluptates, laboriosam, in, quae quos excepturi nobis non aperiam tempora labore reiciendis temporibus a rem eos explicabo? Distinctio voluptatibus voluptas recusandae. ';
				break;
			case 'activation-failed':
				$page_title		= 'Activation Failed';
				$page_message	= 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Modi voluptatem facere repudiandae aliquam saepe. Quidem, omnis, cum excepturi autem alias iusto fugit ea similique ad sed necessitatibus veniam odit laboriosam. ';
				break;

			// Password
			case 'password-changed':
				$page_title		= 'Password Changed';
				$page_message	= 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quas, rem, expedita, error excepturi a quis velit sunt tempore omnis illum quisquam facilis. Veritatis, aspernatur, fugit voluptatibus eum alias est aliquam! ';
				break;
			case 'password-sent':
				$page_title		= 'New Password Sent';
				$page_message	= 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repudiandae, repellat, quidem, accusantium cupiditate alias corrupti deleniti tempora aliquid impedit vel rem porro sapiente pariatur nesciunt doloribus dolores harum? Doloribus, magnam! ';
				break;
			case 'password-reset':
				$page_title		= 'Password Reset';
				$page_message	= 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Earum, quidem, ad vel rerum dolorem alias consequatur dolorum quisquam voluptatibus officiis excepturi neque optio ea reiciendis temporibus nemo dignissimos voluptas unde. ';
				break;
			case 'password-failed':
				$page_title		= 'Password Failed';
				$page_message	= 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis, accusamus, vitae, voluptates ea nostrum maxime tenetur dolores cupiditate perspiciatis perferendis nobis facere accusantium totam incidunt optio. Repudiandae id beatae praesentium. ';
				break;

			// Email
			case 'email-sent':
				$page_title		= 'Confirmation Email Sent';
				$page_message	= 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nemo, voluptatum, voluptatibus mollitia ex blanditiis obcaecati debitis laudantium odio ipsam aut rem minima quod tenetur nostrum quisquam facilis voluptatem architecto fuga. ';
				break;
			case 'email-activated':
				$page_title		= 'Your Email has been Activated';
				$page_message	= 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sint, minus dignissimos ipsa consequuntur praesentium dolor qui placeat doloremque reprehenderit voluptatum neque fuga facilis accusantium velit laborum eveniet asperiores quod id. ';
				break;
			case 'email-failed':
				$page_title		= 'Email Sending Failed';
				$page_message	= 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qui, vel, ratione, accusamus, ex similique iste dolores officiis recusandae omnis quas odit debitis quaerat sit magnam numquam consequuntur deserunt? Autem, repudiandae. ';
				break;

			// User + Account
			case 'user-banned':
				$page_title		= 'You have been Banned.';
				$page_message	= 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio, similique vitae deleniti iure natus beatae dolorum minus officia maxime libero possimus praesentium quos atque aperiam recusandae unde velit culpa assumenda. ';
				break;
			case 'user-deleted':
				$page_title		= 'Your account has been Deleted.';
				$page_message	= 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste, reprehenderit, commodi, mollitia nemo sequi esse consectetur vitae tenetur autem minus alias deleniti saepe et tempore cum sunt at dolorem iure! ';
				break;
			case 'acct-unapproved':
				$page_title		= 'Account not yet Approved';
				$page_message	= 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, sit quo laborum perspiciatis magnam placeat fugiat sed eligendi ipsa dolorem. Quo, in minus sint delectus necessitatibus alias nesciunt incidunt natus? ';
				break;
			case 'logout-success':
				$page_title		= 'Logged Out';
				$page_message	= 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere commodi amet odit velit obcaecati ullam accusantium quia minima! Voluptatibus mollitia tempora veniam nihil quos quis explicabo quia deserunt asperiores cupiditate. ';
				break;

			default:
				redirect('dashboard');
				break;
		}

		$this->data['panel_title']	= $this->baka_theme->set_title( $page_title );
		$this->data['panel_body']	= $page_message;

		$this->baka_theme->load('pages/notice', $this->data);
	}
}

/* End of file error.php */
/* Location: ./application/controllers/error.php */