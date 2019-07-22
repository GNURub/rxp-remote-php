<?php


namespace com\realexpayments\remote\sdk\domain\APM;


use com\realexpayments\remote\sdk\domain\Amount;
use com\realexpayments\remote\sdk\domain\iRequest;
use com\realexpayments\remote\sdk\domain\payment\AutoSettle;
use com\realexpayments\remote\sdk\domain\payment\Comment;
use com\realexpayments\remote\sdk\domain\payment\CommentCollection;
use com\realexpayments\remote\sdk\utils\GenerationUtils;
use com\realexpayments\remote\sdk\utils\MessageType;
use com\realexpayments\remote\sdk\utils\XmlUtils;


/**
 * <p>
 * Class representing a APM request to be sent to Realex.
 * </p>
 * <p>
 * Helper methods are provided (prefixed with 'add') for object creation.
 * </p>
 * <p>
 * Example:
 * </p>
 * <p><code><pre>
 * $paymentmethoddetails = (new PaymentMethodDetails())
 *    ->addReturnUrl("https://www.example.com/returnUrl")
 *    ->addStatusUpdateUrl("https://www.example.com/statusUrl")
 *    ->addDescriptor("Test Transaction")
 *    ->addCountry("DE")
 *    ->addAccountHoldername("James Mason");
 *
 * $request = (new APMRequest())
 *    ->addAccount("yourAccount")
 *    ->addMerchantId("yourMerchantId")
 *    ->addType(APMType::PAYMENT_SET)
 *    ->addPaymentMethod("sofort")
 *  ->addAmount(100)
 *    ->addCurrency("EUR")
 *    ->addPaymentMethodDetails($paymentmethoddetails);
 * </pre></code></p>
 *
 *
 * @author gnurub
 * @package com\realexpayments\remote\sdk\domain\APM
 *
 */
class APMRequest implements iRequest {

	/**
	 * @var string Format of timestamp is yyyyMMddhhmmss  e.g. 20150131094559 for 31/01/2015 09:45:59.
	 * If the timestamp is more than a day (86400 seconds) away from the server time, then the request is rejected.
	 *
	 */
	private $timeStamp;

	/**
	 * @var string The APM type.
	 *
	 */
	private $type;

	/**
	 * @var string Represents Realex Payments assigned merchant id.
	 *
	 */
	private $merchantId;

	/**
	 * @var string Represents the Realex Payments subaccount to use. If this element is omitted, then the
	 * default account is used.
	 *
	 */
	private $account;

	/**
	 * @var string Represents the unique order id of this transaction. Must be unique across all of the sub-accounts.
	 *
	 */
	private $orderId;

    /**
     * @var string Represents the unique order id of this transaction. Must be unique across all of the sub-accounts.
     *
     */
    private $paymentMethod;

	/**
	 * @var Amount {@link Amount} object containing the amount value and the currency type.
	 *
	 */
	private $amount;

	/**
	 * @var string Hash constructed from the time stamp, merchand ID, order ID, amount, currency, card number
	 * and secret values.
	 *
	 */
	private $hash;

	/**
	 * @var CommentCollection List of {@link Comment} objects to be passed in request.
	 * Optionally, up to two comments can be associated with any transaction.
	 *
	 */
	private $comments;

	/**
	 * @var PaymentMethodDetails Contains payment information to be used on Receipt-in transactions
	 */
	private $paymentMethodDetails;

	/**
	 * @var AutoSettle {@link AutoSettle} object containing the auto settle flag.
	 */
	private $autoSettle;

	/**
	 * APMRequest constructor.
	 */
	public function __construct() {
	}

	public static function GetClassName() {
		return __CLASS__;
	}

	/**
	 * Getter for time stamp
	 *
	 * @return string
	 */
	public function getTimeStamp() {
		return $this->timeStamp;
	}

	/**
	 * Setter for time stamp
	 *
	 * @param string $timeStamp
	 */
	public function setTimeStamp( $timeStamp ) {
		$this->timeStamp = $timeStamp;
	}

	/**
	 * Getter for the ThreeDSecure type
	 *
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Setter for the ThreeDSecure type
	 *
	 * @param string $type
	 */
	public function setType( $type ) {
		$this->type = $type;
	}

	/**
	 * Getter for merchant Id
	 *
	 * @return string
	 */
	public function getMerchantId() {
		return $this->merchantId;
	}

	/**
	 * Setter for merchant Id
	 *
	 * @param string $merchantId
	 */
	public function setMerchantId( $merchantId ) {
		$this->merchantId = $merchantId;
	}

	/**
	 * Getter for account
	 *
	 * @return string
	 */
	public function getAccount() {
		return $this->account;
	}

	/**
	 * Setter for account
	 *
	 * @param string $account
	 */
	public function setAccount( $account ) {
		$this->account = $account;
	}

	/**
	 * Getter for order Id
	 *
	 * @return string
	 */
	public function getOrderId() {
		return $this->orderId;
	}

	/**
	 * Setter for order Id
	 *
	 * @param string $orderId
	 */
	public function setOrderId( $orderId ) {
		$this->orderId = $orderId;
	}

    /**
     * Getter for payment method
     *
     * @return string
     */
    public function getPaymentMethod() {
        return $this->orderId;
    }

    /**
     * Setter for payment method
     *
     * @param string $paymentMethod
     */
    public function setPaymentMethod( $paymentMethod ) {
        $this->paymentMethod = $paymentMethod;
    }

	/**
	 * Getter for {@link Amount}
	 *
	 * @return Amount
	 */
	public function getAmount() {
		return $this->amount;
	}

	/**
	 * Setter for {@link Amount}
	 *
	 * @param Amount $amount
	 */
	public function setAmount( $amount ) {
		$this->amount = $amount;
	}

	/**
	 * Getter for {@link PaymentMethodDetails}
	 *
	 * @return PaymentMethodDetails
	 */
	public function getPaymentMethodDetails() {
		return $this->paymentMethodDetails;
	}

	/**
	 * Setter for {@link PaymentMethodDetails}
	 *
	 * @param PaymentMethodDetails $paymentMethod
	 */
	public function setPaymentMethodDetails( $paymentMethod ) {
		$this->paymentMethodDetails = $paymentMethod;
	}

	/**
	 * Getter for hash
	 *
	 * @return string
	 */
	public function getHash() {
		return $this->hash;
	}

	/**
	 * Setter for hash
	 *
	 * @param string $hash
	 */
	public function setHash( $hash ) {
		$this->hash = $hash;
	}

	/**
	 * Getter for comments
	 *
	 * @return CommentCollection
	 */
	public function getComments() {
		return $this->comments;
	}

	/**
	 * Setter for comments
	 *
	 * @param CommentCollection $comments
	 */
	public function setComments( $comments ) {
		$this->comments = $comments;
	}

	/**
	 * Getter for autoSettle
	 *
	 * @return AutoSettle
	 */
	public function getAutoSettle() {
		return $this->autoSettle;
	}

	/**
	 * Setter for autoSettle
	 *
	 * @param AutoSettle $autoSettle
	 */
	public function setAutoSettle( $autoSettle ) {
		$this->autoSettle = $autoSettle;
	}


	/**
	 * Helper method for adding a timeStamp
	 *
	 * @param string $timeStamp
	 *
	 * @return APMRequest
	 */
	public function addTimeStamp( $timeStamp ) {
		$this->timeStamp = $timeStamp;

		return $this;
	}

	/**
	 * Helper method for adding a type
	 *
	 * @param string $type
	 *
	 * @return APMRequest
	 */
	public function addType( $type ) {
		$this->type = $type;

		return $this;
	}

	/**
	 * Helper method for adding a {@link APMType}.
	 *
	 * @param APMType $type
	 *
	 * @return APMRequest
	 */
	public function addTAPMType( APMType $type ) {
		$this->type = $type->getType();

		return $this;
	}


	/**
	 * Helper method for adding a merchantId
	 *
	 * @param string $merchantId
	 *
	 * @return APMRequest
	 */
	public function addMerchantId( $merchantId ) {
		$this->merchantId = $merchantId;

		return $this;
	}

	/**
	 * Helper method for adding a account
	 *
	 * @param string $account
	 *
	 * @return APMRequest
	 */
	public function addAccount( $account ) {
		$this->account = $account;

		return $this;
	}

	/**
	 * Helper method for adding a orderId
	 *
	 * @param string $orderId
	 *
	 * @return APMRequest
	 */
	public function addOrderId( $orderId ) {
		$this->orderId = $orderId;

		return $this;
	}

    /**
     * Helper method for adding a payment method
     *
     * @param string $paymentMethod
     *
     * @return APMRequest
     */
    public function addPaymentMethod( $paymentMethod ) {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

	/**
	 * Helper method for adding an amount. If an {@link Amount} has not been set, then one is created.
	 *
	 * @param int $amount
	 *
	 * @return APMRequest
	 */
	public function addAmount( $amount ) {
		if ( is_null( $this->amount ) ) {
			$this->amount = new Amount();
			$this->amount->addAmount( $amount );
		} else {
			$this->amount->addAmount( $amount );
		}

		return $this;
	}

	/**
	 * Helper method for adding a currency. If an {@link Amount} has not been set, then one is created.
	 *
	 * @param string $currency
	 *
	 * @return APMRequest
	 */
	public function addCurrency( $currency ) {
		if ( is_null( $this->amount ) ) {
			$this->amount = new Amount();
			$this->amount->addCurrency( $currency );
		} else {
			$this->amount->addCurrency( $currency );
		}

		return $this;
	}

	/**
	 * Helper method for adding a hash
	 *
	 * @param string $hash
	 *
	 * @return APMRequest
	 */
	public function addHash( $hash ) {
		$this->hash = $hash;

		return $this;
	}

	/**
	 * Helper method for adding a comment. NB Only 2 comments will be accepted by Realex.
	 *
	 * @param string $comment
	 *
	 * @return APMRequest
	 */
	public function addComment( $comment ) {
		if ( is_null( $this->comments ) ) {
			$this->comments = new CommentCollection();
		}

		//create new comments array list if null
		if ( is_null( $this->comments ) ) {
			$this->comments = new CommentCollection();
		}

		$size          = $this->comments->getSize();
		$commentObject = new Comment();
		$this->comments->add( $commentObject->addComment( $comment )->addId( ++ $size ) );

		return $this;
	}

	/**
	 * Helper method for adding a paymentMethodDetails
	 *
	 * @param PaymentMethodDetails $paymentMethodDetails
	 *
	 * @return APMRequest
	 */
	public function addPaymentMethodDetails( $paymentMethodDetails ) {
		$this->paymentMethodDetails = $paymentMethodDetails;

		return $this;
	}

	/**
	 * Helper method for adding a autoSettle
	 *
	 * @param AutoSettle $autoSettle
	 *
	 * @return APMRequest
	 */
	public function addAutoSettle( $autoSettle ) {
		$this->autoSettle = $autoSettle;

		return $this;
	}


	/**
	 * {@inheritDoc}
	 */
	public function toXml() {
		return XmlUtils::toXml( $this, new MessageType( MessageType::APM ) );
	}

	/**
	 * {@inheritDoc}
	 */
	public function fromXml( $xml ) {
		return XmlUtils::fromXml( $xml, new MessageType( MessageType::APM ) );
	}

	/**
	 * {@inheritDoc}
	 */
	public function generateDefaults( $secret ) {

		//generate timestamp if not set
		if ( is_null( $this->timeStamp ) ) {
			$this->timeStamp = GenerationUtils::generateTimestamp();
		}

		//generate order ID if not set
		if ( is_null( $this->orderId ) ) {
			$this->orderId = GenerationUtils::generateOrderId();
		}

		//generate hash
		$this->hash( $secret );

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function responseFromXml( $xml ) {

		$response = new APMResponse();

		return $response->fromXml( $xml );
	}

	/**
	 * Creates the security hash from a number of fields and the shared secret.
	 *
	 * @param string $secret
	 *
	 * @return $this
	 */
	public function hash( $secret ) {

		//check for any null values and set them to empty string for hashing
		$timeStamp       = null == $this->timeStamp ? "" : $this->timeStamp;
		$merchantId      = null == $this->merchantId ? "" : $this->merchantId;
		$orderId         = null == $this->orderId ? "" : $this->orderId;
		$paymentMethod   = null == $this->paymentMethod ? "" : $this->paymentMethod;
		$amount     = "";
		$currency   = "";

		if ( $this->amount != null ) {
			$amount   = null == $this->amount->getAmount() ? "" : $this->amount->getAmount();
			$currency = null == $this->amount->getCurrency() ? "" : $this->amount->getCurrency();
		}

		//create String to hash
        $toHash = $timeStamp
            . "."
            . $merchantId
            . "."
            . $orderId
            . "."
            . $amount
            . "."
            . $currency
            . "."
            . $paymentMethod;

		$this->hash = GenerationUtils::generateHash( $toHash, $secret );

		return $this;

	}
}