<?php


namespace com\realexpayments\remote\sdk\domain\APM;


/**
 * Class BankAccount
 * @package com\realexpayments\remote\sdk\domain\APM
 *
 * <p>
 * Domain object representing PaymentMethodDetails information to be passed to Realex Alternative Payment Method
 * for payment-set transactions.
 * Payment data contains the CVN number for the stored card
 * </p>
 * <p/>
 * <p><code><pre>
 * $bankAccount = ( new BankAccount() )
 *    ->addIban("DE84837473949793743749")
 *    ->addBic("GENODEF1GW1");
 * </pre></code></p>
 *
 * @author gnurub
 */
class BankAccount
{

    /**
     * @var string $iban The endpoint to which the customer should be redirected after a payment has been attempted or successfully completed on the payment scheme's site.
     */
    private $iban;
    private $bic;

    /**
     * BankAccount constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * @param string $iban
     */
    public function setIban($iban)
    {
        $this->iban = $iban;
    }

    /**
     * @param string $iban
     * @return BankAccount
     */
    public function addIban($iban)
    {
        $this->iban = $iban;

        return $this;
    }

    /**
     * @return string
     */
    public function getBic()
    {
        return $this->bic;
    }

    /**
     * @param string $bic
     */
    public function setBic($bic)
    {
        $this->bic = $bic;
    }

    /**
     * @param string $bic
     * @return BankAccount
     */
    public function addBic($bic)
    {
        $this->bic = $bic;

        return $this;
    }

    public static function GetClassName()
    {
        return __CLASS__;
    }

}