<?php
    require_once('vendor/autoload.php');
    use MicrosoftAzure\Storage\Blob\BlobRestProxy;
    use MicrosoftAzure\Storage\Blob\BlobSharedAccessSignatureHelper;
    use MicrosoftAzure\Storage\Common\Internal\StorageServiceSettings;
    use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
    use MicrosoftAzure\Storage\Common\Internal\Resources;
    use MicrosoftAzure\Storage\Blob;

    function file_upload_blob($container,$fileName,$file)
    {
        $filetoUpload = realpath($file);
        $blobClient = BlobRestProxy::createBlobService(BLOB_CONNECTION_STRG);
        $content = fopen($filetoUpload, "r");
    
        try {
            //Upload blob
            $blobClient->createBlockBlob($container, $fileName, $content);
            return true;
        }
        catch (ServiceException $e) {
            $code = $e->getCode();
            $error_message = $e->getMessage();
            $errorDetails = array (
                'status' => false,
                'error'  => $code.": ".$error_message
            );
            // return $code.": ".$error_message.PHP_EOL;
            return $errorDetails;
        }
    }

    function get_blob_file($container,$fileName)
    {
        $blobClient = MicrosoftAzure\Storage\Blob\BlobRestProxy::createBlobService(BLOB_CONNECTION_STRG);
        $sas_helper = new MicrosoftAzure\Storage\Blob\BlobSharedAccessSignatureHelper(BLOB_STORAGE_ACCOUNT, BLOB_ACCESS_KEY);
        $sas = $sas_helper->generateBlobServiceSharedAccessSignatureToken(
            Resources::RESOURCE_TYPE_BLOB,                  # Resource name to generate canonicalized resource.
            "{$container}/{$fileName}",                     # The name of the resource, including the path of the resource.
            "r",                                            # Signed permissions.
            (new \DateTime())->modify('+5 minute'),         # Signed expiry
            (new \DateTime())->modify('-1 minute'),         # Signed start
            '',                                             # Signed IP, the range of IP addresses from which a request will be accepted, eg. "168.1.5.60-168.1.5.70"
            'https',                                        # Signed protocol, should always be https
        );
        return "https://".BLOB_STORAGE_ACCOUNT.".blob.core.windows.net/{$container}/{$fileName}?{$sas}";
    }


    function file_upload_blob_php($fileName,$path,$folderName)
    {
        // _print_r($fileName,1);
        $accesskey = "7efbKcwB+O8M+uHYf2N2Uk7O9KAj/pa+DcQIs9NAmEMb2IHG8UWtTvmlqCE1FkeWgHoUdlEEoT+O+ASt+kqRkA==";
        $storageAccount = 'legalagreement';
        $filetoUpload = realpath($path);
        // $containerName = 'ikrarfiles';
        $containerName = $folderName;
        $blobName = $fileName;

        $destinationURL = "https://$storageAccount.blob.core.windows.net/$containerName/$blobName";

        // _print_r($filetoUpload,1);
        $currentDate = gmdate("D, d M Y H:i:s T", time());
        $handle = fopen($filetoUpload, "r");
        $fileLen = filesize($filetoUpload);

        $headerResource = "x-ms-blob-cache-control:max-age=3600\nx-ms-blob-type:BlockBlob\nx-ms-date:$currentDate\nx-ms-version:2015-12-11";
        $urlResource = "/$storageAccount/$containerName/$blobName";

        $arraysign = array();
        $arraysign[] = 'PUT';               /*HTTP Verb*/  
        $arraysign[] = '';                  /*Content-Encoding*/  
        $arraysign[] = '';                  /*Content-Language*/  
        $arraysign[] = $fileLen;            /*Content-Length (include value when zero)*/  
        $arraysign[] = '';                  /*Content-MD5*/  
        $arraysign[] = 'application/pdf';   /*Content-Type*/  
        $arraysign[] = '';                  /*Date*/  
        $arraysign[] = '';                  /*If-Modified-Since */  
        $arraysign[] = '';                  /*If-Match*/  
        $arraysign[] = '';                  /*If-None-Match*/  
        $arraysign[] = '';                  /*If-Unmodified-Since*/  
        $arraysign[] = '';                  /*Range*/  
        $arraysign[] = $headerResource;     /*CanonicalizedHeaders*/
        $arraysign[] = $urlResource;        /*CanonicalizedResource*/

        $str2sign = implode("\n", $arraysign);

        $sig = base64_encode(hash_hmac('sha256', urldecode(utf8_encode($str2sign)), base64_decode($accesskey), true));  
        $authHeader = "SharedKey $storageAccount:$sig";

        $headers = [
            'Authorization: ' . $authHeader,
            'x-ms-blob-cache-control: max-age=3600',
            'x-ms-blob-type: BlockBlob',
            'x-ms-date: ' . $currentDate,
            'x-ms-version: 2015-12-11',
            'Content-Type: application/pdf',
            'Content-Length: ' . $fileLen
        ];

        $ch = curl_init($destinationURL);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_INFILE, $handle); 
        curl_setopt($ch, CURLOPT_INFILESIZE, $fileLen); 
        curl_setopt($ch, CURLOPT_UPLOAD, true); 
        $result = curl_exec($ch);
        curl_close($ch);
        _print_r($result,1);
        return $destinationURL;
    }
?>