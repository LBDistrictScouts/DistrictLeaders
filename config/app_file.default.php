<?php
use \Aws\S3\S3Client;

$client = S3Client::factory([
    'credentials' => [
        'key' => 'your-key-here',
        'secret' => 'your-secret-key-here',
    ],
    'region' => 'your-region-here',
    'version' => 'latest',
]);

return [
    'Filesystem' => [
        'default' => [
            'adapter' => 'Local', // default
            'adapterArguments' => [ WWW_ROOT . 'files' ],
            'normalizer' => [
                'hashingAlgo' => 'sha1'
            ],
        ],
        'other' => [
            'adapter' => 'Local',
            'adapterArguments' => [ WWW_ROOT . 'cache' ],
            'entityClass' => '\My\Cool\EntityClass',
            'formatter' => '\My\Cool\Formatter',
            'normalizer' => [
                'hashingAlgo' => 'sha1'
            ],
        ],
        's3' => [
            'adapter' => '\League\Flysystem\AwsS3v3\AwsS3Adapter',
            'adapterArguments' => [
                $client,
                'your-bucket-name',
            ],
            'normalizer' => [
                'hashingAlgo' => 'sha1'
            ],
        ],
    ],

    'CloudConvert' => [
        'api_key' => '__INSERT_CLOUD_CONVERT_API_KEY_HERE__',
        's3' => [
            'key' => '__INSERT_CC_S3_IAM_KEY__',
            'secret' => '__INSERT_CC_S3_IAM_SECRET__',
            'region' => 'eu-west-1',
            'bucket' => '__INSERT_BUCKET_ADDRESS_HERE__'
        ]
    ],
];
