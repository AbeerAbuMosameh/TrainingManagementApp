<?php

namespace App\Http\Controllers\Traits;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Facades\Storage;

trait downloadUrtTrait
{
    //generate URL for each file or document stored in firebase
    function generateDownloadUrl($filePath){
        if (!empty($filePath)) {
            // Initialize Firebase Storage
            $firebaseCredentialsPath = storage_path(env('FIREBASE_CREDENTIALS_PATH'));

            $storage = new StorageClient([
                'projectId' => 'it-training-app-386209',
                'keyFilePath' => $firebaseCredentialsPath,
            ]);
            // Get the bucket name from the Firebase configuration or replace it with your bucket name
            $bucket = $storage->bucket('it-training-app-386209.appspot.com');

            // Generate the signed URL for the file
            $object = $bucket->object($filePath);
            $downloadUrl = $object->signedUrl(now()->addHour());

            return $downloadUrl;
        }

        return null;
    }

}
