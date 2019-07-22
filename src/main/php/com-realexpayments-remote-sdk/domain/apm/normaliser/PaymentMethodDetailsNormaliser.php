<?php


namespace com\realexpayments\remote\sdk\domain\payment\normaliser;


use com\realexpayments\remote\sdk\domain\APM\BankAccount;
use com\realexpayments\remote\sdk\domain\APM\PaymentMethodDetails;
use com\realexpayments\remote\sdk\utils\NormaliserHelper;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PaymentMethodDetailsNormaliser implements NormalizerInterface{

	/**
	 * Normalizes an object into a set of arrays/scalars.
	 *
	 * @param object $object object to normalize
	 * @param string $format format the normalization result will be encoded as
	 * @param array $context Context options for the normalizer
	 *
	 * @return array|string|bool|int|float|null
	 */
	public function normalize( $object, $format = null, array $context = array() ) {
		/** @var PaymentMethodDetails $object */

		return array_filter( array(
			'returnurl'   => $object->getRedirectUrl(),
			'statusupdateurl'    => $object->getStatusUpdateUrl(),
			'descriptor' => $object->getDescriptor(),
			'country' => $object->getCountry(),
			'accountholdername' => $object->getAccountHoldername(),
			'bankaccount' => $this->normaliseBankAccount($object->getBankAccount()),
		), array( NormaliserHelper::GetClassName(), "filter_data" ) );
	}

    private function normaliseBankAccount( BankAccount $bankAccount ) {
        if ( is_null( $bankAccount ) ) {
            return array();
        }

        return array_filter( array(
            'iban'     => $bankAccount->getIban(),
            'bic' => $bankAccount->getBic(),
        ), array( NormaliserHelper::GetClassName(), "filter_data" ) );
    }

	/**
	 * Checks whether the given class is supported for normalization by this normalizer.
	 *
	 * @param mixed $data Data to normalize.
	 * @param string $format The format being (de-)serialized from or into.
	 *
	 * @return bool
	 */
	public function supportsNormalization( $data, $format = null ) {
		if ( $format == "xml" && $data instanceof PaymentMethodDetails ) {
			return true;
		}

		return false;
	}
}