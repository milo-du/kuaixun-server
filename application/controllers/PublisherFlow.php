<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PublisherFlow extends BaseController
{
    function __construct()
    {
        parent::__construct();
    }

    function getList()
    {
        $this->isPublisherLogin();
    }
}