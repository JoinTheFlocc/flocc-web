<?php

namespace Flocc\Http\Controllers\Mail;

use Flocc\Http\Controllers\Controller;
use Flocc\Mail\Conversations;
use Flocc\Mail\NewMessage;
use Flocc\Mail\Users;
use Flocc\User;

/**
 * Class MessagesController
 *
 * @package Flocc\Http\Controllers\Mail
 */
class MessagesController extends Controller
{
    /**
     * Show messages from conversation
     *
     * @param int $conversation_id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showConversation($conversation_id)
    {
        /**
         * Sprawdzanie, czy taka konwersacja istnieje i czy mam do niej dostęp
         */
        $conversations  = new Conversations();
        $users          = new Users();

        if($users->isUserInConversation(\Auth::user()->id, $conversation_id) === false) {
            return \Redirect::to('mail');
        }

        /**
         * Mark as read
         */
        $users->markAsRead($conversation_id, \Auth::user()->id);

        return view('mail.messages.conversation', [
            'conversation' => $conversations->getById($conversation_id)
        ]);
    }

    /**
     * New message
     */
    public function newMessage()
    {
        $conversation_id    = \Input::get('conversation_id', null);
        $message            = \Input::get('message', '');
        $users              = \Input::get('users', []);

        /**
         * Odpowiedź
         */
        $id = (new NewMessage())
            ->setUserId(\Auth::user()->id)
            ->setConversationId($conversation_id)
            ->setMessage($message)
            ->setUsers($users)
        ->save();

        if($id === false) {
            return \Redirect::to('mail');
        }

        return \Redirect::to('mail/' . $id);
    }

    /**
     * New message form
     *
     * @param int $user_id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newMessageForm($user_id)
    {
        $users      = new User();
        $user_id    = (int) $user_id;
        $user       = $users->getById($user_id);

        if($user === null or \Auth::user()->id == $user_id) {
            return \Redirect::to('mail');
        }

        return view('mail.messages.new', [
            'user' => $user
        ]);
    }
}