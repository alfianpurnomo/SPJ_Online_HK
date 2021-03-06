<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Router Class Extension.
 *      extended of router class
 *
 * @author alfian purnomo <alfian.pacul@gmail.com>
 *
 * @version 3.0
 *
 * @category Core
 */
class FAT_Router extends CI_Router
{
    /**
     * Class Contructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Set routes to lowercaser.
     *
     * @return string routes
     */
    public function _parse_routes()
    {
        foreach ($this->uri->segments as &$segment) {
            $segment = strtolower($segment);
        }

        return parent::_parse_routes();
    }
}
/* End of file FAT_Router.php */
/* Location: ./application/core/FAT_Router.php */
