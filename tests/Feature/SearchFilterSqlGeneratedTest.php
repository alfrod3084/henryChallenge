<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Helpers\NestedSearchFilter;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class SearchFilterSqlGeneratedTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_search_filter_return_sql_generated(): void
    {
        $filters = [
            "appointment.status" => "confirmed",
            "patient.name" => "John",
            "location.city" => "Dallas"
        ];
        $query = NestedSearchFilter::applyFilters(Appointment::query(), $filters);
        $sql = $query->toSql();
        $this->assertStringContainsString('select * from `appointment`', $sql);
        $this->assertStringContainsString('where `status` = ?', $sql);
        $this->assertStringContainsString('exists (select * from `patient`', $sql);
        $this->assertStringContainsString('exists (select * from `location`', $sql);
    }
}
