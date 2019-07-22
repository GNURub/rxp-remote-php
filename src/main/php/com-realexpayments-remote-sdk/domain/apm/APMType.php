<?php


namespace com\realexpayments\remote\sdk\domain\APM;


use com\realexpayments\remote\sdk\EnumBase;

/**
 * Class ThreeDSecureType
 * Enumeration for the ThreeDSecure type.
 *
 * @package com\realexpayments\remote\sdk\domain\threeDSecure
 */
class APMType extends EnumBase{

	const __default = self::PAYMENT_SET;

	const PAYMENT_SET = "payment-set";

	const PAYMENT_CREDIT = "payment-credit";

	/**
	 * @var string The ThreeDSecure type String value
	 */
	private $type;

	/**
	 * ThreeDSecureType constructor
	 *
	 * @param string $type
	 */
	public function __construct( $type ) {
		parent::__construct( $type );

		$this->type = $type;
	}

	/**
	 * Get the string value of the ThreeDSecure type
	 *
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

}
