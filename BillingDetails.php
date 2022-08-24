<?php
class BillingDetails {

    public static function insertDetails($conn, $agreement, $token, $username) {
        $query = $conn->prepare("INSERT INTO billingDetails (agreementId, nextBillingDate, token, username)
                                VALUES(:agreementId, :nextBillingDate, :token, :username)");
        $agreementDetails = $agreement->getAgreementDetails();

        $query->bindValue(":agreementId", $agreement->getId());
        $query->bindValue(":nextBillingDate", $agreementDetails->getNextBillingDate());
        $query->bindValue(":token", $token);
        $query->bindValue(":username", $username);

        return $query->execute();
    }
}
?>