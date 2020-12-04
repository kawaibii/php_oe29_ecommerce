<?php

namespace App\Service;

use Kreait\Firebase\Factory;

class FirebaseService
{
    protected $database;

    protected $firebase;

    function __construct()
    {
        $firebase = (new Factory)->withServiceAccount([
            "type" => "service_account",
            "project_id" => config('services.firebase.project_id'),
            "private_key_id" => config('services.firebase.private_key_id'),
            "private_key" => config('services.firebase.private_key'),
            "client_email" => config('services.firebase.client_email'),
            "client_id" => config('services.firebase.client_id'),
            "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
            "token_uri" => "https://oauth2.googleapis.com/token",
            "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
            "client_x509_cert_url" => config('services.firebase.client_x509_cert_url'),
        ]);
        $this->database = $firebase->createDatabase();
    }

    public function getDatabase()
    {
        return $this->database;
    }

    public function sendNotificationOrderPending($id, $notification)
    {
        return $this->database->getReference('user/' . $id)->set($notification);
    }

    public function updateNotificationOrder($id, $notification)
    {
        return $this->database->getReference('user/' . $id)->update($notification);
    }
}
