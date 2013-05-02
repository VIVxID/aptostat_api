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
        $code = $e->getCode();
        $formattedErrorMsg['error']['statusCode'] = $code;
        if (!empty($code)) {
            $formattedErrorMsg['error']['statusDesc'] = \Symfony\Component\HttpFoundation\Response::$statusTexts[$code];
        }
        $formattedErrorMsg['error']['errorMessage'] = $e->getMessage();

        return $formattedErrorMsg;
    }
}