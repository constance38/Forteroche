<?php

namespace blog\form;

use blog\form\Field;

/**
 * Description of TextField
 *
 * @author constancelaloux
 */
class TextField extends Field
{
    protected $cols;
    protected $rows;

    public function buildWidget(): string
    {
        $widget = '';

        if (!empty($this->errorMessage))
        {
          $widget .= $this->errorMessage.'<br />';
        }

        $widget .= '<label for="'.$this->name.'">'.$this->label.'</label><br/><div class="form-label-group"><br/><textarea name="'.$this->name.'" class="form-control form-control-sm" id="'.$this->name.'">';

        if (!empty($this->cols))
        {
          $widget .= ' cols="'.$this->cols.'"';
        }

        if (!empty($this->rows))
        {
          $widget .= ' rows="'.$this->rows.'"';
        }

        if (!empty($this->value))
        {
            $widget .= htmlspecialchars($this->value);
        }
        return $widget .= '</textarea></div>';
    }

    public function setCols(int $cols): void
    {
        $cols = (int) $cols;

        if ($cols > 0)
        {
          $this->cols = $cols;
        }
    }

    public function setRows(int $rows): void
    {
        $rows = (int) $rows;

        if ($rows > 0)
        {
          $this->rows = $rows;
        }
    }
}
