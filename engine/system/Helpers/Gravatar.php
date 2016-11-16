<?php
	/**
	 * Class provides connection with Gravatar service
	 */
	class Gravatar
	{
		/**
		 * Directory where all avatars are stored in
		 */
		protected $avatar_root = 'https://www.gravatar.com/avatar/';
		
		/**
		 * HTML code for image presentation
		 */
		protected $html_tpl = '<img src="{URL}">';
		
		/**
		 * Get full URL to avatar by e-mail
		 */
		public function getAvatarUrl($email, $size=100)
		{
			return $this->avatar_root . $this->getHash($email) . '?s=' . $size . '&d=mm&r=g';
		}
		
		/**
		 * Get HTML code using template
		 * @see Gravatar::html_tpl
		 */
		public function getAvatarHtml()
		{
			return str_replace('{URL}', call_user_func_array([$this, 'getAvatarUrl'], func_get_args()), $this->html_tpl);
		}
		
		/**
		 * Convert e-mail into avatar string
		 */
		public function getHash($email)
		{
			return md5(strtolower(trim($email)));
		}
	}