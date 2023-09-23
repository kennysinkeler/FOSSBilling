<?php


namespace Box\Mod\Client\Api;


class GuestTest extends \BBTestCase
{

    public function testgetDi()
    {
        $di = new \Pimple\Container();
        $client = new \Box\Mod\Client\Api\Guest();
        $client->setDi($di);
        $getDi = $client->getDi();
        $this->assertEquals($di, $getDi);
    }

    public function testcreate()
    {
        $configArr = array(
            'disable_signup' => false,
            'required' => array(),
        );
        $data = array(
            'email' => 'test@email.com',
            'first_name' => 'John',
            'password' => 'testpaswword',
            'password_confirm' => 'testpaswword',

        );

        $serviceMock = $this->getMockBuilder('\Box\Mod\Client\Service')->getMock();
        $serviceMock->expects($this->atLeastOnce())
            ->method('clientAlreadyExists')
            ->will($this->returnValue(false));

        $model = new \Model_Client();
        $model->loadBean(new \DummyBean());
        $model->id = 1;

        $serviceMock->expects($this->atLeastOnce())
            ->method('guestCreateClient')
            ->will($this->returnValue($model));
        $serviceMock->expects($this->atLeastOnce())
            ->method('checkExtraRequiredFields');
        $serviceMock->expects($this->atLeastOnce())
            ->method('checkCustomFields');


        $validatorMock = $this->getMockBuilder('\FOSSBilling\Validate')->getMock();
        $validatorMock->expects($this->atLeastOnce())->method('isPasswordStrong');
        $validatorMock->expects($this->atLeastOnce())->method('checkRequiredParamsForArray');
        $toolsMock = $this->getMockBuilder('\FOSSBilling\Tools')->getMock();
        $toolsMock->expects($this->atLeastOnce())->method('validateAndSanitizeEmail');


        $di = new \Pimple\Container();
        $di['mod_config'] = $di->protect(function ($name) use ($configArr) {
            return $configArr;
        });
        $di['validator'] = $validatorMock;
        $di['tools'] = $toolsMock;

        $client = new \Box\Mod\Client\Api\Guest();
        $client->setDi($di);
        $client->setService($serviceMock);

        $result = $client->create($data);

        $this->assertIsInt($result);
        $this->assertEquals($model->id, $result);
    }

    public function testcreateExceptionClientExists()
    {
        $configArr = array(
            'disable_signup' => false,
        );
        $data = array(
            'email' => 'test@email.com',
            'first_name' => 'John',
            'password' => 'testpaswword',
            'password_confirm' => 'testpaswword',

        );

        $serviceMock = $this->getMockBuilder('\Box\Mod\Client\Service')->getMock();
        $serviceMock->expects($this->atLeastOnce())
            ->method('clientAlreadyExists')
            ->will($this->returnValue(true));
        $serviceMock->expects($this->atLeastOnce())
            ->method('checkExtraRequiredFields');
        $serviceMock->expects($this->atLeastOnce())
            ->method('checkCustomFields');

        $model = new \Model_Client();
        $model->loadBean(new \DummyBean());

        $validatorMock = $this->getMockBuilder('\FOSSBilling\Validate')->getMock();
        $validatorMock->expects($this->atLeastOnce())->method('isPasswordStrong');
        $validatorMock->expects($this->atLeastOnce())->method('checkRequiredParamsForArray');

        $di = new \Pimple\Container();
        $di['mod_config'] = $di->protect(function ($name) use ($configArr) {
            return $configArr;
        });
        $di['validator'] = $validatorMock;

        $toolsMock = $this->getMockBuilder('\FOSSBilling\Tools')->getMock();
        $toolsMock->expects($this->atLeastOnce())->method('validateAndSanitizeEmail');
        $di['tools'] = $toolsMock;

        $client = new \Box\Mod\Client\Api\Guest();
        $client->setDi($di);
        $client->setService($serviceMock);

        $this->expectException(\Box_Exception::class);
        $this->expectExceptionMessage('Email is already registered. You may want to login instead of registering.');
        $client->create($data);
    }

    public function testCreateSignupDoNotAllowed()
    {
        $configArr = array(
            'disable_signup' => true,
        );
        $data = array(
            'email' => 'test@email.com',
            'first_name' => 'John',
            'password' => 'testpaswword',
            'password_confirm' => 'testpaswword',

        );

        $client = new \Box\Mod\Client\Api\Guest();
        $di = new \Pimple\Container();
        $di['mod_config'] = $di->protect(function ($name) use ($configArr) {
            return $configArr;
        });
        $client->setDi($di);

        $this->expectException(\Box_Exception::class);
        $this->expectExceptionMessage('New registrations are temporary disabled');
        $client->create($data);
    }

    public function testCreatePasswordsDoNotMatchException()
    {
        $configArr = array(
            'disable_signup' => false,
        );
        $data = array(
            'email' => 'test@email.com',
            'first_name' => 'John',
            'password' => 'testpaswword',
            'password_confirm' => 'wrongpaswword',
        );

        $validatorMock = $this->getMockBuilder('\FOSSBilling\Validate')->getMock();
        $validatorMock->expects($this->atLeastOnce())->method('checkRequiredParamsForArray');

        $client = new \Box\Mod\Client\Api\Guest();
        $di = new \Pimple\Container();
        $di['mod_config'] = $di->protect(function ($name) use ($configArr) {
            return $configArr;
        });
        $di['validator'] = $validatorMock;
        $client->setDi($di);

        $this->expectException(\Box_Exception::class);
        $this->expectExceptionMessage('Passwords do not match.');
        $client->create($data);
    }

    public function testlogin()
    {
        $data = array(
            'email' => 'test@example.com',
            'password' => 'sezam',
        );

        $model = new \Model_Client();
        $model->loadBean(new \DummyBean());

        $serviceMock = $this->getMockBuilder('\Box\Mod\Client\Service')->getMock();
        $serviceMock->expects($this->atLeastOnce())
            ->method('authorizeClient')
            ->with($data['email'], $data['password'])
            ->will($this->returnValue($model));
        $serviceMock->expects($this->atLeastOnce())
            ->method('toSessionArray')
            ->will($this->returnValue(array()));

        $eventMock = $this->getMockBuilder('\Box_EventManager')->getMock();
        $eventMock->expects($this->atLeastOnce())->method('fire');

        $sessionMock = $this->getMockBuilder('\FOSSBilling\Session')
            ->disableOriginalConstructor()
            ->getMock();

        $sessionMock->expects($this->atLeastOnce())
            ->method("set");

        $toolsMock = $this->getMockBuilder('\FOSSBilling\Tools')->getMock();
        //$toolsMock->expects($this->atLeastOnce())->method('validateAndSanitizeEmail');

        $validatorMock = $this->getMockBuilder('\FOSSBilling\Validate')->disableOriginalConstructor()->getMock();
        $validatorMock->expects($this->atLeastOnce())
            ->method('checkRequiredParamsForArray')
            ->will($this->returnValue(null));

        $di = new \Pimple\Container();
        $di['events_manager'] = $eventMock;
        $di['session'] = $sessionMock;
        $di['logger'] = new \Box_Log();
        $di['validator'] = $validatorMock;
        $di['tools'] = $toolsMock;

        $client = new \Box\Mod\Client\Api\Guest();
        $client->setDi($di);
        $client->setService($serviceMock);

        $results = $client->login($data);

        $this->assertIsArray($results);
    }

    public function testResetPasswordNewFlow()
    {
        $data['email'] = 'John@exmaple.com';
    
        $eventMock = $this->getMockBuilder('\Box_EventManager')->getMock();
        $eventMock->expects($this->atLeastOnce())->method('fire');
    
        $modelClient = new \Model_Client();
        $modelClient->loadBean(new \DummyBean());
    
        $modelPasswordReset = new \Model_ClientPasswordReset();
        $modelPasswordReset->loadBean(new \DummyBean());
    
        $dbMock = $this->getMockBuilder('\Box_Database')->getMock();
    
        // Specify that 'findOne' will be called exactly twice
        $dbMock->expects($this->exactly(2))->method('findOne')
            ->willReturnOnConsecutiveCalls($modelClient, null);
    
        $dbMock->expects($this->once())
            ->method('dispense')->will($this->returnValue($modelPasswordReset));
    
        $dbMock->expects($this->atLeastOnce())
            ->method('store')->will($this->returnValue(1));
    
        $emailServiceMock = $this->getMockBuilder('\Box\Mod\Email\Service')->getMock();
        $emailServiceMock->expects($this->atLeastOnce())->method('sendTemplate');
    
        $toolsMock = $this->getMockBuilder('\FOSSBilling\Tools')->getMock();
        $toolsMock->expects($this->once())
            ->method('validateAndSanitizeEmail')->will($this->returnValue($data['email']));
    
        $validatorMock = $this->getMockBuilder('\FOSSBilling\Validate')->disableOriginalConstructor()->getMock();
        $validatorMock->expects($this->once())
            ->method('checkRequiredParamsForArray')->will($this->returnValue(null));
    
        $di = new \Pimple\Container();
        $di['db'] = $dbMock;
        $di['events_manager'] = $eventMock;
        $di['mod_service'] = $di->protect(function ($name) use($emailServiceMock) {return $emailServiceMock;});
        $di['logger'] = new \Box_Log();
        $di['tools'] = $toolsMock;
        $di['validator'] = $validatorMock;
    
        $client = new \Box\Mod\Client\Api\Guest();
        $client->setDi($di);
    
        $result = $client->reset_password($data);
        $this->assertTrue($result);
    }
    



    public function testreset_passwordEmailNotFound()
    {
        $data['email'] = 'joghn@example.eu';

        $eventMock = $this->getMockBuilder('\Box_EventManager')->getMock();
        $eventMock->expects($this->atLeastOnce())->method('fire');

        $dbMock = $this->getMockBuilder('\Box_Database')->getMock();
        $dbMock->expects($this->atLeastOnce())
            ->method('findOne')->will($this->returnValue(null));

        $di = new \Pimple\Container();
        $di['db'] = $dbMock;
        $di['events_manager'] = $eventMock;
        $validatorMock = $this->getMockBuilder('\FOSSBilling\Validate')->disableOriginalConstructor()->getMock();
        $validatorMock->expects($this->atLeastOnce())
            ->method('checkRequiredParamsForArray')
            ->will($this->returnValue(null));
        $di['validator'] = $validatorMock;

        $toolsMock = $this->getMockBuilder('\FOSSBilling\Tools')->getMock();
        $toolsMock->expects($this->atLeastOnce())->method('validateAndSanitizeEmail');
        $di['tools'] = $toolsMock;

        $client = new \Box\Mod\Client\Api\Guest();
        $client->setDi($di);

        // expects true because we don't want to give away if the email exists or not
        $result = $client->reset_password($data);
        $this->assertTrue($result);
    }

    public function testUpdatePassword()
    {
        $data = array(
            'hash' => 'hashedString',
            'password' => 'newPassword',
            'password_confirm' => 'newPassword'
        );


        // Mocks for dependent services and classes
        $dbMock = $this->getMockBuilder('\Box_Database')->getMock();

        $modelClient = new \Model_Client();
        $modelClient->loadBean(new \DummyBean());

        $modelPasswordReset = new \Model_ClientPasswordReset();
        $modelPasswordReset->loadBean(new \DummyBean());
        $modelPasswordReset->created_at = date('Y-m-d H:i:s', time() - 300);  // Set timestamp to 5 minutes ago

        $dbMock->expects($this->once())
            ->method('findOne')->will($this->returnValue($modelPasswordReset));

        $dbMock->expects($this->once())
            ->method('getExistingModelById')->will($this->returnValue($modelClient));

        $dbMock->expects($this->once())
            ->method('store');

        $dbMock->expects($this->once())
            ->method('trash');

        $eventMock = $this->getMockBuilder('\Box_EventManager')->getMock();
        $eventMock->expects($this->exactly(2))
            ->method('fire');

        $passwordMock = $this->getMockBuilder('\Box_Password')->getMock();
        $passwordMock->expects($this->once())
            ->method('hashIt');

        $validatorMock = $this->getMockBuilder('\FOSSBilling\Validate')->disableOriginalConstructor()->getMock();
        $validatorMock->expects($this->once())
            ->method('checkRequiredParamsForArray')
            ->will($this->returnValue(null));

        $emailServiceMock = $this->getMockBuilder('\Box\Mod\Email\Service')->getMock();
        $emailServiceMock->expects($this->once())
            ->method('sendTemplate');

        $di = new \Pimple\Container();
        $di['db'] = $dbMock;
        $di['events_manager'] = $eventMock;
        $di['password'] = $passwordMock;
        $di['validator'] = $validatorMock;
        $di['logger'] = new \Box_Log();
        $di['mod_service'] =  $di->protect(function ($name) use ($emailServiceMock) {
            return $emailServiceMock;
        });

        $client = new \Box\Mod\Client\Api\Guest();
        $client->setDi($di);

        $result = $client->update_password($data);
        $this->assertTrue($result);
    }

    public function testUpdatePasswordResetNotFound()
    {
        $data = array(
            'hash' => 'hashedString',
            'password' => 'newPassword',
            'password_confirm' => 'newPassword'
        );

        // Mock for the database service
        $dbMock = $this->getMockBuilder('\Box_Database')->getMock();
        $dbMock->expects($this->once())
            ->method('findOne')->will($this->returnValue(null));

        // Mock for the events manager
        $eventMock = $this->getMockBuilder('\Box_EventManager')->getMock();
        $eventMock->expects($this->once())
            ->method('fire');

        // Mock for the validator
        $validatorMock = $this->getMockBuilder('\FOSSBilling\Validate')->disableOriginalConstructor()->getMock();
        $validatorMock->expects($this->once())
            ->method('checkRequiredParamsForArray')
            ->will($this->returnValue(null));

        // Dependency injection container setup
        $di = new \Pimple\Container();
        $di['db'] = $dbMock;
        $di['events_manager'] = $eventMock;
        $di['validator'] = $validatorMock;

        $client = new \Box\Mod\Client\Api\Guest();
        $client->setDi($di);

        // Expect a Box_Exception to be thrown with a specific message
        $this->expectException(\Box_Exception::class);
        $this->expectExceptionMessage('The link has expired or you have already reset your password.');
        $client->update_password($data);
    }


    public function testrequired()
    {
        $configArr = array();

        $di = new \Pimple\Container();
        $di['mod_config'] = $di->protect(function ($name) use ($configArr) {
            return $configArr;
        });

        $client = new \Box\Mod\Client\Api\Guest();
        $client->setDi($di);

        $result = $client->required();
        $this->assertIsArray($result);
    }
}
