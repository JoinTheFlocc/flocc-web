<?php

namespace Flocc\Http\Controllers\Mail;

use Flocc\Http\Controllers\Controller;
use Flocc\Mail\Labels;
use Flocc\Mail\Users;

/**
 * Class ConversationsController
 *
 * @package Flocc\Http\Controllers\Mail
 */
class ConversationsController extends Controller
{
    /**
     * Conversations list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function conversationsList($label = null)
    {
        $users     = new Users();
        $labels    = new Labels();

        switch($label) {
            case 'trash':   $label_type = Labels::TYPE_TRASH; break;
            default:        $label_type = Labels::TYPE_INBOX;
        }

        $label_id       = $labels->getLabelByUserIdAndType(\Auth::user()->id, $label_type);

        if($label_id === null) {
            $label_id = $labels->getUserInboxID(\Auth::user()->id);
        } else {
            $label_id = $label_id->label_id;
        }

        $conversations  = $users->getUserConversations(\Auth::user()->id, $label_id);

        return view('mail.conversations.list', [
            'conversations' => $conversations,
            'label'         => $label_type
        ]);
    }

    /**
     * Move conversation
     *
     * @param int $conversation_id
     * @param string $label
     */
    public function moveToLabel($conversation_id, $label)
    {
        $users              = new Users();
        $labels             = new Labels();

        $available_labels   = [Labels::TYPE_INBOX, Labels::TYPE_TRASH, Labels::TYPE_ARCHIVE];

        /**
         * Wrong label
         */
        if(in_array($label, $available_labels) === false) {
            return \Redirect::to('mail');
        }

        /**
         * Wrong conversation ID
         */
        if($users->isUserInConversation(\Auth::user()->id, $conversation_id) === false) {
            return \Redirect::to('mail');
        }

        $label_id = $labels->getLabelByUserIdAndType(\Auth::user()->id, $label);

        if($label_id === null) {
            $label_id = $labels->getUserInboxID(\Auth::user()->id);
        } else {
            $label_id = $label_id->label_id;
        }

        $users->updateLabelId($conversation_id, \Auth::user()->id, $label_id);

        return \Redirect::to('mail/l/' . $label);
    }
}