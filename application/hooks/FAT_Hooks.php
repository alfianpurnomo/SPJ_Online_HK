<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * HOOKS Class.
 *     hook class that load before and after the controller
 *
 * @author alfian purnomo <alfian.pacul@gmail.com>
 *
 * @version 3.0
 *
 * @category Hook
 */
class FAT_Hooks
{
    /**
     * Load Codeigniter Super Class
     * 
     * @var object
     */
    protected $CI;

    /**
     * this function is running on post constructor.
     */
    public function set_profiler()
    {
        $this->CI = &get_instance();
        $this->CI->output->enable_profiler(FALSE);
    }

    public function set_cache()
    {
        $this->CI = &get_instance();
        $this->CI->load->driver('cache',
            ['adapter' => 'file', 'backup' => 'file', 'key_prefix' => CACHE_PREFIX]
        );
    }
}

/* End of file FAT_Hooks.php */
/* Location: ./application/hooks/FAT_Hooks.php */
