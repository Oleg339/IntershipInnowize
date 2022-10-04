<?php

class Response
{
    private $data = [];

    public function addData($data)
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    public function send()
    {
        if (!$this->data) {
            return;
        }

        echo json_encode($this->data);
    }
}