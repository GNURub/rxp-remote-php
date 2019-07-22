<?php


namespace com\realexpayments\remote\sdk\domain\APM\normaliser;


use com\realexpayments\remote\sdk\domain\Amount;
use com\realexpayments\remote\sdk\domain\APM\APMRequest;
use com\realexpayments\remote\sdk\domain\APM\PaymentMethodDetails;
use com\realexpayments\remote\sdk\domain\payment\AutoSettle;
use com\realexpayments\remote\sdk\domain\payment\Comment;
use com\realexpayments\remote\sdk\domain\payment\CommentCollection;
use com\realexpayments\remote\sdk\SafeArrayAccess;
use com\realexpayments\remote\sdk\utils\NormaliserHelper;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class APMRequestNormalizer extends AbstractNormalizer
{

    private $format;
    private $context;

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

        $this->format = $format;
        $this->context = $context;

        $request = new APMRequest();
        $array = new SafeArrayAccess($data);

        $request->addTimestamp($array['@timestamp'])
            ->addType($array['@type'])
            ->addMerchantId($array['merchantid'])
            ->addAccount($array['account'])
            ->addOrderId($array['orderid'])
            ->addPaymentMethod($array['paymentmethod'])
            ->addHash($array['sha1hash']);


        $request->addPaymentMethodDetails($this->denormalisePaymentMethodDetails($array));
        $request->setAutoSettle($this->denormaliseAutoSettle($array));

        $request->setAmount($this->denormaliseAmount($array));
        $request->setComments($this->denormaliseComments($array));

        return $request;
    }

    private function denormaliseAmount(\ArrayAccess $array)
    {
        return $this->serializer->denormalize($array['amount'], Amount::GetClassName(), $this->format, $this->context);
    }

    private function denormalisePaymentMethodDetails(\ArrayAccess $array)
    {
        return $this->serializer->denormalize($array['paymentmethoddetails'], PaymentMethodDetails::GetClassName(), $this->format, $this->context);
    }

    private function denormaliseComments(\ArrayAccess $array)
    {
        $comments = $array['comments'];

        if (!isset($comments)) {
            return null;
        }

        $comments = new SafeArrayAccess($comments);

        $comments = $comments['comment'];

        if (!isset($comments) || !is_array($comments)) {
            return null;
        }

        $commentCollection = new CommentCollection();

        foreach ($comments as $comment) {
            $commentObject = new Comment();
            $commentObject->addId($comment["@id"])
                ->addComment($comment["#"]);

            $commentCollection->add($commentObject);
        }

        return $commentCollection;
    }

    private function denormaliseAutoSettle($array)
    {

        return $this->serializer->denormalize($array['autosettle'], AutoSettle::GetClassName(), $this->format, $this->context);
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
        if ($format == "xml" && $type == APMRequest::GetClassName()) {
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
        /** @var APMRequest $object */

        $hasComments = true;
        $comments = $object->getComments();
        if (is_null($comments) || $comments->getSize() == 0) {
            $hasComments = false;
        } else {
            $comments = $comments->getComments();
        }


        return array_filter(array(
            '@timestamp' => $object->getTimestamp(),
            '@type' => $object->getType(),
            'merchantid' => $object->getMerchantId(),
            'account' => $object->getAccount(),
            'orderid' => $object->getOrderId(),
            'amount' => $object->getAmount(),
            'sha1hash' => $object->getHash(),
            'comments' => $hasComments ? array('comment' => $comments) : array(),
            'paymentmethod' => $object->getPaymentMethod(),
            'paymentmethoddetails' => $object->getPaymentMethodDetails(),
            'autosettle' => $object->getAutoSettle()
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
        if ($format == "xml" && $data instanceof APMRequest) {
            return true;
        }

        return false;
    }
}