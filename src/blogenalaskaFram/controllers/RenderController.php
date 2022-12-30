<?php

namespace blog\controllers;

use blog\controllers\AbstractController;

/**
 * Description of RenderController
 *
 * @author constancelaloux
 */
class RenderController extends AbstractController
{
    public function renderPage404(): void
    {
        $this->getRender()->render('Page404');
    }
}
