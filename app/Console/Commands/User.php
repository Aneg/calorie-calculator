<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class User extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {name} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Добавление нового пользователя';

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
        // TODO : Прикрутить валидацию и вынести её отдельно.
        $user           = new \App\Models\User();
        $user->name     = $this->argument('name');
        $user->email    = $this->argument('email');
        $user->password = bcrypt($this->argument('password'));

        if ($user->save()) {
            $this->table(['Имя', 'email', 'Пароль'], [[$user->name, $user->email, $user->password]]);
        } else {
            $this->error('Пользователь не добавлен.');
        }
    }
}
