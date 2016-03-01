<?php

namespace Flocc\Mail;

use Flocc\Notifications\Notifications;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Users
 *
 * @package Flocc\Mail
 */
class Users extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mail_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['conversation_id', 'user_id', 'label_id', 'is_owner', 'unread_messages'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get user conversations
     *
     * @param int $user_id
     * @param int $label_id
     *
     * @return \Illuminate\Support\Collection
     */
    public function getUserConversations($user_id, $label_id)
    {
        $data           = new Collection();
        $conversations  = self::where('mail_users.user_id', (int) $user_id)
            ->where('mail_labels.label_id', (int) $label_id)
            ->select('mail_users.conversation_id', 'mail_users.unread_messages', 'mail_conversations.last_message_time', 'mail_conversations.start_time', 'mail_users.is_important')
            ->join('mail_conversations', 'mail_conversations.conversation_id', '=', 'mail_users.conversation_id')
            ->join('mail_labels', 'mail_users.label_id', '=', 'mail_labels.label_id')
            ->orderBy('mail_users.is_important', 'desc')
            ->orderBy('mail_conversations.last_message_time', 'desc')
            ->take(10)
        ->get();

        /**
         * Get conversations members
         */
        foreach($conversations as $item) {
            $item->users    = $this->getUsersInConversation($item->conversation_id);
            $users_list     = [];

            foreach($item->users as $user) {
                if((int) $user->id != (int) $user_id) {
                    $users_list[] = $user->name;
                }
            }

            $item->users_list = implode(', ', $users_list);

            $data->push($item);
        }

        return $data;
    }

    /**
     * Get conversation members
     *
     * @param int $conversation_id
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUsersInConversation($conversation_id)
    {
        return self::where('conversation_id', (int) $conversation_id)
            ->select('users.id', 'users.name')
            ->join('users', 'mail_users.user_id', '=', 'users.id')
        ->get();
    }

    /**
     * User in conversation?
     *
     * @param int $user_id
     * @param int $conversation_id
     *
     * @return bool
     */
    public function isUserInConversation($user_id, $conversation_id)
    {
        return (self::where('user_id', (int) $user_id)->where('conversation_id', (int) $conversation_id)->first() === null) ? false : true;
    }

    /**
     * Update numbers of unread messages
     *
     * @param int $conversation_id
     * @param array $without_users
     *
     * @return int
     */
    public function updateUnreadMessages($conversation_id, array $without_users = [])
    {
        $users  = self::where('conversation_id', (int) $conversation_id)->get();
        $i      = 0;

        foreach($users as $user) {
            if(in_array($user->user_id, $without_users) === false) {
                $this->setUnreadMessagesNum($conversation_id, $user->user_id, $user->unread_messages+1);

                ++$i;
            }
        }

        return $i;
    }

    /**
     * Update data by conversation ID and user ID
     *
     * @param int $conversation_id
     * @param int $user_id
     * @param array $data
     *
     * @return bool
     */
    public function updateByConversationIdAndUserId($conversation_id, $user_id, array $data)
    {
        return (self::where('conversation_id', (int) $conversation_id)->where('user_id', (int) $user_id)->update($data) == 0) ? false : true;
    }

    /**
     * Set unread messages num
     *
     * @param int $conversation_id
     * @param int $user_id
     * @param int $unread_messages
     *
     * @return bool
     */
    public function setUnreadMessagesNum($conversation_id, $user_id, $unread_messages)
    {
        return $this->updateByConversationIdAndUserId($conversation_id, $user_id, [
            'unread_messages' => (int) $unread_messages
        ]);
    }

    /**
     * Mark conversation as read
     *
     * @param int $conversation_id
     * @param int $user_id
     *
     * @return bool
     */
    public function markAsRead($conversation_id, $user_id)
    {
        /**
         * Mark notification as read
         */
        (new Notifications())->markAsRead('mail.conversation.' . $conversation_id, $user_id);

        return $this->setUnreadMessagesNum($conversation_id, $user_id, 0);
    }

    /**
     * Update label ID
     *
     * @param int $conversation_id
     * @param int $user_id
     * @param int $label_id
     *
     * @return bool
     */
    public function updateLabelId($conversation_id, $user_id, $label_id)
    {
        return $this->updateByConversationIdAndUserId($conversation_id, $user_id, [
            'label_id' => (int) $label_id
        ]);
    }
}
