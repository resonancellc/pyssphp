<?php

namespace pyssphp;

from('Hoa')
->import('String.~')
->import('String.Exception');

use \Hoa\String\Exception;

/**
 * Class \pyssphp\String
 *
 * @author Fabien Villepinte <fabien.villepinte@gmail.com>
 * @copyright Copyright © 2012 Fabien Villepinte
 * @license MIT
 */
class String extends \Hoa\String
{
    public function offsetGet($offset) {
        if (is_numeric($offset) || !preg_match('#^(?<start>-?[0-9]+)?:(?<stop>-?[0-9]+)?(:(?<step>-?[0-9]+)?)?$#', $offset, $match)) {
            return parent::offsetGet($offset);
        }

        $step = isset($match['step']) && $match['step'] !== '' ? $match['step'] : 1;

        if ($step == 0) {
            throw new Exception('slice step cannot be zero');
        } elseif ($step < 0) {
            $start = isset($match['start']) && $match['start'] !== '' ? $match['start'] : count($this) - 1;
            $stop = isset($match['stop']) && $match['stop'] !== '' ? $match['stop'] : - count($this) - 1;
        } else {
            $start = isset($match['start']) && $match['start'] !== '' ? $match['start'] : 0;
            $stop = isset($match['stop']) && $match['stop'] !== '' ? $match['stop'] : count($this);
        }

        if ($start < 0) {
            $start += count($this);
        }

        if ($stop < 0) {
            $stop += count($this);
        }

        $start = max(0, $start);

        if ($step == 1) {
            $stop = max($start, min($stop, count($this)));
            return mb_substr($this, $start, ($stop - $start));
        }

        $str = '';
        $start = min($start, count($this) - 1);
        $stop = max($stop, -1);

        if ($step < 0) {
            for ($i=$start; $i>$stop; $i+=$step) {
                $str .= parent::offsetGet($i);
            }
        } else {
            for ($i=$start; $i<$stop; $i+=$step) {
                $str .= parent::offsetGet($i);
            }
        }

        return $str;
    }
}