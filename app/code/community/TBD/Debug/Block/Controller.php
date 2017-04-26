<?php

/**
 * Class TBD_Debug_Block_Controller
 *
 * @category TBD
 * @package  TBD_Debug
 * @license  Copyright: Pirate TBD, 2016
 * @link     https://piratetbd.com
 */
class TBD_Debug_Block_Controller extends TBD_Debug_Block_Panel
{

    /**
     * @return TBD_Debug_Model_Controller
     */
    public function getController()
    {
        return $this->getRequestInfo()->getController();
    }

    /**
     * Returns response code from request profile or from current response
     *
     * @return int
     */
    public function getResponseCode()
    {
        return $this->getController()->getResponseCode() ?: $this->getAction()->getResponse()->getHttpResponseCode();
    }

    /**
     * Returns status color prefix for CSS based on response status code
     *
     * @return string
     */
    public function getStatusColor()
    {
        $responseCode = $this->getResponseCode();

        return $responseCode > 399 ? 'red' : ( $responseCode > 299 ? 'yellow' :  'green');
    }

}
