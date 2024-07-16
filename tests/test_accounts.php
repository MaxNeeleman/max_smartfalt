<?php 
    namespace Tests;

    use App\Accounts;
    use PHPUnit\Framework\TestCase;
    use PDO;
    use PDOStatement;


    require_once('admin/functions.php');

    class test_accounts extends TestCase
    {
        public function testGetAccounts()
        {
            // MOCK CONNECTION -> Using getMockBuilder 
            // -> https://stackoverflow.com/questions/38363086/what-is-the-difference-between-createmock-and-getmockbuilder-in-phpunit
            // -> https://jtreminio.com/blog/unit-testing-tutorial-part-v-mock-methods-and-overriding-constructors/
            $stmt = $this->createMock(PDOStatement::class);

            $stmt->method('fetchAll')
            ->willReturn([
                ['AccountId' => '1', 'Username' => 'TestUser1', 'ProfilePicture' => 'Pic1'],
                ['AccountId' => '2', 'Username' => 'TestUser2', 'ProfilePicture' => 'Pic2']
            ]);

            $pdo = $this->createMock(PDO::class);

            $pdo->method('prepare')
            ->willReturn($stmt);

            $functions = new \Accounts($pdo);
            $accounts = $functions->getAccounts();

            // https://www.geeksforgeeks.org/phpunit-assertequals-function/
            $this->assertEquals([
                ['AccountId' => '1', 'Username' => 'TestUser1', 'ProfilePicture' => 'Pic1'],
                ['AccountId' => '2', 'Username' => 'TestUser2', 'ProfilePicture' => 'Pic2']
            ], $accounts);
        }

        public function testCreateAccount()
        {
            // MOCK CONNECTION -> Using getMockBuilder
            $pdo = $this->createMock(PDO::class);
            $stmt = $this->createMock(PDOStatement::class);
    
            $pdo->method('prepare')
                ->willReturn($stmt);
    
            $stmt->method('bindValue')
                ->willReturn(true);
    
            $stmt->method('execute')
                ->willReturn(true);
    
            $accountDetails = [
                'username' => 'test_user',
                'password' => 'test_password',
                'firstname' => 'Pietje',
                'lastname' => 'Puk',
                'gender' => 'M',
                'address' => 'PHP Unittest-erf 12',
                'city' => 'Composer Town',
                'zip' => '1200AA',
                'dob' => '1990-01-01',
                'mail' => 'pietje@pukplein.nu',
                'phone' => '0612345678',
                'iban' => 'NL42ABNA0123456789',
                'role' => '1',
            ];
    
            $accounts = new \Accounts($pdo);
            $this->assertTrue($accounts->createAccount($accountDetails));
        }
    
        public function testDeleteAccount()
        {
            // MOCK CONNECTION -> Using getMockBuilder
            $pdo = $this->createMock(PDO::class);
            $stmt = $this->createMock(PDOStatement::class);
    
            $pdo->method('prepare')
                ->willReturn($stmt);
    
            $stmt->method('bindParam')
                ->willReturn(true);
    
            $stmt->method('execute')
                ->willReturn(true);
    
            $accounts = new \Accounts($pdo);
            $this->assertTrue($accounts->deleteAccount(1));
        }
    }
