<?php
namespace App\Infrastructure\Adapters;

use Digbang\Security\Users\User;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Mail\Message;

class BackofficeMailer
{
	/**
	 * @var \Illuminate\Contracts\Mail\Mailer
	 */
	protected $mailer;

	/**
	 * @var \Illuminate\Config\Repository
	 */
	protected $config;

	/**
	 * @param Mailer     $mailer
	 * @param Repository $config
	 */
	public function __construct(Mailer $mailer, Repository $config)
	{
		$this->mailer = $mailer;
		$this->config = $config;
	}

	/**
	 * @param User   $user
	 * @param string $link
	 */
	public function sendPasswordReset(User $user, $link)
	{
		$this->send('backoffice::emails.reset-password', $user, $link, trans(
			'backoffice::emails.reset-password.subject'
		));
	}

	/**
	 * @param User   $user
	 * @param string $link
	 */
	public function sendActivation(User $user, $link)
	{
		$this->send('backoffice::emails.activation', $user, $link, trans(
			'backoffice::emails.activation.subject'
		));
	}

	/**
	 * @param string $view
	 * @param User   $user
	 * @param string $link
	 * @param string $subject
	 */
	protected function send($view, User $user, $link, $subject)
	{
		$from = $this->config->get('backoffice.emails');

		$name = $user->getName() ?: $user->getUsername();

		$this->mailer->send($view, ['name' => $name, 'link' => $link], function (Message $message) use ($user, $from, $subject, $name){
			$message
				->from($from['address'], $from['name'])
				->to($user->getEmail(), $name)
				->subject($subject);
		});
	}
}