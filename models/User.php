<?php
/*
 * Copyright (c) 2022.
 * User: Fesdam
 * project: WizarFrameWork
 * Date Created: $file.created
 * 7/3/22, 3:50 AM
 * Last Modified at: 7/3/22, 3:50 AM
 * Time: 3:50
 * @author Wizarphics <Wizarphics@gmail.com>
 *
 */

namespace app\models;
use wizarphics\wizarframework\UserModel;

class User extends UserModel
{

    const STATUS_INACTIVE =0;
    const STATUS_ACTIVE =1;
    const STATUS_DELETED =2;

    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public int $status = self::STATUS_INACTIVE;
    public string $password = '';
    public string $passwordConfirm = '';

    public function save()
    {
        $this->status=self::STATUS_INACTIVE;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function rules(): array
    {
        return [
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                self::RULE_UNIQUE, 'class'=>self::class
            ]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
            'passwordConfirm' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];
    }

    public function tableName(): string
    {
        return 'users';
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return [
            'firstname',
            'lastname',
            'email',
            'password',
            'status'
        ];
    }

    public function labels(): array
    {
        return [
            'firstname'=>'First Name',
            'lastname'=>'Last Name',
            'email'=>'Email Address',
            'password'=>'Password',
            'passwordConfirm'=>'Confirm Password',
        ];
    }

    public function getDisplayName(): string
    {
        return $this->firstname.' '.$this->lastname;
    }
}