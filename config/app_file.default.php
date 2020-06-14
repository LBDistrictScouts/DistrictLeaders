<?php

use Aws\S3\S3Client;

$client = new S3Client([
    'credentials' => [
        'key' => '<<AWS_API_KEY>>',
        'secret' => '<<AWS_SECRET_KEY>>',
    ],
    'region' => '<<AWS_REGION>>',
    'version' => 'latest',
]);

return [
    'Filesystem' => [
        'default' => [
            'adapter' => '\League\Flysystem\AwsS3v3\AwsS3Adapter',
            'adapterArguments' => [
                $client,
                '<<S3_BUCKET_NAME>>',
            ],
            'normalizer' => [
                'hashingAlgo' => 'sha1',
            ],
            'entityClass' => 'App\Model\Entity\DocumentEdition',
        ],
        'local' => [
            'adapter' => 'Local',
            'adapterArguments' => [ WWW_ROOT . 'files' ],
            'entityClass' => 'App\Model\Entity\DocumentEdition',
        ],
        'cache' => [
            'adapter' => 'Local',
            'adapterArguments' => [ WWW_ROOT . 'cached' ],
        ],
    ],

    'CloudConvert' => [
        'api_key' => '<<CLOUD_CONVERT_API_KEY>>',
        's3' => [
            'key' => '<<AWS_API_KEY>>',
            'secret' => '<<AWS_SECRET_KEY>>',
            'region' => '<<AWS_REGION>>',
            'bucket' => '<<S3_BUCKET_NAME>>',
        ],
    ],
];
