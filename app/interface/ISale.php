<?php

namespace app\interface;

interface ISale {
    public function invoice($id, $data);
    public function order($id, $data);
}

?>