<?php
namespace Think;


class Instance extends Model{

    /**
     * Instance constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->db(100, $config);
    }
}