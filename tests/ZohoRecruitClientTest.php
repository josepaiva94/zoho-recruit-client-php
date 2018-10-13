<?php
/**
 * This file is part of the Apora.ZohoRecruitClient
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Apora\ZohoRecruitClient;

use Apora\ZohoRecruitClient\Response\Record;
use Apora\ZohoRecruitClient\Response\Result;
use PHPUnit\Framework\TestCase;

class ZohoRecruitClientTest extends TestCase
{
    const AUTH_TOKEN = 'ec6e8a84125e87634dc526944b3d2c6b';
    const MODULE = 'JobOpenings';

    const TEST_RECORD_ID = '30002000000987003';

    /**
     * @var ZohoRecruitClient
     */
    protected $zohoRecruitClient;

    protected function setUp()
    {
        $this->zohoRecruitClient = new ZohoRecruitClient(ZohoRecruitClientTest::MODULE, ZohoRecruitClientTest::AUTH_TOKEN);
    }

    public function testIsInstanceOfZohoRecruitClient()
    {
        $actual = $this->zohoRecruitClient;
        $this->assertInstanceOf(ZohoRecruitClient::class, $actual);
    }

    public function testGetRecords()
    {
        try {
            $actual = $this->zohoRecruitClient->getRecords()->request();
            $this->assertContainsOnlyInstancesOf(Record::class, $actual);
        } catch (Exception\UnexpectedValueException $e) {
            print $e->getMessage();
        }
    }

    public function testGetRecordById()
    {
        try {
            $actual = $this->zohoRecruitClient
                ->getRecordById(ZohoRecruitClientTest::TEST_RECORD_ID)
                ->request();
            $this->assertContainsOnlyInstancesOf(Record::class, $actual);
            $this->assertEquals(1, sizeof($actual));
            $this->assertEquals(ZohoRecruitClientTest::TEST_RECORD_ID, $actual[1]->get('JOBOPENINGID'));
        } catch (Exception\Exception $e) {
            print $e->getMessage();
        }
    }

    public function testAddRecords()
    {

        $actual = $this->zohoRecruitClient
            ->addRecords()
            ->addRecord(array(
                'Posting Title' => 'Software Engineer',
                'Department' => 'IT',
                'Assigned Recruiter' => 'Aniel Sriram',
                'Job description' => 'Test',
                'Client Name' => 'Test',
                'Company Description' => 'Mobile web and app development.',
                'Country' => 'Portugal'
            ))
            ->request();

        $this->assertContainsOnlyInstancesOf(Result::class, $actual);
        $this->assertEquals(1, sizeof($actual));
    }

    public function testUpdateRecords()
    {

        $actual = $this->zohoRecruitClient
            ->updateRecords()
            ->addRecord(array(
                'Id' => ZohoRecruitClientTest::TEST_RECORD_ID,
                'Posting Title' => 'Test'
            ))
            ->request();

        $this->assertContainsOnlyInstancesOf(Result::class, $actual);
        $this->assertEquals(1, sizeof($actual));
    }
}
