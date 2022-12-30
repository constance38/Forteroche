<?php

namespace blog\config;

/**
 * Description of ContainerInterface
 *
 * @author constancelaloux
 */
interface ContainerInterface 
{
    /**
     * Returns an entry of the container by its name.
     * @param type $key
     */
    public function get(string $key): object;

    /**
     * Test if the container can provide something for the given name.
     * @param type $id
     */
    public function has(string $id): bool;
}
