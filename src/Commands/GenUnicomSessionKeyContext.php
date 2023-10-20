<?php

namespace Oh86\SmCryptor\Commands;

use Illuminate\Console\Command;
use Oh86\SmCryptor\Facades\Cryptor;
use Oh86\SmCryptor\Impl\UnicomCryptor;
use Oh86\UnicomCryptor\Exceptions\CryptorException;

class GenUnicomSessionKeyContext extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sm:gen_unicom_session_key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成联通密码机会话密钥';

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
        $unicom = Cryptor::driver("unicom");
        if(!($unicom instanceof UnicomCryptor)){
            throw new \Exception("获取联通密码池对象错误");
        }

        var_dump($unicom->genSessionKeyContext());
    }
}