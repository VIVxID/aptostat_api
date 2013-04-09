<?php


namespace aptostatApi\Service;

class ErrorService
{
    /**
     * @param $e
     * @return array
     */
    public static function errorResponse($e)
    {
        $formattedErrorMsg = array();

        $formattedErrorMsg['error']['statusCode'] = $e->getCode();
        $formattedErrorMsg['error']['statusDesc'] = \Symfony\Component\HttpFoundation\Response::$statusTexts[$statusCode];
        $formattedErrorMsg['error']['errorMessage'] = $e->getMessage();

        return $formattedErrorMsg;
    }
}