<?php

namespace App\Entities\Base;

use Phalcon\Mvc\Model as PhalconModel;
use Phalcon\Text;

/**
 * Class Model
 *
 * @package App\Entities\Base
 */
class Model extends PhalconModel {

    public function columnMap()
    {
        $columns = $this->getModelsMetaData()->getAttributes($this);
        $map = [];
        foreach ($columns as $column) $map[$column] = lcfirst(Text::camelize($column));
        return $map;
    }

}