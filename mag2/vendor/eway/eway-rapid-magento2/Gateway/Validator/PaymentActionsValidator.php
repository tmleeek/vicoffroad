<?php
namespace Eway\EwayRapid\Gateway\Validator;

use Magento\Payment\Gateway\Helper\SubjectReader;

/**
 * Class PaymentActionsValidator for Cancel and Capture commands
 */
class PaymentActionsValidator extends AbstractResponseValidator
{
    /**
     * @inheritdoc
     */
    public function validate(array $validationSubject)
    {
        $response = SubjectReader::readResponse($validationSubject);

        $errorMessages = [];
        $validationResult = $this->validateErrors($response)
            && $this->validateTransactionStatus($response)
            && $this->validateTransactionId($response)
            && $this->validateResponseMessage($response);

        if (!$validationResult) {
            $errorMessages = [__('Transaction has been declined, please, try again later.')];
        }

        return $this->createResult($validationResult, $errorMessages);
    }
}
