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
     * @param array $post
     *
     * @return array
     */
    public function getValidationRules(array $post)
    {
        $rules      = [
            'title'             => 'required',
            'description'       => 'required',
            'event_from'        => 'required|date_format:Y-m-d|after:tomorrow',
            'event_to'          => 'required|date_format:Y-m-d',
            'event_span'        => 'required|integer|min:1',
            'users_limit'       => 'required|integer|min:1',
            'budgets'           => 'required',
            'intensities'       => 'required',
            'fixed'             => 'required',
            'place_type'        => 'required',
            'activities'        => 'required',
            'photo'             => 'max:10000'
        ];

        if(isset($this->data['place_type'])) {
            if($this->data['place_type'] == 'place') {
                $rules['place_id']  = 'required';
            } else {
                $rules['route']     = 'required';
            }
        }

        if(isset($this->data['activities'])) {
            if(array_search('new', $this->data['activities']) !== false) {
                $rules['new_activities'] = 'required';
            }
        }

        $valid_event_from   = date_parse_from_format('Y-m-d', $post['event_from']);
        $valid_event_to     = date_parse_from_format('Y-m-d', $post['event_to']);

        if(count($valid_event_from['errors']) == 0 and count($valid_event_to['errors']) == 0) {
            $date1                   = new \DateTime($post['event_from']);
            $date2                   = new \DateTime($post['event_to']);

            $days                    = (int) $date2->diff($date1)->format("%a")+1;
            $rules['event_span']    .= '|max:' . $days;

            if($post['event_from'] !== $post['event_to']) {
                $rules['event_to'] .= '|after:event_from';
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
            'event_from.date_format'    => 'Data musi być w formacie YYYY-MM-DD',
            'event_from.after'          => 'Data startu musi być późniejsza niż dzisiaj',
            'event_to.required'         => 'Prosimy podać datę do',
            'event_to.date_format'      => 'Data musi być w formacie YYYY-MM-DD',
            'event_to.after'            => 'Data zakończenia musi być późniejsza niż data rozpoczęcia',
            'event_span.required'       => 'Prosimy podać ile dni trwa wydarzenie',
            'event_span.min'            => 'Ilość dni musi być większa od 0',
            'event_span.max'            => 'Ilość dni nie może być większa niż podany zakres dat',
            'users_limit.required'      => 'Prosimy podać ilu osób może się zapisać',
            'users_limit.min'           => 'Limit członków musi być większy od 0',
            'budgets.required'          => 'Prosimy wybrać budżet',
            'intensities.required'      => 'Prosimy wybrać intensywność',
            'fixed.required'            => 'Prosimy wybrać typ wydarzenia',
            'place_type.required'       => 'Prosimy wybrać czy miejsce czy trasa',
            'activities.required'       => 'Prosimy wybrać min. 1 aktywność',
            'place_id.required'         => 'Prosimy wybrać miejsce wydarzenia',
            'route.required'            => 'Prosimy wybrać przynajmniej 1 punkt na trasie',
            'new_activities.required'   => 'Prosimy podać nazwę nowej aktywności',
            'photo.size'                => 'Wybrany obrazek jest za duży'
        ];
    }
}