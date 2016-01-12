<?php

namespace Flocc\Mail;

use Flocc\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Labels
 *
 * @package Flocc\Mail
 */
class Labels extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mail_labels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['label_id', 'user_id', 'name', 'type'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * System labels
     */
    const TYPE_INBOX    = 'inbox';
    const TYPE_TRASH    = 'trash';
    const TYPE_ARCHIVE  = 'archive';

    /**
     * Get user label by user id and type
     *
     * @param int $user_id
     * @param string|null $type
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getLabelByUserIdAndType($user_id, $type)
    {
        return self::where('user_id', (int) $user_id)
            ->where('type', $type)
            ->take(1)
        ->first();
    }

    /**
     * Get INBOX label ID by user ID
     *
     * @param int $user_id
     *
     * @return int
     *
     * @throws \Exception
     */
    public function getUserInboxID($user_id)
    {
        $get = $this->getLabelByUserIdAndType($user_id, self::TYPE_INBOX);

        if($get === null) {
            throw new \Exception('Wrong User ID');
        }

        return (int) $get->label_id;
    }

    /**
     * Create defaults labels
     *
     * @param int $user_id
     *
     * @return bool
     */
    public function createDefaultLabels($user_id)
    {
        $i = 0;

        if((new User())->getById($user_id) !== null) {
            $i += self::create(['user_id' => (int) $user_id, 'name' => 'Inbox', 'type' => 'inbox']);
            $i += self::create(['user_id' => (int) $user_id, 'name' => 'Trash', 'type' => 'trash']);
            $i += self::create(['user_id' => (int) $user_id, 'name' => 'Archive', 'type' => 'archive']);
        }

        return ($i == 3);
    }
}