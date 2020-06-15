<?php

use Aws\Sdk;

$sharedConfig = [
    'region' => 'your-region-here',
    'version' => 'latest',
];
$sdk = new Sdk($sharedConfig);
$client =  $sdk->createS3();

return [
    'Filesystem' => [
        'default' => [
            'adapter' => 'Local', // default
            'adapterArguments' => [ WWW_ROOT . 'default_files' ],
            'normalizer' => [
                'hashingAlgo' => 'sha1',
            ],
        ],
        'local' => [
            'adapter' => 'Local',
            'adapterArguments' => [ WWW_ROOT . 'files' ],
            'entityClass' => 'App\Model\Entity\DocumentEdition',
        ],
        's3' => [
            'adapter' => '\League\Flysystem\AwsS3v3\AwsS3Adapter',
            'adapterArguments' => [
                $client,
                'your-bucket-name',
            ],
            'normalizer' => [
                'hashingAlgo' => 'sha1',
            ],
        ],
    ],
];
