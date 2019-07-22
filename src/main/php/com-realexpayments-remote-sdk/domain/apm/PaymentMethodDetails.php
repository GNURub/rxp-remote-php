<?php


namespace com\realexpayments\remote\sdk\domain\APM;


/**
 * Class PaymentMethodDetails
 * @package com\realexpayments\remote\sdk\domain
 *
 * <p>
 * Domain object representing PaymentMethodDetails information to be passed to Realex Alternative Payment Method
 * for payment-set transactions.
 * Payment data contains the CVN number for the stored card
 * </p>
 * <p/>
 * <p><code><pre>
 * $paymentData = ( new PaymentData() )
 *    ->addCvnNumber("123") ;
 * </pre></code></p>
 *
 * @author gnurub
 */
class PaymentMethodDetails
{

    /**
     * @var string $returnUrl The endpoint to which the customer should be redirected after a payment has been attempted or successfully completed on the payment scheme's site.
     */
    private $returnUrl;

    /**
     * @var string $redirectUrl URL to redirect the customer to - only available in PENDING asynchronous transactions. Sent there so merchant can redirect consumer to complete an interrupted payment.
     */
    private $redirectUrl;

    /**
     * @var string $paymentPurpose This parameter reflects what the customer will see on the proof of payment (for example, bank statement record and similar). Also known as the payment descriptor
     */
    private $paymentPurpose;

    /**
     * @var string $statusUpdateUrl The endpoint which will receive payment-status messages. This will include the result of the transaction or any updates to the transaction status.  For certain asynchronous payment methods these notifications may come hours or days after the initial authorisation.
     */
    private $statusUpdateUrl;

    /**
     * @var string $descriptor Enables dynamic values to be sent for each transaction.
     */
    private $descriptor;

    /**
     * @var string $country 2 character country code, must adhere to ISO 3166-2.
     */
    private $country;

    /**
     * @var string $accountHoldername The name of the account holder
     */
    private $accountHoldername;

    /**
     * @var BankAccount $bankAccount The name of the account holder
     */
    private $bankAccount;

    /**
     * PaymentMethodDetails constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * @param string $redirectUrl
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * @return string
     */
    public function getPaymentPurpose()
    {
        return $this->paymentPurpose;
    }

    /**
     * @param string $paymentPurpose
     */
    public function setPaymentPurpose($paymentPurpose)
    {
        $this->paymentPurpose = $paymentPurpose;
    }

    /**
     * @param string $paymentPurpose
     * @return PaymentMethodDetails
     */
    public function addPaymentPurpose($paymentPurpose)
    {
        $this->paymentPurpose = $paymentPurpose;

        return $this;
    }

    /**
     * @return BankAccount
     */
    public function getBankAccount()
    {
        return $this->bankAccount;
    }

    /**
     * @param BankAccount $bankAccount
     */
    public function setBankAccount($bankAccount)
    {
        $this->bankAccount = $bankAccount;
    }

    /**
     * @param BankAccount $bankAccount
     * @return PaymentMethodDetails
     */
    public function addBankAccount($bankAccount)
    {
        $this->bankAccount = $bankAccount;

        return $this;
    }

    /**
     * @return string
     */
    public function getReturnUrl()
    {
        return $this->returnUrl;
    }

    /**
     * @param string $returnUrl
     */
    public function setReturnUrl($returnUrl)
    {
        $this->returnUrl = $returnUrl;
    }

    /**
     * @param string $returnUrl
     * @return PaymentMethodDetails
     */
    public function addReturnUrl($returnUrl)
    {
        $this->setReturnUrl($returnUrl);

        return $this;
    }

    /**
     * @return string
     */
    public function getStatusUpdateUrl()
    {
        return $this->statusUpdateUrl;
    }

    /**
     * @param string $statusUpdateUrl
     */
    public function setStatusUpdateUrl($statusUpdateUrl)
    {
        $this->statusUpdateUrl = $statusUpdateUrl;
    }

    /**
     * @param string $statusUpdateUrl
     * @return PaymentMethodDetails
     */
    public function addStatusUpdateUrl($statusUpdateUrl)
    {
        $this->setStatusUpdateUrl($statusUpdateUrl);

        return $this;
    }

    /**
     * @return string
     */
    public function getDescriptor()
    {
        return $this->descriptor;
    }

    /**
     * @param string $descriptor
     */
    public function setDescriptor($descriptor)
    {
        $this->descriptor = $descriptor;
    }

    /**
     * @param string $descriptor
     * @return PaymentMethodDetails
     */
    public function addDescriptor($descriptor)
    {
        $this->setCountry($descriptor);

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }


    /**
     * @param string $country
     * @return PaymentMethodDetails
     */
    public function addCountry($country)
    {
        $this->setCountry($country);

        return $this;
    }

    /**
     * @return string
     */
    public function getAccountHoldername()
    {
        return $this->accountHoldername;
    }

    /**
     * @param string $accountHoldername
     */
    public function setAccountHoldername($accountHoldername)
    {
        $this->accountHoldername = $accountHoldername;
    }

    /**
     * @param string $accountHoldername
     * @return PaymentMethodDetails
     */
    public function addAccountHoldername($accountHoldername)
    {
        $this->setAccountHoldername($accountHoldername);

        return $this;
    }

    public static function GetClassName()
    {
        return __CLASS__;
    }

}