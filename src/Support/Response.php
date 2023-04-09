<?php

namespace Gizburdt\Cuztom\Support;

Guard::directAccess();

class Response
{
    /**
     * Response.
     *
     * @var string
     */
    protected $response;

    /**
     * Constructor.
     *
     * @param  array  $status
     * @param  bool  $data
     * @return string
     */
    public function __construct($status, $data = [])
    {
        $this->response = apply_filters('cuztom_repsonse_attributes', [
            'status'  => $status,
            'content' => $data,
        ], $this);
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
