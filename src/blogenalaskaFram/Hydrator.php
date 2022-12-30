<?php

namespace blog;

/**
 * Description of Hydrator
 * @author constancelaloux
 */
trait Hydrator 
{
    public function hydrate(array $data): void
    {
        foreach ($data as $key => $value)
        {
            $method = 'set'.ucfirst($key);
            if (is_callable([$this, $method]))
            {
                $this->$method($value);
            }
        }
    }
}
