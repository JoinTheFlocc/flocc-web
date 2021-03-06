<?php

namespace Flocc;

use Flocc\Events\Events;
use Flocc\Profile\TimeLine\TimeLine;
use Flocc\User\Features;
use Flocc\User\FreeTime;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';
    protected $fillable = ['firstname', 'lastname', 'description', 'avatar_url', 'status', 'user_id', 'partying_id', 'alcohol_id', 'smoking_id', 'imprecation_id', 'plannings_id', 'plans_id'];

    // FIXME: user_id should be protected, but Eloquent won't let constrained INSERT
    //protected $hidden = ['user_id'];

    /**
     * Get profile ID
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get user ID
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Get user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getUser()
    {
        return $this->belongsTo('Flocc\User', 'user_id');
    }

    /**
     * Get first name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstname;
    }

    /**
     * Get last name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastname;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get avatar URL
     *
     * @return string
     */
    public function getAvatarUrl()
    {   if (empty($this->avatar_url)) {
            return 'http://a.deviantart.net/avatars/a/v/avatar239.jpg?2'; //$this->avatar_url;
        } else {
            return $this->avatar_url;
        }
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get user time line
     *
     * @return \Flocc\Profile\TimeLine\TimeLine
     */
    public function getTimeLine()
    {
        return new TimeLine($this->getUserId());
    }

    /**
     * @param int $partying_id
     *
     * @return $this
     */
    public function setPartyingId($partying_id)
    {
        $this->partying_id = $partying_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getPartyingId()
    {
        return $this->partying_id;
    }

    /**
     * @return \Flocc\Profile\Partying
     */
    public function getPartying()
    {
        return $this->hasOne('Flocc\Profile\Partying', 'id', 'partying_id')->first();
    }

    /**
     * @param int $alcohol_id
     *
     * @return $this
     */
    public function setAlcoholId($alcohol_id)
    {
        $this->alcohol_id = $alcohol_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getAlcoholId()
    {
        return $this->alcohol_id;
    }

    /**
     * @return \Flocc\Profile\Alcohol
     */
    public function getAlcohol()
    {
        return $this->hasOne('Flocc\Profile\Alcohol', 'id', 'alcohol_id')->first();
    }

    /**
     * @param int $smoking_id
     *
     * @return $this
     */
    public function setSmokingId($smoking_id)
    {
        $this->smoking_id = $smoking_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getSmokingId()
    {
        return $this->smoking_id;
    }

    /**
     * @return \Flocc\Profile\Smoking
     */
    public function getSmoking()
    {
        return $this->hasOne('Flocc\Profile\Smoking', 'id', 'smoking_id')->first();
    }

    /**
     * @param int $imprecation_id
     *
     * @return $this
     */
    public function setImprecationId($imprecation_id)
    {
        $this->imprecation_id = $imprecation_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getImprecationId()
    {
        return $this->imprecation_id;
    }

    /**
     * @return \Flocc\Profile\Imprecation
     */
    public function getImprecation()
    {
        return $this->hasOne('Flocc\Profile\Imprecation', 'id', 'imprecation_id')->first();
    }

    /**
     * @param int $plannings_id
     *
     * @return $this
     */
    public function setPlanningsId($plannings_id)
    {
        $this->plannings_id = $plannings_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getPlanningsId()
    {
        return $this->plannings_id;
    }

    /**
     * @return Flocc\Profile\Plannings
     */
    public function getPlannings()
    {
        return $this->hasOne('Flocc\Profile\Plannings', 'id', 'plannings_id')->first();
    }

    /**
     * @param int $plans_id
     *
     * @return $this
     */
    public function setPlansId($plans_id)
    {
        $this->plans_id = $plans_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getPlansId()
    {
        return $this->plans_id;
    }

    /**
     * @return \Flocc\Profile\Plans
     */
    public function getPlans()
    {
        return $this->hasOne('Flocc\Profile\Plans', 'id', 'plans_id')->first();
    }

    /**
     * @param int $vegetarian_id
     *
     * @return $this
     */
    public function setVegetarianId($vegetarian_id)
    {
        $this->vegetarian_id = $vegetarian_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getVegetarianId()
    {
        return $this->vegetarian_id;
    }

    /**
     * @return \Flocc\Profile\Vegetarian
     */
    public function getVegetarian()
    {
        return $this->hasOne('Flocc\Profile\Vegetarian', 'id', 'vegetarian_id')->first();
    }

    /**
     * @param int $flexibility_id
     *
     * @return $this
     */
    public function setFlexibilityId($flexibility_id)
    {
        $this->flexibility_id = $flexibility_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getFlexibilityId()
    {
        return $this->flexibility_id;
    }

    /**
     * @return \Flocc\Profile\Flexibility
     */
    public function getFlexibility()
    {
        return $this->hasOne('Flocc\Profile\Flexibility', 'id', 'flexibility_id')->first();
    }

    /**
     * @param int $plans_change_id
     *
     * @return $this
     */
    public function setPlansChangeId($plans_change_id)
    {
        $this->plans_change_id = $plans_change_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getPlansChangeId()
    {
        return $this->plans_change_id;
    }

    /**
     * @return \Flocc\Profile\PlansChange
     */
    public function getPlansChange()
    {
        return $this->hasOne('Flocc\Profile\PlansChange', 'id', 'plans_change_id')->first();
    }

    /**
     * @param int $verbosity_id
     *
     * @return $this
     */
    public function setVerbosityId($verbosity_id)
    {
        $this->verbosity_id = $verbosity_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getVerbosityId()
    {
        return $this->verbosity_id;
    }

    /**
     * @return \Flocc\Profile\Verbosity
     */
    public function getVerbosity()
    {
        return $this->hasOne('Flocc\Profile\Verbosity', 'id', 'verbosity_id')->first();
    }

    /**
     * @param int $vigor_id
     *
     * @return $this
     */
    public function setVigorId($vigor_id)
    {
        $this->vigor_id = $vigor_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getVigorId()
    {
        return $this->vigor_id;
    }

    /**
     * @return \Flocc\Profile\Vigor
     */
    public function getVigor()
    {
        return $this->hasOne('Flocc\Profile\Vigor', 'id', 'vigor_id')->first();
    }

    /**
     * @param int $cool_id
     *
     * @return $this
     */
    public function setCoolId($cool_id)
    {
        $this->cool_id = $cool_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getCoolId()
    {
        return $this->cool_id;
    }

    /**
     * @return \Flocc\Profile\Cool
     */
    public function getCool()
    {
        return $this->hasOne('Flocc\Profile\Cool', 'id', 'cool_id')->first();
    }

    /**
     * @param int $rules_id
     *
     * @return $this
     */
    public function setRulesId($rules_id)
    {
        $this->rules_id = $rules_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getRulesId()
    {
        return $this->rules_id;
    }

    /**
     * @return \Flocc\Profile\Rules
     */
    public function getRules()
    {
        return $this->hasOne('Flocc\Profile\Rules', 'id', 'rules_id')->first();
    }

    /**
     * @param int $opinions_id
     *
     * @return $this
     */
    public function setOpinionsId($opinions_id)
    {
        $this->opinions_id = $opinions_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getOpinionsId()
    {
        return $this->opinions_id;
    }

    /**
     * @return \Flocc\Profile\Opinions
     */
    public function getOpinions()
    {
        return $this->hasOne('Flocc\Profile\Opinions', 'id', 'opinions_id')->first();
    }

    /**
     * @param int $tolerance_id
     *
     * @return $this
     */
    public function setToleranceId($tolerance_id)
    {
        $this->tolerance_id = $tolerance_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getToleranceId()
    {
        return $this->tolerance_id;
    }

    /**
     * @return \Flocc\Profile\Tolerance
     */
    public function getTolerance()
    {
        return $this->hasOne('Flocc\Profile\Tolerance', 'id', 'tolerance_id')->first();
    }

    /**
     * @param int $compromise_id
     *
     * @return $this
     */
    public function setCompromiseId($compromise_id)
    {
        $this->compromise_id = $compromise_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getCompromiseId()
    {
        return $this->compromise_id;
    }

    /**
     * @return \Flocc\Profile\Compromise
     */
    public function getCompromise()
    {
        return $this->hasOne('Flocc\Profile\Compromise', 'id', 'compromise_id')->first();
    }

    /**
     * @param int $feelings_id
     *
     * @return $this
     */
    public function setFeelingsId($feelings_id)
    {
        $this->feelings_id = $feelings_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getFeelingsId()
    {
        return $this->feelings_id;
    }

    /**
     * @return \Flocc\Profile\Feelings
     */
    public function getFeelings()
    {
        return $this->hasOne('Flocc\Profile\Feelings', 'id', 'feelings_id')->first();
    }

    /**
     * @param int $emergency_id
     *
     * @return $this
     */
    public function setEmergencyId($emergency_id)
    {
        $this->emergency_id = $emergency_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getEmergencyId()
    {
        return $this->emergency_id;
    }

    /**
     * @return \Flocc\Profile\Emergency
     */
    public function getEmergency()
    {
        return $this->hasOne('Flocc\Profile\Emergency', 'id', 'emergency_id')->first();
    }

    /**
     * @return \Flocc\User\Features
     */
    public function getFeatures()
    {
        return $this->hasOne('Flocc\User\Features', 'user_id', 'user_id')->join('profiles_features', 'feature_id', '=', 'profiles_features.id')->get();
    }

    /**
     * @return array
     */
    public function getFeaturesIds()
    {
        return (new Features())->getIdsByUserId($this->getUserId());
    }

    /**
     * @return \Flocc\User\FreeTime
     */
    public function getFreeTime()
    {
        return $this->hasOne('Flocc\User\FreeTime', 'user_id', 'user_id')->join('profiles_free_time', 'free_time_id', '=', 'profiles_free_time.id')->get();
    }

    /**
     * @return array
     */
    public function getFreeTimeIds()
    {
        return (new FreeTime())->getIdsByUserId($this->getUserId());
    }

    /**
     * Get user scoring to event
     *
     * @param int $event_id
     *
     * @return int
     */
    public function getEventScoring($event_id)
    {
        return (new Events())->getById($event_id)->getUsersScoring($this->getUserId());
    }
}
