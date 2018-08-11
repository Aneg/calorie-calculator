<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Команда для создания нового пользователя
 *
 * Class User
 * @package App\Console\Commands
 */
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
        $validator = \Validator::make($this->arguments(), [
            'name'     => 'required|string|max:100',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|max:16',
        ]);

        if ($validator->fails()) {
            $this->error('Пользователь не добавлен.');
            $this->table([array_keys((array)$validator->errors()->messages())], $validator->errors()->messages());
            return;
        }

        $user = new \App\Models\User($this->arguments());
        $user->password = \Hash::make($user->password);

        if ($user->save()) {
            $this->table(['Имя', 'email', 'Пароль'], [[$user->name, $user->email, $this->argument('password')]]);
        } else {
            $this->error('Пользователь не добавлен.');
        }
    }
}
