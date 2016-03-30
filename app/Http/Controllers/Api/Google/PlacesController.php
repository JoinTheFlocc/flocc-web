<?php

namespace Flocc\Http\Controllers\Api\Google;

use Flocc\Google\Places\Autocomplete;
use Flocc\Http\Controllers\Controller;

/**
 * Class PlacesController
 *
 * @package Flocc\Http\Controllers\Api\Google
 */
class PlacesController extends Controller
{
    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function autoComplete()
    {
        $autocomplete   = new Autocomplete();
        $keyword        = \Input::get('keyword', '');
        $result         = [];

        if(strlen($keyword) > 3) {
            $find           = $autocomplete->setInput($keyword)->get();

            foreach($find->getPredictions() as $prediction) {
                $result[$prediction->getId()] = $prediction->getDescription();
            }
        }

        return response()->json($result);
    }
}