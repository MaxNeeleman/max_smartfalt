<?php
    namespace Tests;

    use Orders;
    use PHPUnit\Framework\TestCase;
    use PDO;
    use PDOStatement;

    require_once('orders/order_orders.php');

    class test_orders extends TestCase
    {
        private $pdo;
        private $stmt;

        protected function setUp(): void
        {
            $this->pdo = $this->createMock(PDO::class);
            $this->stmt = $this->createMock(PDOStatement::class);
        }

        public function testFetchOrders()
        {
            $this->pdo->method('prepare')
                ->willReturn($this->stmt);
            $this->stmt->method('fetchAll')
                ->willReturn(['foo' => 'bar']);

            $orders = new Orders($this->pdo);
            $result = $orders->fetchOrders();

            $this->assertSame(['foo' => 'bar'], $result);
        }

        public function testCreateNewOrder()
        {
            $this->pdo->method('prepare')
                ->willReturn($this->stmt);
            $this->stmt->method('execute')
                ->willReturn(true);
        
            $orders = new Orders($this->pdo);
        
            $this->expectNotToPerformAssertions();
            $orders->createNewOrder(1, 1, date('Y-m-d H:i:s'));
        }
        

        public function testFetchInvoice()
        {
            $this->pdo->method('prepare')
                ->willReturn($this->stmt);
            $this->stmt->method('fetchAll')
                ->willReturn(['foo' => 'bar']);

            $orders = new Orders($this->pdo);
            $result = $orders->fetchInvoice();

            $this->assertSame(['foo' => 'bar'], $result);
        }

        public function testFetchAccounts()
        {
            $this->pdo->method('prepare')
                ->willReturn($this->stmt);
            $this->stmt->method('fetch')
                ->willReturn(['foo' => 'bar']);

            $orders = new Orders($this->pdo);
            $result = $orders->fetchAccounts();

            $this->assertSame(['foo' => 'bar'], $result);
        }
    }
