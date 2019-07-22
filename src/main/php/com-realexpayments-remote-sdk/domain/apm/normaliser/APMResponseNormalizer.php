<?php


namespace com\realexpayments\remote\sdk\domain\normaliser\normaliser;


use com\realexpayments\remote\sdk\domain\APM\APMResponse;
use com\realexpayments\remote\sdk\domain\APM\BankAccount;
use com\realexpayments\remote\sdk\domain\APM\PaymentMethodDetails;
use com\realexpayments\remote\sdk\SafeArrayAccess;
use com\realexpayments\remote\sdk\utils\NormaliserHelper;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class APMResponseNormalizer extends AbstractNormalizer
{

    /**
     * Denormalizes data back into an object of the given class.
     *
     * @param mixed $data data to restore
     * @param string $class the expected class to instantiate
     * @param string $format format the given data was extracted from
     * @param array $context options available to the denormalizer
     *
     * @return object
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        $response = new APMResponse();
        $array = new SafeArrayAccess($data);

        $response->setTimeStamp($array['@timestamp']);
        $response->setMerchantId($array['merchantid']);
        $response->setAccount($array['account']);
        $response->setOrderId($array['orderid']);
        $response->setResult($array['result']);
        $response->setMessage($array['message']);
        $response->setPaymentsReference($array['pasref']);
        $response->setPaymentMethod($array['paymentmethod']);
        $response->setPaymentMethodDetails($this->denormalisePaymentMethodDetails($array));
        $response->setHash($array['sha1hash']);


        return $response;
    }

    private function denormalisePaymentMethodDetails($array)
    {
        $apmData = $array['paymentmethoddetails'];


        if (!isset($apmData) || !is_array($apmData)) {
            return null;
        }

        $data = new SafeArrayAccess($apmData);

        $paymentMethodDetails = new PaymentMethodDetails();


        $paymentMethodDetails->addAccountHoldername($data['accountholdername'])
            ->addCountry($data['country'])
            ->addReturnUrl($data['redirecturl'])
            ->addPaymentPurpose($data['paymentpurpose']);

        $apmBankAccountData = $apmData['bankaccount'];
        if (!isset($apmBankAccountData) || !is_array($apmBankAccountData)) {
            $bankAccount = new BankAccount();
            $bankAccount
                ->addIban($apmBankAccountData["iban"])
                ->addBic($apmBankAccountData['bic']);
            $paymentMethodDetails->addBankAccount($bankAccount);
        }

        return $paymentMethodDetails;
    }

    /**
     * Checks whether the given class is supported for denormalization by this normalizer.
     *
     * @param mixed $data Data to denormalize from.
     * @param string $type The class to which the data should be denormalized.
     * @param string $format The format being deserialized from.
     *
     * @return bool
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        if ($format == "xml" && $type == APMResponse::GetClassName()) {
            return true;
        }

        return false;
    }

    /**
     * Normalizes an object into a set of arrays/scalars.
     *
     * @param object $object object to normalize
     * @param string $format format the normalization result will be encoded as
     * @param array $context Context options for the normalizer
     *
     * @return array|string|bool|int|float|null
     */
    public function normalize($object, $format = null, array $context = array())
    {
        /** @var APMResponse $object */

        return array_filter(
            array(
                '@timestamp' => $object->getTimestamp(),
                'merchantid' => $object->getMerchantId(),
                'account' => $object->getAccount(),
                'orderid' => $object->getOrderId(),
                'pasref' => $object->getPaymentsReference(),
                'paymentmethod' => $object->getPaymentMethod(),
                'result' => $object->getResult(),
                'message' => $object->getMessage(),
                'paymentmethoddetails' => $this->normalisePaymentMethodDetails($object),
                'sha1hash' => $object->getHash()
            ));
    }

    private function normalisePaymentMethodDetails(APMResponse $response)
    {
        $paymentMethodDetails = $response->getPaymentMethodDetails();
        if (is_null($paymentMethodDetails)) {
            return array();
        }

        return array_filter(array(
            'bankaccount' => $this->normaliseBankAccount($response),
            'accountholdername' => $paymentMethodDetails->getAccountHoldername(),
            'country' => $paymentMethodDetails->getCountry(),
            'redirecturl' => $paymentMethodDetails->getRedirectUrl(),
            'paymentpurpose' => $paymentMethodDetails->getPaymentPurpose(),
        ), array(NormaliserHelper::GetClassName(), "filter_data"));
    }

    private function normaliseBankAccount(APMResponse $response)
    {
        $paymentMethodDetails = $response->getPaymentMethodDetails();
        if (is_null($paymentMethodDetails)) {
            return array();
        }

        $bankAccount = $response->getPaymentMethodDetails()->getBankAccount();

        if (is_null($bankAccount)) {
            return array();
        }

        return array_filter(array(
            'iban' => $bankAccount->getIban(),
            'bic' => $bankAccount->getBic()
        ), array(NormaliserHelper::GetClassName(), "filter_data"));
    }

    /**
     * Checks whether the given class is supported for normalization by this normalizer.
     *
     * @param mixed $data Data to normalize.
     * @param string $format The format being (de-)serialized from or into.
     *
     * @return bool
     */
    public function supportsNormalization($data, $format = null)
    {
        if ($format == "xml" && $data instanceof APMResponse) {
            return true;
        }

        return false;
    }


}