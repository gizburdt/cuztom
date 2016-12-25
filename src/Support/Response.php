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
        $this->response = json_encode(
            array_merge(
                array('status' => $status),
                $data
            )
        );
    }

    /**
     * Get json.
     *
     * @return string
     */
    public function toJson()
    {
        return $this->response;
    }
}
