<?php

namespace Gizburdt\Cuztom;

Guard::blockDirectAccess();

class Response
{
    /**
     * Response.
     * @var string
     */
    protected $response;

    /**
     * Constructor.
     *
     * @param  array  $status
     * @param  bool   $data
     * @return string
     */
    public function __construct($status, $data = array())
    {
        $this->response = apply_filters('cuztom_response_attributes', array(
            'status' => $status,
            'data'   => $data
        ), $this);
    }

    /**
     * Get json.
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->response);
    }
}
