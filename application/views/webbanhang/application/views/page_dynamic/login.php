<?php

echo mystr()->get_from_template(
    $this->load->design('block/login/login.html'), 
    [
        '{{domain_name}}' => strtoupper($page_domain_name),
        '{{rdr}}' => base64_decode($data['base64_rdr'])
    ]
);