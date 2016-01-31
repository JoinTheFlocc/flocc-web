<?php

namespace Flocc\Events;

/**
 * Class EditEvent
 *
 * @package Flocc\Events
 */
class EditEvent
{
    private $data = [];

    /**
     * Set data
     *
     * @param array $data
     *
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get validation rules
     *
     * @return array
     */
    public function getValidationRules()
    {
        $rules      = [
            'title'             => 'required',
            'description'       => 'required',
            'event_from'        => 'required',
            'event_to'          => 'required',
            'event_span'        => 'required|integer',
            'users_limit'       => 'required|integer',
            'budgets'           => 'required',
            'intensities'       => 'required',
            'fixed'             => 'required',
            'place_type'        => 'required',
            'activities'        => 'required'
        ];

        if($this->data['place_type'] == 'place') {
            $rules['place_id']  = 'required';
        } else {
            $rules['route']     = 'required';
        }

        if(isset($this->data['activities'])) {
            if(array_search('new', $this->data['activities']) !== false) {
                $rules['new_activities'] = 'required';
            }
        }

        return $rules;
    }

    /**
     * Get validation messages
     *
     * @return array
     */
    public function getValidationMessages()
    {
        return [
            'title.required'            => 'Prosimy podać tytuł wydarzenia',
            'description.required'      => 'Prosimy podać opis wydarzenia',
            'event_from.required'       => 'Prosimy podać datę od',
            'event_to.required'         => 'Prosimy podać datę do',
            'event_span.required'       => 'Prosimy podać ile dni trwa wydarzenie',
            'users_limit.required'      => 'Prosimy podać ilu osób może się zapisać',
            'budgets.required'          => 'Prosimy wybrać budżet',
            'intensities.required'      => 'Prosimy wybrać intensywność',
            'fixed.required'            => 'Prosimy wybrać typ wydarzenia',
            'place_type.required'       => 'Prosimy wybrać czy miejsce czy trasa',
            'activities.required'       => 'Prosimy wybrać min. 1 aktywność',
            'place_id.required'         => 'Prosimy wybrać miejsce wydarzenia',
            'route.required'            => 'Prosimy wybrać przynajmniej 1 punkt na trasie',
            'new_activities.required'   => 'Prosimy podać nazwę nowej aktywności',
        ];
    }
}