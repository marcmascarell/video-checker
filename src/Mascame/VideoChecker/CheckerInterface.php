<?php

namespace Mascame\VideoChecker;

/**
 * Interface CheckerInterface
 * @package Mascame\VideoChecker
 */
interface CheckerInterface {

    /**
     * @param $id
     * @return bool
     */
    public function check($id);

}