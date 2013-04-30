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
        $formattedErrorMsg['error']['statusCode'] = $e->getCode();
        $formattedErrorMsg['error']['statusDesc'] = \Symfony\Component\HttpFoundation\Response::$statusTexts[$e->getCode()];
        $formattedErrorMsg['error']['errorMessage'] = $e->getMessage();

        return $formattedErrorMsg;
    }
}