<?php

namespace Flocc\Mail;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Messages
 *
 * @package Flocc\Mail
 */
class Messages extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mail_messages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['message_id', 'conversation_id', 'user_id', 'sent_time', 'read_time', 'message'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get conversation messages
     *
     * @param int $conversation_id
     * @param int $limit
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFromConversation($conversation_id, $limit = 50)
    {
        return self::where('conversation_id', (int) $conversation_id)
            ->select('message_id', 'mail_messages.user_id', 'sent_time', 'read_time', 'message', 'users.name')
            ->join('users', 'mail_messages.user_id', '=', 'users.id')
            ->orderBy('mail_messages.message_id')
            ->take((int) $limit)
        ->get();
    }

    /**
     * Add new message
     *
     * @param NewMessage $message
     *
     * @return int
     */
    public function addNewMessage(\Flocc\Mail\NewMessage $message)
    {
        /**
         * mail_messages
         */
        $messages = new Messages();

        $messages->conversation_id  = $message->getConversationId();
        $messages->user_id          = $message->getUserId();
        $messages->message          = $message->getMessage();

        $messages->save();

        /**
         * mail_conversations
         */
        (new Conversations())->updateLastMessageTime($message->getConversationId());

        /**
         * mail_users
         */
        (new Users())->updateUnreadMessages($message->getConversationId(), [$message->getUserId()]);

        return $message->getConversationId();
    }
}
