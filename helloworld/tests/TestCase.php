<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    // Parallel DB 설정
    protected function setUp(): void
    {
        parent::setUp();

        // 병렬 프로세스에 따라 DB 연결을 동적으로 설정
        if (env('PARALLEL_PROCESS_NUMBER')) {
            $this->setupParallelDatabase();
        }
    }

    /**
     * Set up the parallel testing database.
     *
     * @return void
     */
    public function setupParallelDatabase(): void
    {
        // 병렬 테스트를 위한 데이터베이스 이름을 프로세스 ID 기반으로 설정
        $databaseName = 'test_database_' . env('PARALLEL_PROCESS_NUMBER');
        echo "Parallel Process Number: " . env('PARALLEL_PROCESS_NUMBER') . "\n";
        echo "Parallel Process Database: " . $databaseName . "\n";
        $this->app['config']->set('database.connections.mysql.database', $databaseName);

        // 프로세스별로 새로운 데이터베이스를 생성 (이미 존재하면 건너뜁니다)
        DB::statement("CREATE DATABASE IF NOT EXISTS $databaseName");
    }
}
