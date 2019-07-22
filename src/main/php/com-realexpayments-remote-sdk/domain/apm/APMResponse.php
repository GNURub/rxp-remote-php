<?php


namespace com\realexpayments\remote\sdk\domain\APM;


use com\realexpayments\remote\sdk\domain\iResponse;
use com\realexpayments\remote\sdk\utils\GenerationUtils;
use com\realexpayments\remote\sdk\utils\MessageType;
use com\realexpayments\remote\sdk\utils\ResponseUtils;
use com\realexpayments\remote\sdk\utils\XmlUtils;


/**
 * <p>
 * Class representing a APM response received from Realex.
 * </p>
 *
 * @author vicpada
 * @package com\realexpayments\remote\sdk\domain\threeDSecure
 */
class APMResponse implements iResponse
{

    /**
     * @var string Time stamp in the format YYYYMMDDHHMMSS, which represents the time in the format year
     * month date hour minute second.
     *
     */
    private $timeStamp;

    /**
     * @var string Represents Realex Payments assigned merchant id.
     *
     */
    private $merchantId;

    /**
     * @var string Represents the Realex Payments subaccount to use. If you omit this element then
     * we will use your default account.
     *
     */
    private $account;

    /**
     * @var string Represents the unique order id of this transaction. Must be unique across all of your accounts.
     *
     */
    private $orderId;

    /**
     * @var string The result codes returned by the Realex Payments system.
     *
     */
    private $result;

    /**
     * @var string Specifies the payment method.
     *
     */
    private $paymentMethod;

    /**
     * @var PaymentMethodDetails Specifies the payment method.
     *
     */
    private $paymentMethodDetails;

    /**
     * @var string The text of the response.
     *
     */
    private $message;

    /**
     * @var string The Realex payments reference (pasref) for the transaction. Used when referencing
     * this transaction in refund and void requests.
     *
     */
    private $paymentsReference;

    /**
     * @var string The SHA-1 hash of certain elements of the response. The details of this are to be found
     * in the realauth developer's guide.
     *
     */
    private $hash;

    /**
     * APMResponse constructor.
     */
    public function __construct()
    {
    }

    public static function GetClassName()
    {
        return __CLASS__;
    }

    /**
     * Getter for timeStamp
     *
     * @return string
     */
    public function getTimeStamp()
    {
        return $this->timeStamp;
    }

    /**
     * Setter for timeStamp
     *
     * @param string $timeStamp
     */
    public function setTimeStamp($timeStamp)
    {
        $this->timeStamp = $timeStamp;
    }

    /**
     * Getter for merchantId
     *
     * @return string
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * Setter for merchantId
     *
     * @param string $merchantId
     */
    public function setMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;
    }

    /**
     * Getter for account
     *
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Setter for account
     *
     * @param string $account
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }

    /**
     * Getter for orderId
     *
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Setter for orderId
     *
     * @param string $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * Getter for result
     *
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Setter for result
     *
     * @param string $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @param string $paymentMethod
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * @return PaymentMethodDetails
     */
    public function getPaymentMethodDetails()
    {
        return $this->paymentMethodDetails;
    }

    /**
     * @param PaymentMethodDetails $paymentMethodDetails
     */
    public function setPaymentMethodDetails($paymentMethodDetails)
    {
        $this->paymentMethodDetails = $paymentMethodDetails;
    }

    /**
     * Getter for message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Setter for message
     *
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Getter for paymentsReference
     *
     * @return string
     */
    public function getPaymentsReference()
    {
        return $this->paymentsReference;
    }

    /**
     * Setter for paymentsReference
     *
     * @param string $paymentsReference
     */
    public function setPaymentsReference($paymentsReference)
    {
        $this->paymentsReference = $paymentsReference;
    }

    /**
     * Getter for hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Setter for hash
     *
     * @param string $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }


    /**
     * Helper method for adding a timeStamp
     *
     * @param string $timeStamp
     *
     * @return APMResponse
     */
    public function addTimeStamp($timeStamp)
    {
        $this->timeStamp = $timeStamp;

        return $this;
    }

    /**
     * Helper method for adding a merchantId
     *
     * @param string $merchantId
     *
     * @return APMResponse
     */
    public function addMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;

        return $this;
    }

    /**
     * @param string $paymentMethod
     * @return APMResponse
     */
    public function addPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * @param PaymentMethodDetails $paymentMethodDetails
     * @return APMResponse
     */
    public function addPaymentMethodDetails($paymentMethodDetails)
    {
        $this->paymentMethodDetails = $paymentMethodDetails;

        return $this;
    }

    /**
     * Helper method for adding a account
     *
     * @param string $account
     *
     * @return APMResponse
     */
    public function addAccount($account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Helper method for adding a orderId
     *
     * @param string $orderId
     *
     * @return APMResponse
     */
    public function addOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Helper method for adding a result
     *
     * @param string $result
     *
     * @return APMResponse
     */
    public function addResult($result)
    {
        $this->result = $result;

        return $this;
    }


    /**
     * Helper method for adding a message
     *
     * @param string $message
     *
     * @return APMResponse
     */
    public function addMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Helper method for adding a paymentsReference
     *
     * @param string $paymentsReference
     *
     * @return APMResponse
     */
    public function addPaymentsReference($paymentsReference)
    {
        $this->paymentsReference = $paymentsReference;

        return $this;
    }

    /**
     * Helper method for adding a hash
     *
     * @param string $hash
     *
     * @return APMResponse
     */
    public function addHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }


    /**
     * @{@inheritdoc}
     */
    public function fromXML($resource)
    {
        return XmlUtils::fromXml($resource, new MessageType(MessageType::APM));
    }

    /**
     * @{@inheritdoc}
     */
    public function toXML()
    {
        return XmlUtils::toXml($this, new MessageType(MessageType::APM));
    }

    /**
     * @{@inheritdoc}
     */
    public function isHashValid($secret)
    {

        $hashValid = false;

        //check for any null values and set them to empty $for hashing
        $timeStamp = null == $this->timeStamp ? "" : $this->timeStamp;
        $merchantId = null == $this->merchantId ? "" : $this->merchantId;
        $orderId = null == $this->orderId ? "" : $this->orderId;
        $result = null == $this->result ? "" : $this->result;
        $message = null == $this->message ? "" : $this->message;
        $paymentsReference = null == $this->paymentsReference ? "" : $this->paymentsReference;
        $paymentMethod = null == $this->paymentMethod ? "" : $this->paymentMethod;

        //create $to hash
        $toHash = $timeStamp
            . "."
            . $merchantId
            . "."
            . $orderId
            . "."
            . $result
            . "."
            . $message
            . "."
            . $paymentsReference
            . "."
            . $paymentMethod;

        //check if calculated hash matches returned value
        $expectedHash = GenerationUtils::generateHash($toHash, $secret);
        if ($expectedHash == $this->hash) {
            $hashValid = true;
        }

        return $hashValid;
    }

    /**
     * @{@inheritdoc}
     */
    public function isSuccess()
    {
        return ResponseUtils::isSuccess($this);
    }
}