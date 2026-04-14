<?php
namespace App\Services;

use InvalidArgumentException;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Messaging;
use RuntimeException;

class FirebaseService
{
    protected ?Messaging $messaging = null;

    public function __construct()
    {
        $credentialsPath = (string) config('firebase.credentials', config('services.firebase.credentials'));

        if ($credentialsPath === '') {
            throw new InvalidArgumentException(
                'Firebase credentials path is not configured. Set FIREBASE_CREDENTIALS in environment configuration.'
            );
        }

        if (! file_exists($credentialsPath)) {
            throw new RuntimeException(
                "Firebase credentials file not found at [{$credentialsPath}]."
            );
        }

        if (! is_readable($credentialsPath)) {
            throw new RuntimeException(
                "Firebase credentials file is not readable at [{$credentialsPath}]."
            );
        }

        $factory = (new Factory())->withServiceAccount($credentialsPath);
        $this->messaging = $factory->createMessaging();
    }

    public function sendNotification($deviceToken, $title, $body)
    {
        if ($this->messaging === null) {
            throw new RuntimeException('Firebase messaging client is not initialized.');
        }

        $message = CloudMessage::withTarget('token', $deviceToken)
            ->withNotification(['title' => $title, 'body' => $body]);

        return $this->messaging->send($message);
    }
}