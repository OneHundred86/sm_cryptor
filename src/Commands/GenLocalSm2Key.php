<?php

namespace Oh86\SmCryptor\Commands;

use Illuminate\Console\Command;
use Oh86\Sm\Sm2;

class GenLocalSm2Key extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sm:gen_local_sm2_key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成本地sm2密钥';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sm2 = new Sm2('hex', false);
        [$privateKey, $publicKey] = $sm2->generatekey();
        echo sprintf("SM2_PRIVATE_KEY=%s\nSM2_PUBLIC_KEY=%s\n", $privateKey, $publicKey);
    }
}
