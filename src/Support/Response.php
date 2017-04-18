<?php

namespace Gizburdt\Cuztom\Support;

Guard::directAccess();

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
        $this->response = apply_filters('cuztom_repsonse_attributes', array(
            'status'  => $status,
            'content' => $data
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
