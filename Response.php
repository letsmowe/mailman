<?php

/**
 * Created by PhpStorm.
 * User: eduardo
 * Date: 22/01/16
 * Time: 12:24
 */
class Response {

	public $sent;

	protected $mailer;

	/**
	 * Response constructor.
	 * @param $get {array}
	 * @param $mailer {PHPMailer}
	 * @internal param bool $sent
	 */
	public function __construct($get, $mailer)
	{
		$this->mailer = $mailer;
	}

	/**
	 * @param mixed $sent
	 */
	public function setSent($sent)
	{
		$this->sent = $sent;
	}

	/**
	 * @return string
	 */
	public function toJSON()
	{
		return json_encode($this);
	}

}