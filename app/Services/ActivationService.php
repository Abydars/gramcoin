<?php

namespace App\Services;

use App\Repositories\ActivationRepository;
use App\User;
use App\Notifications\ActivateNotification;

class ActivationService
{
    protected $mailer;

    protected $activationRepo;

    protected $resendAfter = 24;

    public function __construct(ActivationRepository $activationRepo)
    {
        $this->activationRepo = $activationRepo;
    }

    public function sendActivationMail($user)
    {
        if ($user->activated || !$this->shouldSend($user)) {
            return;
        }
        $this->notifyActivation($user);
    }

    public function forceSendActivationMail($user)
    {
        if ($user->activated) {
            return;
        }
        $this->notifyActivation($user);
    }

    protected function notifyActivation($user)
    {
        $token = $this->activationRepo->createActivation($user);
        $notification = new ActivateNotification($token);
        $user->notify($notification);
    }

    public function activateUser($token)
    {
        $activation = $this->activationRepo->getActivationByToken($token);

        if ($activation === null) {
            return null;
        }

        $user = User::find($activation->user_id);

        $user->activated = true;

        $user->save();

        $this->activationRepo->deleteActivation($token);

        return $user;
    }

    private function shouldSend($user)
    {
        $activation = $this->activationRepo->getActivation($user);

        return $activation === null || strtotime($activation->created_at) + 60 * 60 * $this->resendAfter < time();
    }
}
