<?php

namespace Flocc\Mail;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Conversations
 *
 * @package Flocc\Mail
 */
class Conversations extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mail_conversations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['conversation_id', 'start_time', 'last_message_time'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get conversation by ID
     *
     * @param int $conversation_id
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getById($conversation_id)
    {
        $conversation = self::where('conversation_id', (int) $conversation_id)->first();

        if($conversation !== null) {
            $conversation->users        = (new Users())->getUsersInConversation((int) $conversation_id);
            $conversation->messages     = (new Messages())->getFromConversation((int) $conversation_id);
        }

        return $conversation;
    }

    /**
     * Update conversation data
     *
     * @param int $conversation_id
     * @param array $data
     *
     * @return bool
     */
    public function updateConversation($conversation_id, array $data)
    {
        return (self::where('conversation_id', (int) $conversation_id)->update($data) == 1);
    }

    /**
     * Update conversation last message time
     *
     * @param int $conversation_id
     *
     * @return bool
     */
    public function updateLastMessageTime($conversation_id)
    {
        return $this->updateConversation($conversation_id, ['last_message_time' => \DB::raw('NOW()')]);
    }

    /**
     * New conversation
     *
     * @param NewMessage $message
     *
     * @return int
     */
    public function addNewConversation(\Flocc\Mail\NewMessage $message)
    {
        /**
         * mail_conversations
         */
        $conversation = new Conversations();

        $conversation->last_message_time = null;

        $conversation->save();

        /**
         * ID
         */
        $conversation_id = (int) \DB::getPdo()->lastInsertId();

        /**
         * User label
         */
        $labels = new Labels();

        /**
         * owner
         */
        $mail_users = new Users();

        $mail_users->conversation_id    = $conversation_id;
        $mail_users->user_id            = $message->getUserId();
        $mail_users->label_id           = $labels->getUserInboxID($message->getUserId());
        $mail_users->is_owner           = '1';

        $mail_users->save();

        /**
         * mail_users
         */
        foreach($message->getUsers() as $user_id) {
            if((int) $user_id != $message->getUserId()) {
                $mail_users = new Users();

                $mail_users->conversation_id    = $conversation_id;
                $mail_users->user_id            = (int) $user_id;
                $mail_users->label_id           = $labels->getUserInboxID($user_id);
                $mail_users->unread_messages    = 1;

                $mail_users->save();
            }
        }

        /**
         * mail_messages
         */
        $messages                   = new Messages();

        $messages->conversation_id  = $conversation_id;
        $messages->user_id          = $message->getUserId();
        $messages->message          = $message->getMessage();

        $messages->save();

        return (int) $conversation_id;
    }
}
